<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!-- Custom fonts for this template-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link rel="stylesheet" href="{{ asset('css/app.css' )}}">
        <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.css' )}}">
        <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css' )}}">

        @yield('profile-css')
    </head>

    <body id="page-top">
        <div id="wrapper">

            @include('layouts.sidebar')


            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('layouts.header')
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
                            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                        </div>
                        
                        @include('sweetalert::alert')

                        @yield('content')
                        
                    </div>
                </div>

                @include('layouts.footer')

            </div>
        </div>
        
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        @include('layouts.logout')

        <script src="{{ asset('js/app.js' )}}" type="text/javascript"></script>
        <script src="{{ asset('js/sb-admin-2.min.js' )}}" type="text/javascript"></script>
        @yield('profile-js')
    </body>
</html>
