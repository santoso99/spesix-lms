@extends('layouts.home-template')

@section('title')
    {{ __('section-title.sop_data')}}
@endsection

@section('before-styles')
<!-- Treeview Gijgo CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css">
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <div class="row">
            <div id="course-side-nav" class="col-md-3 col-sm-12">
                <h4 class="font-weight-bold">{{ __('section-title.topic_index')}}</h4>
                @include('frontpage.topic-sidebar')
            </div>
            <div class="col-md-9 col-sm-12 table-responsive">
                <h2 class="title">{{ __('section-title.sop_data')}}</h2>
                <small>*{{ __('messages.click_to_download') }}</small>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('label.number') }}</th>
                            <th>{{ __('label.name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($sops) == 0)
                        <tr>
                            <td colspan="2" class="text-secondary text-center">{{ __('label.no_data') }} <i class="fas fa-folder-open ml-2"></td>
                        </tr>
                        @endif
                        @php($no=0)
                        @foreach($sops as $sop)
                        <tr>
                            <td>{{++$no}}</td>
                            <td><a href="{{asset('storage/'.$sop->file_path)}}">{{$sop->filename}}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Treeview Gijgo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>
@endpush