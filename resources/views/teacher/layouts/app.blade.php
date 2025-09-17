<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('teacher/css/styles.css') }}">
</head>

<body>

    <!-- nav -->
    @include('teacher.partials.navbar')

    <div id="layoutSidenav">

        <!-- sidebar -->
        @include('teacher.partials.sidebar')

        <div id="layoutSidenav_content">

            <!-- body -->
            <!--  -->

            @yield('content')

            <!-- footer -->
            @include('teacher.partials.footer')

        </div>
    </div>

    <!-- script -->

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('teacher/js/scripts.js') }}"></script>

</body>

</html>