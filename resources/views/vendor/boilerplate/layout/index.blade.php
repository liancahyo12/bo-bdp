<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="@lang('boilerplate::layout.direction')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ 'BDPay E-Office' }}</title>
    <link rel="shortcut icon" href="{{ config('boilerplate.theme.favicon') ?? mix('favicon.png', '/assets/vendor/boilerplate') }}">
@stack('plugin-css')
    <link rel="stylesheet" href="{{ mix('/plugins/fontawesome/fontawesome.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="stylesheet" href="{{ mix('/adminlte.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
@stack('css')
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/admin-lte.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/unduhformat.js', '/assets/vendor/boilerplate') }}"></script>
    
@stack('plugin-js')
</head>
<body class="layout-fixed layout-navbar-fixed sidebar-mini{{ setting('darkmode', false) && config('boilerplate.theme.darkmode') ? ' dark-mode accent-light' : '' }}{{ setting('sidebar-collapsed', false) ? ' sidebar-collapse' : '' }}">
    <div class="wrapper">
        @include('boilerplate::layout.header')
        @include('boilerplate::layout.mainsidebar')
        <div class="content-wrapper">
            @include('boilerplate::layout.contentheader')
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @includeWhen(config('boilerplate.theme.footer.visible', true), 'boilerplate::layout.footer')
        <aside class="control-sidebar control-sidebar-{{ config('boilerplate.theme.sidebar.type') }} elevation-{{ config('boilerplate.theme.sidebar.shadow') }}">
            <button class="btn btn-sm" data-widget="control-sidebar"><span class="fa fa-times"></span></button>
            <div class="control-sidebar-content">
                <div class="p-3">
                    @yield('right-sidebar')
                </div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>
    @component('boilerplate::minify')
    <script>
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
        bootbox.setLocale('{{ App::getLocale() }}');
        var bpRoutes={
            settings:"{{ route('boilerplate.settings',null,false) }}"
        };
        var session={
            keepalive:"{{ route('boilerplate.keepalive', null, false) }}",
            expire:{{ time() +  config('session.lifetime') * 60 }},
            lifetime:{{ config('session.lifetime') * 60 }},
            id:"{{ session()->getId() }}"
        };
        @if(Session::has('growl'))
        @if(is_array(Session::get('growl')))
            growl("{!! Session::get('growl')[0] !!}", "{{ Session::get('growl')[1] }}");
        @else
            growl("{{Session::get('growl')}}");
        @endif
        @endif
    </script>
    @endcomponent
@stack('js')
    <script src="{{ mix('/loading.js', '/assets/vendor/boilerplate') }}"></script>
    <div id="waitttAmazingLover" style="display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    background: rgba(0,0,0,0.75) url({{ mix('/images/Pulse-1s-200px.gif', '/assets/vendor/boilerplate') }}) no-repeat center center;
    z-index: 10000;">
    </div>
</body>
</html>
