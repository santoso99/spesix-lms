@extends('layouts.home-template')

@section('title')
    {{ __('menu-label.contact')}}
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
            <div class="col-md-9 col-sm-12">
                <h2 class="title">{{ __('menu-label.contact')}}</h2>
                <div class="row">
                    <div class="col-md-6">
                        <table id="contact-table">
                            <tbody valign="top">
                                <tr>
                                    <td><i class="fas fa-map-marker-alt"></i></td>
                                    <td>Jl. Patimura No.9, Kebonagung, Kec. Semarang Timur, Kota Semarang, Jawa Tengah 50123</td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-phone"></i></td>
                                    <td><a href="tel:+62243544024">(024) 3544024</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="contact-admin-table" class="mt-5">
                            <tr>
                                <td colspan="3" class="font-weight-bold">Admin</td>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Dody Sumardi</td>
                                <td><a href="https://wa.me/6282113450227">0821-1345-0227</a></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Imam Setiawan</td>
                                <td><a href="https://wa.me/6282242510043">0822-4251-0043</a></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Nurkholis</td>
                                <td><a href="https://wa.me/6287832103041">0878-3210-3041</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <img class="rounded" src="{{ asset('img/foto-smpn6smg_2.jpeg') }}" alt="Foto SMP N 6 Semarang">
                    </div>
                </div>
                <div class="mt-5">
                    <h2 class="title">{{ __('label.school_location') }}</h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15841.334375165681!2d110.433541!3d-6.9699143!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x63af55bb850cf467!2sSMPN%206!5e0!3m2!1sen!2sid!4v1621158676471!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Treeview Gijgo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>
@endpush