<!doctype html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon-web.png')}}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{asset('fonts/flaticon.css')}}">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <!-- DataTable -->
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <!-- Bootstrap File Input -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom-icon-style.css')}}">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{asset('css/custom-admin.css')}}">
    <!-- Modernize js -->
    <script src="{{asset('js/modernizr-3.6.0.min.js')}}"></script>

    @laravelPWA
    
    @unlessrole('Siswa')
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      window.OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
        OneSignal.init({
          appId: "{!! config('services.onesignal.app_id') !!}",
          notifyButton: {
            enable: true,
          },
          allowLocalhostAsSecureOrigin: true,
        });
      });
    </script>
    @endunlessrole

</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <div id="wrapper" class="wrapper bg-ash">
       <!-- Header Menu Area Start Here -->
        <div class="navbar navbar-expand-md header-menu-one bg-light">
            <div class="nav-bar-header-one">
                <div class="header-logo">
                    <a href="/" style="color:#fff;font-weight:600;font-size:2rem;">
                        <img src="{{asset('img/logo-web.png')}}" alt="" srcset="" width="150px">
                    </a>
                </div>
                <div class="toggle-button sidebar-toggle">
                    <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="d-md-none mobile-nav-bar">
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-navbar" aria-expanded="false">
                    <i class="fa fa-user"></i>
                </button>
                <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
                <ul class="navbar-nav">
                    
                </ul>
                <ul class="navbar-nav">
                    <li class="navbar-item dropdown header-language">
                        <a class="navbar-nav-link dropdown-toggle text-uppercase" href="#" role="button" 
                        data-toggle="dropdown" aria-expanded="false"><i class="fas fa-globe-americas"></i>{{ LaravelLocalization::getCurrentLocale() }}</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                    <li class="navbar-item dropdown header-admin">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="admin-title">
                                <h5 class="item-title">{{Auth::user()->name}}</h5>
                                <span>{{Auth::user()->roles[0]->name}}</span>
                            </div>
                            <div class="admin-img">
                                <img width="40px" src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('img/avatar/default-user.jpg') }}" alt="Admin">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">{{Auth::user()->name}}</h6>
                            </div>
                            <div class="item-content">
                                <ul class="settings-list">
                                    <li><a href="{{\LaravelLocalization::localizeURL('/admin/users/avatar/edit')}}"><i class="flaticon-user"></i>{{ __('menu-label.change_avatar') }}</a></li>
                                    <li><a href="{{\LaravelLocalization::localizeURL('/')}}"><i class="fa fa-home"></i>{{ __('menu-label.homepage') }}</a></li>
                                    <li>
                                        <form action="{{\LaravelLocalization::localizeURL('/logout')}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-lg bg-transparent btn-logout"><i class="flaticon-turn-off"></i> {{ __('menu-label.logout') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <!-- Sidebar Area Start Here -->
            <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
               <div class="mobile-sidebar-header d-md-none">
                    <div class="header-logo">
                        <a href="/"><img src="{{asset('img/logo-web.png')}}" width="150px"alt="logo"></a>
                    </div>
               </div>
                <div class="sidebar-menu-content">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        <li class="nav-item {{($menu == '') ? 'active' : ''}}">
                            <a href="{{\LaravelLocalization::localizeURL('dashboard')}}" class="nav-link"><i class="flaticon-dashboard"></i><span>{{ __('menu-label.dashboard') }}</span></a>
                        </li>
                        @hasrole('Siswa')
                            <li class="nav-item {{($menu == 'tasks') ? 'active' : ''}}">
                                <a href="{{\LaravelLocalization::localizeURL('student/tasks/report')}}" class="nav-link"><i class="flaticon-script"></i><span>{{ __('menu-label.task_summary') }}</span></a>
                            </li>
                            <li class="nav-item {{($menu == 'exams') ? 'active' : ''}}">
                                <a href="{{\LaravelLocalization::localizeURL('student/exams')}}" class="nav-link"><i class="flaticon-shopping-list"></i><span>{{ __('menu-label.evaluation_result') }}</span></a>
                            </li>
                        @endhasrole
                        @hasrole('Admin')
                            <li class="nav-item sidebar-nav-item {{($menu == 'members') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i
                                        class="flaticon-multiple-users-silhouette"></i><span>{{ __('menu-label.school_member') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/members')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.all_data') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/members/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.import_data') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item sidebar-nav-item {{($menu == 'users') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i
                                        class="flaticon-multiple-users-silhouette"></i><span>{{ __('menu-label.user_account') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/users')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.data') }} {{ __('label.account') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/users/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.account') }}</a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole
                        @hasanyrole('Admin|Supervisor')
                            <li class="nav-item sidebar-nav-item {{($menu == 'parents') ? 'active' : ''}}">
                                <a href="#" class="nav-link">
                                    <i class="flaticon-multiple-users-silhouette"></i>
                                    <span>{{ __('label.parent_account') }}</span>
                                </a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/parents')}}" class="nav-link">
                                            <i class="fas fa-angle-right"></i>{{ __('label.data') }} {{ __('label.parent_account') }}
                                        </a>
                                    </li>
                                    @hasrole('Admin')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/parents/create')}}" class="nav-link">
                                            <i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.parent_account') }}
                                        </a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                            <li class="nav-item sidebar-nav-item {{($menu == 'students') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>{{ __('label.student') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/students')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.data') }} {{ __('label.student') }}</a>
                                    </li>
                                    @hasrole('Admin')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/students/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.student') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/students/promotion')}}" class="nav-link"><i
                                                class="fas fa-angle-right"></i>{{ __('menu-label.class_promotion') }}</a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                            <li class="nav-item sidebar-nav-item {{($menu == 'teachers') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i
                                        class="flaticon-multiple-users-silhouette"></i><span>{{ __('label.teacher') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/teachers')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.data') }} {{ __('label.teacher') }}</a>
                                    </li>
                                    @hasrole('Admin')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/teachers/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.teacher') }}</a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                        @endhasanyrole
                        <li class="nav-item {{($menu == 'grades') ? 'active' : ''}}">
                            <a href="{{\LaravelLocalization::localizeURL('admin/grades')}}" class="nav-link">
                                <i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler"></i>
                                <span>{{ __('menu-label.class_data') }}</span>
                            </a>
                        </li>
                        @hasanyrole('Admin|Supervisor')
                            <li class="nav-item {{($menu == 'sops') ? 'active' : ''}}">
                                <a href="{{\LaravelLocalization::localizeURL('admin/sops')}}" class="nav-link"><i class="flaticon-script"></i><span>{{ __('menu-label.sop_file') }}</span></a>
                            </li>
                            <li class="nav-item sidebar-nav-item {{($menu == 'announcements') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i class="flaticon-chat"></i><span>{{ __('menu-label.announcement') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/announcements')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.all_data') }}</a>
                                    </li>
                                    @hasrole('Admin')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/announcements/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.data') }}</a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                        @endhasanyrole
                        <li class="nav-item {{($menu == 'subjects') ? 'active' : ''}}">
                            <a href="{{\LaravelLocalization::localizeURL('admin/subjects')}}" class="nav-link"><i class="flaticon-open-book"></i><span>{{ __('menu-label.subject') }}</span></a>
                        </li>
                        @hasanyrole('Admin|Supervisor|Pengajar')
                            <li class="nav-item sidebar-nav-item {{($menu == 'topics') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i class="flaticon-script"></i><span>{{ __('menu-label.learning_topic') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/topics/overview')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.folder_view') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/topics')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.all_data') }}</a>
                                    </li>
                                    @hasrole('Pengajar')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/topics/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.data') }}</a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                            <li class="nav-item sidebar-nav-item {{($menu == 'tasks') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i class="flaticon-chat"></i><span>{{ __('menu-label.task') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/tasks')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.all_data') }}</a>
                                    </li>
                                    @hasrole('Pengajar')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/tasks/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.data') }}</a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                            <li class="nav-item sidebar-nav-item {{($menu == 'questions') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i class="flaticon-chat"></i><span>{{ __('menu-label.question') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/questions')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.all_data') }}</a>
                                    </li>
                                    @hasrole('Pengajar')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/questions/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.data') }}</a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                            <li class="nav-item sidebar-nav-item {{($menu == 'exams') ? 'active' : ''}}">
                                <a href="#" class="nav-link"><i class="flaticon-shopping-list"></i><span>{{ __('menu-label.evaluation') }}</span></a>
                                <ul class="nav sub-group-menu">
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/exams')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('menu-label.all_data') }}</a>
                                    </li>
                                    @hasrole('Pengajar')
                                    <li class="nav-item">
                                        <a href="{{\LaravelLocalization::localizeURL('admin/exams/create')}}" class="nav-link"><i class="fas fa-angle-right"></i>{{ __('label.add') }} {{ __('label.evaluation') }}</a>
                                    </li>
                                    @endhasrole
                                </ul>
                            </li>
                        @endhasanyrole
                    </ul>
                </div>
            </div>
            <!-- Sidebar Area End Here -->
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    
                </div>
                <!-- Breadcubs Area End Here -->

                @yield('content')

                <!-- Footer Area Start Here -->
                <footer class="footer-wrap-layout1">
                    <div class="copyright">© Copyrights <a href="/">E-Learning | SMA Pradita Dirgantara</a> {{date('Y')}}. All rights reserved.</div>
                </footer>
                <!-- Footer Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
    <!-- jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Plugins js -->
    <script src="{{asset('js/plugins.js')}}"></script>
    <!-- Popper js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Bootstrap js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Counterup Js -->
    <script src="{{asset('js/jquery.counterup.min.js')}}"></script>
    <!-- Moment Js -->
    <script src="{{asset('js/moment.min.js')}}"></script>
    <!-- Waypoints Js -->
    <script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
    <!-- Scroll Up Js -->
    <script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
    <!-- Full Calender Js -->
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
    <!-- Select 2 Js -->
    <script src="{{asset('js/select2.min.js')}}"></script>
    <!-- Date Picker Js -->
    {{-- <script src="{{asset('js/datepicker.min.js')}}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Data Table Js -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Bootstrap File Input JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
    <!-- TinyMCE -->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <!-- Custom Js -->
    <script src="{{asset('js/main.js')}}"></script>

    <script>
        var editor_config = {
          path_absolute : "/",
          selector: "textarea#editor",
          plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
          ],
          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
          relative_urls: false,
          file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
      
            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
              cmsURL = cmsURL + "&type=Images";
            } else {
              cmsURL = cmsURL + "&type=Files";
            }
      
            tinyMCE.activeEditor.windowManager.open({
              file : cmsURL,
              title : 'Filemanager',
              width : x * 0.8,
              height : y * 0.8,
              resizable : "yes",
              close_previous : "no"
            });
          }
        };
      
        tinymce.init(editor_config);
    </script>
    <script>
        $(document).ready(function(){

            $('#datetimepicker1').datetimepicker();

            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });

            $(".radio-label").on("click", function(){
                $(".radio-label").css("background-color","");
                $(this).css("background-color","#C9F5A5");
            });

            $(".btn-remove-file").on("click",function(e){
                e.preventDefault()
                $(this).parent().remove()
                $("input[name='is_file_empty']").val(1)
            });

            $(function () {
                $('[data-toggle="popover"]').popover({
                    html: true,
                });
            });

            $("#attachment-file").fileinput({
                theme: 'fa',
                uploadUrl: "/image-view",
                uploadExtraData: function() {
                    return {
                        _token: $("input[name='_token']").val(),
                    };
                },
                allowedFileExtensions: ['jpg', 'png', 'gif'],
                overwriteInitial: false,
                maxFileSize:2000,
                maxFilesNum: 10,
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                }
            });

        });
    </script>

    @stack('scripts')

</body>

</html>