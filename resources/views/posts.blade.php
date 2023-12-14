<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="input-group rounded" style="position: fixed;">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" />
            <span class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
        </div>
        <section class="vh-100" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <a href="{{ url('create_post') }}"><i class="fa-solid fa-plus"></i></a>
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col col-lg-6">
                            <figure class="bg-white p-3 rounded" style="border-left: .25rem solid #f68e9d;">
                                <blockquote class="blockquote pb-2">
                                    <p>
                                        {{ $post['content'] }}
                                    </p>
                                </blockquote>
                                <figcaption class="blockquote-footer mb-0 font-italic">
                                    {{ $post['customers']['name'] }}
                                </figcaption>
                                tags
                                <select class="selectro" multiple readonly style="width:100%">
                                    @foreach ($post['tags'] as $item)
                                        <option value="{{ $item['id'] }}" selected>{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <script>
        $(document).ready(function() {
            $('.selectro').select2();
            $('.selectro').select2('enable',false);
            fetch('http://localhost/demo/cors.php');
        })
    </script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
