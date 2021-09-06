<div class="table-responsive">
    <form action="{{route('topic.batch.delete')}}" method="POST">
        @csrf
        @method('delete')
        <table class="table table-hover dataTable c_table theme-color">
            <thead>
                <tr>
                    <th class="no-sort">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input checkAll">
                            <label class="form-check-label">{{ __('label.number') }}</label>
                        </div>
                    </th>
                    <th>{{ __('label.name') }}</th>
                    <th class="no-sort text-right"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                    <th>{{ __('label.subject') }}</th>
                    <th>{{ __('label.class') }}</th>
                    <th>{{ __('label.semester') }}</th>
                    <th>{{ __('label.teacher') }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($topics)>0)
                    @php($no=0)
                    @foreach($topics as $topic)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" value="{{$topic->id}}" name="topic_id[]" class="form-check-input">
                                    <label class="form-check-label">{{++$no}}</label>
                                </div>
                            </td>
                            <td><a href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id)}}">{{$topic->name}}</a></td>
                            <td class="header">
                                <ul class="header-dropdown">
                                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                        <ul class="dropdown-menu dropdown-menu-left slideUp">
                                        @unlessrole('Siswa')
                                            <li>
                                                <a target="_blank" href="{{\LaravelLocalization::localizeURL('topics/'.$topic->id)}}">
                                                    <i class="zmdi zmdi-eye action-icon"></i>{{ __('label.show') }}
                                                </a>
                                            </li>
                                        @endunlessrole
                                        @hasrole('Pengajar')
                                            <li>
                                                <a target="_blank" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/edit')}}">
                                                    <i class="zmdi zmdi-edit action-icon"></i>{{ __('label.edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a target="_blank" href="{{route('topics.materials',$topic->id)}}">
                                                    <i class="zmdi zmdi-format-list-bulleted action-icon"></i>{{ __('label.learning_material') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a target="_blank" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/tasks')}}">
                                                    <i class="zmdi zmdi-assignment-check action-icon"></i>{{ __('label.task') }}
                                                </a>
                                            </li>
                                        @endhasrole
                                        @hasanyrole('Admin|Supervisor|Pengajar')
                                            <li>
                                                <a target="_blank" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/visitors')}}">
                                                    <i class="zmdi zmdi-accounts action-icon"></i>{{ __('label.visitor') }}
                                                </a>
                                            </li>
                                        @endhasanyrole
                                    </div>
                                </div>
                            </td>
                            <td>{{$topic->subject->name}}</td>
                            <td class="trimmed-last">
                                @foreach($topic->grades as $grade)
                                    {{$grade->name.' - '}}
                                @endforeach
                            </td>
                            <td>{{$topic->semester}}</td>
                            <td>{{$topic->user->name}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">{{ __('label.no_data') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @hasrole('Pengajar')
        <div class="col-lg-3 col-12">
            <button type="submit" class="btn btn-warning btn-raised waves-effect">{{ __('button-label.batch_delete') }}</button>
        </div>
        @endhasrole
    </form>
</div>