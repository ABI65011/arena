<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'SeamUni')</title>
    <link rel="shortcut icon" href="{{ asset('') }}" type="image/x-icon">

    @include('includes.header')
    @yield('header')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <div class="app-wrapper">

        @include('includes.navbar')
        @include('includes.sidebar')

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    @yield('page_header')
                </div>
            </div>

            <!-- Main content -->
            <div class="app-content">
                <div class="container-fluid">
                    {{-- @include('includes.widgets.alerts') --}}
                    @yield('content')
                </div>
            </div>
            <!-- /.content -->
        </main>
        <!-- /.content-wrapper -->
        {{-- @include('includes.footer') --}}
    </div>
    <!-- ./wrapper -->
    @include('includes.delete_form')
    @include('includes.activate_form')

    @include('includes.javascript')
    @yield('javascript')
</body>

</html>
