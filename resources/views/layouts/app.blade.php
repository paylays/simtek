<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>@yield('title')</title>

        <link rel="icon" href="{{ asset('favicon_io/favicon.ico') }}" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    </head>

    <body class="sb-nav-fixed">

        @include('layouts.partials.navbar')

        <div id="layoutSidenav">

            <div id="layoutSidenav_nav">
                @include('layouts.partials.sidebar')
            </div>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">

                        @yield('content')

                    </div>
                </main>

                @include('layouts.partials.footer')

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/scripts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>
</html>