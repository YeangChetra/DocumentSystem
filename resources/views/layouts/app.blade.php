<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description-gambolthemes" content="">
        <meta name="author-gambolthemes" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin System</title>
        
        <link rel="stylesheet" href="/css/app.css">
        <link href="{{asset('app-assets/css/styles.css')}}" rel="stylesheet">
        <link href="{{asset('app-assets/css/admin-style.css')}}" rel="stylesheet">
        <link href="{{asset('app-assets/css/custom.css')}}" rel="stylesheet">

        <link href="{{asset('app-assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('app-assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendor/dropify/css/dropify.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendor/sweetalert/sweetalert.css')}}">
        <script src="{{asset('app-assets/js/jquery-3.4.1.min.js')}}"></script>
        <script src="{{asset('app-assets/js/custom.js')}}"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/froala_editor.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/froala_style.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/code_view.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/colors.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/emoticons.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/image_manager.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/image.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/line_breaker.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/table.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/char_counter.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/video.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/fullscreen.css')}}">
        <link rel="stylesheet" href="{{asset('app-assets/vendor/froala_editor_3.1.1/css/plugins/file.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
        <style>
            input[type="checkbox"] {
                border-color: #f55d2c!important;
            }
            .form-control:focus {
                border-color: #f55d2c!important;
                box-shadow: 0 0 0 0.2rem rgba(245,93,44, 0.25)!important;
            }
            select .form-control:focus {
                border-color: #f55d2c!important;
                box-shadow: 0 0 0 0.2rem rgba(245,93,44, 0.25)!important;
            }
        </style>
        
        @vite(['resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="sb-nav-fixed {{ Session::get('toogled') }}">        
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-clr">
            <img class="navbar-brand logo-brand" src="{{asset('app-assets/images/logo.png')}}" href="{{route('dashboard')}}" alt="">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
                <i class="fas fa-bars" style="color: #f55d2c!important;"></i>
            </button>
    
            <ul class="navbar-nav ml-auto mr-md-0">
                <li class="nav-item dropdown" style="appearance: none;">
                    <a class="nav-link" id="userDropdown" href="#" role="button" data-toggle="dropdown"aria-haspopup="true" aria-expanded="false">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img style="width: 35px;height: 35px;border-radius: 50%;border: 1px #45bbe0 solid;" src="{{ Auth::user()? asset(Auth::user()->profile_photo_url) : '' }}" alt="{{ Auth::user() ? Auth::user()->name : '' }}">
                        @else
                            <i style="padding-left:2px;padding-right: 2px;color: #f55d2c;">{{ Auth::user()?Auth::user()->name : ''}}</i>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#userDropdown').addClass('dropdown-toggle');
                                });
                            </script>
                        @endif
                    </a>                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item admin-dropdown-item" style="text-align: center;">
                            <span style="color: #f55d2c;">
                                {{ Auth::user()->name}}
                            </span>
                        </a>
                        <a class="dropdown-item admin-dropdown-item" style="text-align: center;">
                            <span style="color: #f55d2c;">
                                @foreach(Auth::user()->roles as $role)
                                    {{$role->name}} |
                                @endforeach
                            </span>
                        </a>
                        <a class="dropdown-item admin-dropdown-item" href="{{ route('profile.show') }}">Edit Profile</a>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item admin-dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" id="a-dashboard" href="{{route('dashboard')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
    
                            @if(Auth::user()->roles->first()->name == "Super Admin")
                                <a class="nav-link" id="a-location" href="{{route('comments.index')}}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-map-marker-alt"></i></div>
                                    Comment
                                </a>
    
                                <!-- <a class="nav-link" id="a-area" href="/area">
                                    <div class="sb-nav-link-icon"><i class="fas fa-map-marked-alt"></i></div>
                                    Areas
                                </a> -->
                            @endif
                            @canany('User access','User add','User edit','User delete')
                                <a class="nav-link collapsed" id="nav-document" href="#" data-toggle="collapse" data-target="#collapseDocument" aria-expanded="false" aria-controls="collapseDocument">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Documents
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseDocument" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub_nav_link" href="{{route('documents.select_type', Crypt::encrypt(1))}}">
                                            <i class="fas fa-arrow-right" style="padding-right: 10px;"></i>Document In
                                        </a>
                                        <a class="nav-link sub_nav_link" href="{{route('documents.select_type', Crypt::encrypt(2))}}">
                                            <i class="fas fa-arrow-right" style="padding-right: 10px;"></i> Document Out
                                        </a>
                                    </nav>
                                </div>
                            @endcanany
                            @canany('User access','User add','User edit','User delete')
                                <a class="nav-link collapsed" id="nav-account" href="#" data-toggle="collapse" data-target="#collapseUserAccount" aria-expanded="false" aria-controls="collapseUserAccount">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    User Account
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseUserAccount" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub_nav_link" href="{{route('users.index')}}">
                                            <i class="fas fa-arrow-right" style="padding-right: 10px;"></i>All Accounts
                                        </a>
                                        <a class="nav-link sub_nav_link" href="{{route('users.create')}}">
                                            <i class="fas fa-arrow-right" style="padding-right: 10px;"></i> Add Account
                                        </a>
                                        @canany('Role access','Role add','Role edit','Role delete')
                                            <a class="nav-link sub_nav_link" href="{{route('roles.index')}}"><i class="fas fa-arrow-right" style="padding-right: 10px;"></i> Add Roles</a>
                                        @endcanany
                                        @canany('Permission access','Permission add','Permission edit','Permission delete')
                                            <a class="nav-link sub_nav_link" href="{{route('permissions.index')}}"><i class="fas fa-arrow-right" style="padding-right: 10px;"></i> Add Permissions</a>
                                        @endcanany
                                    </nav>
                                </div>
                            @endcanany
    
                            <a class="nav-link collapsed" id="nav-setting" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                                <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                                Setting
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseSettings" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link sub_nav_link" href="../general-contact"><i class="fas fa-arrow-right" style="padding-right: 10px;"></i> General Settings</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="min-h-screen bg-gray-100"  id="layoutSidenav_content">
                <main>
                    {{ $slot }}
                </main>
                @if(\Session::has('success'))
                    <script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                            title: '{!!\Session::get('success')!!}',
                            text: "I will close in 2 seconds.",
                            icon: 'success',
                            timer: 2000,
                            buttons: false
                            });
                        });
                    </script>
                @endif
                @if(\Session::has('error'))
                    <script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                            title: '{!!\Session::get('error')!!}',
                            text: "I will close in 2 seconds.",
                            icon: 'error',
                            timer: 2000,
                            buttons: false
                            });
                        });
                    </script>
                @endif
                <footer class="py-4 bg-footer mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted-1">© 2022 <b>Administrator System</b>. by <a href="https://www.facebook.com/yeang.chetra.kh" target="_blank">Yeang Chetra</a></div>
                            <div class="footer-links">
                                <a href="../../gambo_supermarket_demo/privacy_policy.html">Privacy Policy</a>
                                <a href="../../gambo_supermarket_demo/term_and_conditions.html">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="{{asset('app-assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('app-assets/js/scripts.js')}}"></script>
        <script src="{{asset('app-assets/vendor/chart/highcharts.js')}}"></script>
        <script src="{{asset('app-assets/vendor/chart/exporting.js')}}"></script>
        <script src="{{asset('app-assets/vendor/chart/export-data.js')}}"></script>
        <script src="{{asset('app-assets/vendor/chart/accessibility.js')}}"></script>
        {{-- <script src="{{asset('app-assets/js/chart.js')}}"></script> --}}
        <script src="{{asset('app-assets/vendor/dropify/js/dropify.min.js')}}"></script>
        <script src="{{asset('app-assets/vendor/sweetalert/sweetalert.min.js')}}"></script>
        <script src="{{asset('app-assets/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
        <script src="{{asset('app-assets/js/form-validation.js')}}" type="text/javascript')}}"></script>
        <script src="{{asset('app-assets/js/form-file-uploads.js')}}"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/froala_editor.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/align.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/code_beautifier.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/code_view.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/colors.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/emoticons.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/draggable.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/font_size.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/font_family.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/image.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/file.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/image_manager.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/line_breaker.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/link.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/lists.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/paragraph_format.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/paragraph_style.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/video.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/table.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/url.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/entities.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/char_counter.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/inline_style.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/save.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/fullscreen.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/froala_editor_3.1.1/js/plugins/quote.min.js')}}"></script>
        <script>
            (function () {
                new FroalaEditor("#edit", {
                zIndex: 10
                })
            })()
            //toogle body
            $(document).on("click", "#sidebarToggle", function() {
                var toogle = $('body').attr('class');
                $.ajax({
                url:"{{route('toogle')}}",
                method:'get',
                data:{toogle:toogle},
                });
            });
        </script>
    </body>
</html>
