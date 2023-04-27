{{--

/**
*
* Created a new component <x-base-layout/>.
*
*/

--}}

@php
    $isBoxed = layoutConfig()['boxed'];
    $isAltMenu = layoutConfig()['alt-menu'];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $pageTitle }} | Current Tech Admin</title>
    <link rel="icon" type="image/x-icon" href="{{Vite::asset('resources/images/ct-logo.png')}}"/>
    @vite(['resources/scss/layouts/modern-light-menu/light/loader.scss'])

    @if (Request::is('modern-light-menu/*'))
        @vite(['resources/layouts/modern-light-menu/loader.js'])
    @elseif ((Request::is('modern-dark-menu/*')))
        @vite(['resources/layouts/modern-dark-menu/loader.js'])
    @elseif ((Request::is('collapsible-menu/*')))
        @vite(['resources/layouts/collapsible-menu/loader.js'])
    @elseif ((Request::is('horizontal-light-menu/*')))
        @vite(['resources/layouts/horizontal-light-menu/loader.js'])
    @elseif ((Request::is('horizontal-dark-menu/*')))
        @vite(['resources/layouts/horizontal-dar  k-menu/loader.js'])
    @else
        @vite(['resources/layouts/modern-light-menu/loader.js'])
    @endif

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap/bootstrap.min.css')}}">
    @vite(['resources/scss/light/assets/main.scss', 'resources/scss/dark/assets/main.scss'])
    @vite(['resources/scss/light/assets/components/modal.scss'])
    @vite(['resources/scss/dark/assets/components/modal.scss'])

@if (
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        )
        @if ($scrollspy == 1) @vite(['resources/scss/light/assets/scrollspyNav.scss', 'resources/scss/dark/assets/scrollspyNav.scss']) @endif
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/waves/waves.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/highlight/styles/monokai-sublime.css')}}">
        @vite([ 'resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss'])


        @if (Request::is('modern-light-menu/*'))

        @vite([
            'resources/scss/layouts/modern-light-menu/light/structure.scss',
            'resources/scss/layouts/modern-light-menu/dark/structure.scss',
        ])

        @elseif ((Request::is('modern-dark-menu/*')))

        @vite([
            'resources/scss/layouts/modern-dark-menu/light/structure.scss',
            'resources/scss/layouts/modern-dark-menu/dark/structure.scss',
        ])

        @elseif ((Request::is('collapsible-menu/*')))

        @vite([
            'resources/scss/layouts/collapsible-menu/light/structure.scss',
            'resources/scss/layouts/collapsible-menu/dark/structure.scss',
        ])

        @elseif (Request::is('horizontal-light-menu/*'))

        @vite([
            'resources/scss/layouts/horizontal-light-menu/light/structure.scss',
            'resources/scss/layouts/horizontal-light-menu/dark/structure.scss',
        ])

        @elseif (Request::is('horizontal-dark-menu/*'))

        @vite([
            'resources/scss/layouts/horizontal-dark-menu/light/structure.scss',
            'resources/scss/layouts/horizontal-dark-menu/dark/structure.scss',
        ])

        @else

        @vite([
            'resources/scss/layouts/modern-light-menu/light/structure.scss',
            'resources/scss/layouts/modern-light-menu/dark/structure.scss',
        ])

        @endif

    @endif

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{$headerFiles}}
    <!-- END GLOBAL MANDATORY STYLES -->
