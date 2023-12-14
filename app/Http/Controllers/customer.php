<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer_model;
use App\Models\payments;
use App\Models\posts_model;
use App\Models\tags_model;
use Illuminate\Support\Facades\DB;

class customer extends Controller
{
    public $searchable = ['name', 'email'];
    public $orderable = ['name', 'email'];
    function get_customer()
    {
        DB::enableQueryLog();
        $a = Customer_model::with(['payments' => function ($q) {
            $q->select(['customer_id', 'amount']);
        }, 'payments.customer' => function ($q) {
            $q->select(['id', 'name']);
        }])->limit(10)->get();
        dd(DB::getQueryLog());
        return $a;
    }

    function get_posts() {
        $data['posts'] = posts_model::with(['tags,customers'])->get();
        return view('posts',$data);
    }

    function get_user_likes() {
        return tags_model::with('user_tags')->get();
    }

    function login() {
        return view('login');
    }
    function check_login(Request $request) {
        $customer = Customer_model::where(['email'=> strtolower($request->input('email'))],['password' => $request->input('password')])->first();
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', function($attribute, $value, $fail) use($customer) {
                if (empty($customer)) {
                    $fail("invalid email or password");
                }
            }],
        ]);
        session()->put('customer_id', $customer->id);
        $this->set_login_user($request);
        // session()->flush();
        return redirect('posts');
    }
    function register() {
        return view('register');
    }
    function add_customer(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', function ($attribute, $value, $fail) {
                $customer = Customer_model::where('email', strtolower($value))->first();
                if ($customer) {
                    $fail("Email already exists");
                }
            }],
            'image' => ['image', 'mimes:jpg,png,jpeg'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $postArray = $request->all();
        $postArray['image'] = $this->upload_image('profile_image', $request);
        Customer_model::create($postArray);
        $request->session()->flash('added', 'Successfully added');
        return redirect('login');
    }

    function customer_form()
    {
        $data['all_customers'] = Customer_model::paginate(15);
        $data['action_url'] = 'create_customer';
        $data['title'] = 'Add Customer';
        return view('add_customer', $data);
    }

    function delete_customer(Request $request, $id)
    {
        $data = Customer_model::find($id);
        if (!empty($data)) {
            $data->delete();
            $request->session()->put('deleted', 'Successfully moved to trash');
            return redirect('posts');
        }
        die("Customer id $id not found");
    }

    function permenent_delete_customer(Request $request, $id)
    {
        $data = Customer_model::withTrashed()->find($id);
        if (!empty($data)) {
            $this->delete_image($data->toarray()['image']);
            $data->forceDelete();
            $request->session()->flash('deleted', 'Successfully deleted');
            return redirect('posts');
        }
        die("Customer id $id not found");
    }

    function restore_customer(Request $request, $id)
    {
        $data = Customer_model::onlyTrashed()->find($id);
        if (!empty($data)) {
            $data->restore();
            $request->session()->flash('restore', 'Successfully restored');
            return redirect('posts');
        }
        die("Customer id $id not found");
    }

    function update_customer(Request $request, $id)
    {
        $data = Customer_model::find($id);
        $postArray = $request->input();
        if (!empty($data)) {
            $this->delete_image($data->toarray()['image']);
            $postArray['image'] = $this->upload_image('profile_image', $request);
            $data->update($postArray);
            return redirect('posts');
        }
        die("Customer id $id not found");
    }

    function update_customer_form(Request $request, $id)
    {
        $data['customer'] = Customer_model::find($id);
        $data['all_customers'] = Customer_model::all();
        $data['action_url'] = "/update_customer/$id";
        if (empty($data['customer'])) {
            die("Customer id $id not found");
        }
        $data['title'] = 'Update Customer';
        return view('add_customer', $data);
    }

    function view_trash()
    {
        $data['deleted_customer'] = Customer_model::onlyTrashed()->get();
        return view('trash', $data);
    }

    function customers_dtable(Request $request)
    {
        $data['draw'] = $request->input('draw');
        $data['recordsFiltered'] = $data['recordsTotal'] = Customer_model::all()->count();
        $query = DB::table('customers')
                ->select(['*',DB::raw("sum(payments.amount) as amount")]);
        $query->leftJoin('payments', 'customers.id', 'payments.customer_id');
        // dd($request->input('search'));
        if ($request->input('from_date')) {
            $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($request->input('from_date'))));
        }
        if ($request->input('to_date')) {
            $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($request->input('to_date'))));
        }
        $query->where(function ($query) use ($request) {
            if ($request->input('search')['value']) {
                foreach ($this->searchable as $col) {
                    $query = $query->orWhere($col, 'LIKE', "%" . $request->input('search')['value'] . "%");
                }
                $data['recordsFiltered'] = $query->get()->count();
            }
        });
        $query->offset($request->input('start'))->limit($request->input('length'));
        $order_col = $request->input('order');
        $col = $request->input('columns');
        foreach ($order_col as $cols) {
            $name = $col[$cols['column']];
            if (in_array($name['data'], $this->orderable)) {
                $query->orderBy($name['data'], $cols['dir']);
            }
        }
        $query->groupBy('customers.id');
        $data['data'] = $query->get();
        foreach ($data['data'] as $key => $da) {
            $data['data'][$key]->move_to_trash = '<a class="btn btn-danger" href="' . url("/delete_customer/$da->id") . '">move to trash</a>';
            $data['data'][$key]->permenent_delete_customer = '<a class="btn btn-danger" href="' . url("/permenent_delete_customer/$da->id") . '">permenently delete</a>';
            $data['data'][$key]->update_customer = '<a class="btn btn-primary" href="' . url("/update_customer/$da->id") . '">update</a>';
        }
        return response()->json($data);
    }

    function test() {
        dd($this->user->name);
        return $this->user;
    }
}
