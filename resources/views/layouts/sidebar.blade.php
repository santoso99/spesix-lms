<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{\LaravelLocalization::localizeURL('/')}}">
            <img src="{{asset('img/favicon-web.png')}}" width="30%" alt="Logo"><span class="m-l-10">{{config('app.name')}}</span>
        </a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info py-3">
                    <div class="image">
                        <a href="{{url('admin/users/avatar/edit')}}" title="{{ __('section-title.avatar_edit') }}"><img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('img/avatar/default-user.jpg') }}" alt="User"></a>
                    </div>
                    <div class="detail text-left">
                        <h5 class="mb-0">{{Auth::user()->name}}</h5>
                        @hasrole('Siswa')
                        <small>{{ __('label.class') }} {{Auth::user()->grade->name}}</small>
                        @endhasrole
                        @unlessrole('Siswa')
                        <small>{{Auth::user()->roles[0]->name}}</small>
                        @endunlessrole
                        @hasrole('Wali Siswa')
                            <br>
                            <b><small class="text-primary">{{Auth::user()->student->name}}</small></b>
                        @endhasrole
                    </div>
                </div>
            </li>
            <li class="{{ $menu == '' ? 'active open' : null }}">
                <a href="{{\LaravelLocalization::localizeURL('dashboard')}}"><i class="zmdi zmdi-apps"></i><span>{{ __('menu-label.dashboard') }}</span></a>
            </li>
            @hasrole('Siswa')
            <li class="{{ $menu == 'topics' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-file-text"></i><span>{{ __('label.material') }}</span></a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('student/topics')}}"><span>{{ __('menu-label.show_all') }}</span></a>
                    </li>
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('student/topics/my-topics')}}"><span>{{ __('menu-label.my_topic') }}</span></a>
                    </li>
                </ul>
            </li>
            <li class="{{ $menu == 'tasks' ? 'active open' : null }}">
                <a href="{{\LaravelLocalization::localizeURL('student/tasks/reports')}}"><i class="zmdi zmdi-assignment"></i><span>{{ __('menu-label.task_summary') }}</span></a>
            </li>
            <li class="{{ $menu == 'exams' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>{{ __('menu-label.evaluation') }}</span></a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('student/exams')}}"><span>{{ __('menu-label.show_all') }}</span></a>
                    </li>
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('student/exams/results')}}"><span>{{ __('menu-label.evaluation_result') }}</span></a>
                    </li>
                </ul>
            </li>
            @endhasrole
            @hasrole('Wali Siswa')
            <li>
                <a href="{{\LaravelLocalization::localizeURL('parents/students/'.Auth::user()->student->id.'/tasks/report')}}"><i class="zmdi zmdi-assignment"></i><span>{{ __('menu-label.task_summary') }}</span></a>
            </li>
            <li>
                <a href="{{\LaravelLocalization::localizeURL('parents/students/'.Auth::user()->student->id.'/exams')}}"><i class="zmdi zmdi-file-plus"></i><span>{{ __('menu-label.evaluation_result') }}</span></a>
            </li>
            @endhasrole
            @hasrole('Admin')
            <li class="{{ $menu == 'members' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-accounts-list"></i><span>{{ __('menu-label.school_member') }}</span></a>
                <ul class="ml-menu">
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/members')}}">{{ __('menu-label.all_data') }}</a></li>
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/members/create')}}">{{ __('menu-label.import_data') }}</a></li>
                </ul>
            </li>
            <li class="{{ $menu == 'users' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-account"></i><span>{{ __('menu-label.user_account') }}</span></a>
                <ul class="ml-menu">
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/users')}}">{{ __('menu-label.all_data') }}</a></li>
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/users/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a></li>
                </ul>
            </li>
            <li class="{{ $menu == 'parents' ? 'active open' : null }}">
                <a href="{{\LaravelLocalization::localizeURL('admin/parents')}}"><i class="zmdi zmdi-account-box"></i> <span>{{ __('label.parent_account') }}</span></a>
            </li>
            <li class="{{ $menu == 'students' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>{{ __('label.student') }}</span></a>
                <ul class="ml-menu">
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/students')}}">{{ __('menu-label.all_data') }}</a></li>
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/students/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a></li>
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/students/promotion')}}">{{ __('menu-label.class_promotion') }}</a></li>
                </ul>
            </li>
            <li class="{{ $menu == 'teachers' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-account-box"></i><span>{{ __('label.teacher') }}</span></a>
                <ul class="ml-menu">
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/teachers')}}">{{ __('menu-label.all_data') }}</a></li>
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/teachers/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a></li>
                </ul>
            </li>
            <li class="{{ $menu == 'grades' ? 'active open' : null }}">
                <a href="{{\LaravelLocalization::localizeURL('admin/grades')}}"><i class="zmdi zmdi-badge-check"></i><span>{{ __('menu-label.class_data') }}</span></a>
            </li>
            <li class="{{ $menu == 'subjects' ? 'active open' : null }}">
                <a href="{{\LaravelLocalization::localizeURL('admin/subjects')}}"><i class="zmdi zmdi-collection-bookmark"></i><span>{{ __('menu-label.subject') }}</span></a>
            </li>
            @endhasrole
            @hasanyrole('Admin|Supervisor')
            <li class="{{ $menu == 'sops' ? 'active open' : null }}">
                <a href="{{\LaravelLocalization::localizeURL('admin/sops')}}"><i class="zmdi zmdi-file"></i><span>{{ __('menu-label.sop_file') }}</span></a>
            </li>
            <li class="{{ $menu == 'announcements' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-notifications"></i><span>{{ __('menu-label.announcement') }}</span></a>
                <ul class="ml-menu">
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/announcements')}}">{{ __('menu-label.all_data') }}</a></li>
                    @hasrole('Admin')
                    <li><a href="{{\LaravelLocalization::localizeURL('admin/announcements/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a></li>
                    @endhasrole
                </ul>
            </li>
            @endhasanyrole
            @hasanyrole('Admin|Supervisor|Pengajar')
            <li class="{{ $menu == 'topics' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-file-text"></i><span>{{ __('menu-label.learning_topic') }}</span></a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/topics/overview')}}">{{ __('menu-label.folder_view') }}</a>
                    </li>
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/topics')}}">{{ __('menu-label.list_view') }}</a>
                    </li>
                    @hasrole('Pengajar')
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/topics/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a>
                    </li>
                    @endhasrole
                </ul>
            </li>
            <li class="{{ $menu == 'tasks' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-assignment-check"></i><span>{{ __('menu-label.task') }}</span></a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/tasks')}}">{{ __('menu-label.all_data') }}</a>
                    </li>
                    @hasrole('Pengajar')
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/tasks/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a>
                    </li>
                    @endhasrole
                </ul>
            </li>
            <li class="{{ $menu == 'questions' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-pin-help"></i><span>{{ __('menu-label.question') }}</span></a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/questions')}}">{{ __('menu-label.all_data') }}</a>
                    </li>
                    @hasrole('Pengajar')
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/questions/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a>
                    </li>
                    @endhasrole
                </ul>
            </li>
            <li class="{{ $menu == 'exams' ? 'active open' : null }}">
                <a class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>{{ __('menu-label.evaluation') }}</span></a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/exams')}}">{{ __('menu-label.all_data') }}</a>
                    </li>
                    @hasrole('Pengajar')
                    <li>
                        <a href="{{\LaravelLocalization::localizeURL('admin/exams/create')}}">{{ __('label.add') }} {{ __('label.data') }}</a>
                    </li>
                    @endhasrole
                </ul>
            </li>
            @endhasanyrole
        </ul>
    </div>
</aside>