</head>
<body @class([
        // 'layout-dark' => $isDark,
        'layout-boxed' => $isBoxed,
        'alt-menu' => ($isAltMenu || Request::routeIs('collapsibleMenu') ? true : false),
        'error' => (Request::routeIs('404') ? true : false),
        'maintanence' => (Request::routeIs('maintenance') ? true : false),
    ]) @if ($scrollspy == 1) {{ $scrollspyConfig }} @else {{''}} @endif   @if (Request::routeIs('fullWidth')) layout="full-width"  @endif >

    <!-- BEGIN LOADER -->
    <x-layout-loader/>
    <!--  END LOADER -->

    {{--

    /*
    *
    *   Check if the routes are not single pages ( which does not contains sidebar or topbar  ) such as :-
    *   - 404
    *   - maintenance
    *   - authentication
    *
    */

    --}}

    @if (
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        )

        @if (!Request::routeIs('blank'))

            @if (Request::is('modern-light-menu/*'))

                <!--  BEGIN NAVBAR  -->
                <x-navbar.style-vertical-menu classes="{{($isBoxed ? 'container-xxl' : '')}}"/>
                <!--  END NAVBAR  -->

            @elseif ((Request::is('modern-dark-menu/*')))

                <!--  BEGIN NAVBAR  -->
                <x-navbar.style-vertical-menu classes="{{($isBoxed ? 'container-xxl' : '')}}"/>
                <!--  END NAVBAR  -->

            @elseif ((Request::is('collapsible-menu/*')))

                <!--  BEGIN NAVBAR  -->
                <x-navbar.style-vertical-menu classes="{{($isBoxed ? 'container-xxl' : '')}}"/>
                <!--  END NAVBAR  -->

            @elseif (Request::is('horizontal-light-menu/*'))

                <!--  BEGIN NAVBAR  -->
                <x-navbar.style-horizontal-menu/>
                <!--  END NAVBAR  -->

            @elseif (Request::is('horizontal-dark-menu/*'))

                <!--  BEGIN NAVBAR  -->
                <x-navbar.style-horizontal-menu/>
                <!--  END NAVBAR  -->

            @else

                <!--  BEGIN NAVBAR  -->
                <x-navbar.style-vertical-menu classes="{{($isBoxed ? 'container-xxl' : '')}}"/>
                <!--  END NAVBAR  -->

            @endif

        @endif

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container " id="container">

            <!--  BEGIN LOADER  -->
            <x-layout-overlay/>
            <!--  END LOADER  -->

            @if (!Request::routeIs('blank'))

                @if (Request::is('modern-light-menu/*'))

                    <!--  BEGIN SIDEBAR  -->
                    <x-menu.vertical-menu/>
                    <!--  END SIDEBAR  -->

                @elseif ((Request::is('modern-dark-menu/*')))

                    <!--  BEGIN SIDEBAR  -->
                    <x-menu.vertical-menu/>
                    <!--  END SIDEBAR  -->

                @elseif ((Request::is('collapsible-menu/*')))

                    <!--  BEGIN SIDEBAR  -->
                    <x-menu.vertical-menu/>
                    <!--  END SIDEBAR  -->

                @elseif (Request::is('horizontal-light-menu/*'))

                    <!--  BEGIN SIDEBAR  -->
                    <x-menu.horizontal-menu/>
                    <!--  END SIDEBAR  -->

                @elseif (Request::is('horizontal-dark-menu/*'))

                    <!--  BEGIN SIDEBAR  -->
                    <x-menu.horizontal-menu/>
                    <!--  END SIDEBAR  -->

                @else

                    <!--  BEGIN SIDEBAR  -->
                    <x-menu.vertical-menu/>
                    <!--  END SIDEBAR  -->

                @endif

            @endif



            <!--  BEGIN CONTENT AREA  -->
            <div id="content" class="main-content {{(Request::routeIs('blank') ? 'ms-0 mt-0' : '')}}">

                @if ($scrollspy == 1)
                    <div class="container">
                        <div class="container">
                            {{ $slot }}
                        </div>
                    </div>
                @else
                    <div class="layout-px-spacing">
                        <div class="middle-content {{($isBoxed ? 'container-xxl' : '')}} p-0">
                            @if(Session::has('success_msg'))
                                <div class="alert alert-icon-left alert-light-success alert-dismissible fade show my-4" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" data-bs-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                    <strong>Done!</strong> {!! Session::get('success_msg') !!}
                                </div>
                            @endif
                            @if(Session::has('fail_msg'))
                                <div class="alert alert-danger alert-dismissible fade show my-4" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                    {!! Session::get('fail_msg') !!}
                                </div>
                            @endif
                            {{ $slot }}
                        </div>
                    </div>
                @endif

                <!--  BEGIN FOOTER  -->
                <x-layout-footer/>
                <!--  END FOOTER  -->

            </div>
            <!--  END CONTENT AREA  -->

        </div>
        <!--  END MAIN CONTAINER  -->

    @else
        {{ $slot }}
    @endif

    @if (
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        )
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <script src="{{asset('plugins/bootstrap/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('plugins/mousetrap/mousetrap.min.js')}}"></script>
        <script src="{{asset('plugins/waves/waves.min.js')}}"></script>
        <script src="{{asset('plugins/highlight/highlight.pack.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        @if ($scrollspy == 1) @vite(['resources/assets/js/scrollspyNav.js']) @endif

        @if (Request::is('modern-light-menu/*'))
            @vite(['resources/layouts/modern-light-menu/app.js'])
        @elseif ((Request::is('modern-dark-menu/*')))
            @vite(['resources/layouts/modern-dark-menu/app.js'])
        @elseif ((Request::is('collapsible-menu/*')))
            @vite(['resources/layouts/collapsible-menu/app.js'])
        @elseif (Request::is('horizontal-light-menu/*'))
            @vite(['resources/layouts/horizontal-light-menu/app.js'])
        @elseif (Request::is('horizontal-dark-menu/*'))
            @vite(['resources/layouts/horizontal-dark-menu/app.js'])
        @else
            @vite(['resources/layouts/modern-light-menu/app.js'])
        @endif
        <!-- END GLOBAL MANDATORY STYLES -->

    @endif

        {{$footerFiles}}
</body>
</html>
