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
        <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css' )}}">
        <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" />

        @yield('link-css')
    </head>

    <body id="page-top">
        @include('sweetalert::alert')
        
        <div id="app">
            <div id="wrapper">

                @include('layouts.sidebar')
    
                <div id="content-wrapper" class="d-flex flex-column">
                    <div id="content">
                        @include('layouts.header')
                        <div class="container-fluid">
    
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                @yield('title')
                                @yield('button-header')
                            </div>
                           
                            @yield('content')
                            
                        </div>
                    </div>
    
                    @include('layouts.footer')
    
                </div>
            </div>
        </div>
        
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        @include('layouts.logout')

        @yield('modal')

        @yield('messages-js')

        <script src="{{ asset('js/app.js' )}}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/sb-admin-2.min.js' )}}" type="text/javascript"></script>
        @yield('script-js')
        <script>
            $(function () {
                $(document).tooltip();
                $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
            })
        </script>
    </body>
</html>
