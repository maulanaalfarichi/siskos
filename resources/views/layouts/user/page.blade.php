@extends('layouts.app')

<?php

    $route = Route::currentRouteName();

    $isHomepage = ($route === 'homepage');

    $isKosanPage = ($route === 'tambah.kosan' || $route === 'kosansaya' || $route === 'edit.kosan');

    $isKamarPage = ($route === 'tambah.kamar' || $route === 'edit.kamar');

    $isSettingsPage = ($route === 'settings');

 ?>

@section('css')
    @if( Auth::check() )
    <link href="{{ asset('css/user.css') }}" rel="stylesheet"/>
    @endif
@endsection

@section('content')
        <nav class="navbar navbar-user">
            <div class="container">
                <ul id="stripped-menu">
                    <li @if($isHomepage) class="active" @endif>
						<a href="{{ url('') }}">
							<i class="fa fa-home"></i>
							<span class="hidden-sm hidden-xs">Beranda</span>
						</a>
					</li>
                    <li @if($isKosanPage) class="active" @endif>
						<a href="{{ route('kosansaya') }}">
						<i class="fa fa-hotel"></i>
							<span class="hidden-sm hidden-xs">Kosan Saya</span>
						</a>
					</li>
                    <li {{ Route::currentRouteName() == 'riwayat.sewa' ? 'class=active' : '' }}><a href="{{ route('riwayat.sewa') }}">
                            <i class="fa fa-table"></i>
                            <span class="hidden-sm hidden-xs">Riwayat Sewa</span>
                        </a></li>
                    <li {{ Route::currentRouteName() == 'pesan' ? 'class=active' : '' }}><a href="{{ route('pesan') }}">
                            <i class="fa fa-comment"></i>
                            <span class="hidden-sm hidden-xs">Pesan</span>
                        </a>
                        </a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 col-md-3 col-sm-4 col-xs-6" id="leftbar">
                    <div class="panel panel-default panel-avatar">
                        <div class="panel-body">
                            <img class="img-responsive img-circle img-ava" src="{{ asset('storage/' . Auth::user()->avatar) }}"/>
                            <h3>{{ Auth::user()->username }}</h3>
                        </div>
                    </div>

                    <nav id="side-menu">
                        <ul>
						@if(Auth::user()->admin)
						<h5>Admin</h5>
						<li @if(Route::currentRouteName()=='kelola.user') class="active" @endif><a href="{{ route('kelola.user') }}"><i class="fa fa-user"></i>&nbsp;&nbsp;Kelola User</a></li>
						<li @if(Route::currentRouteName()=='kelola.kosan') class="active" @endif><a href="{{ route('kelola.kosan') }}"><i class="fa fa-home"></i>&nbsp;&nbsp;Kelola Kosan</a></li>
						<br/>
						@endif
						<h5>Menu</h5>
                            <li @if(Route::currentRouteName()=='daftar.favorit') class="active" @endif><a href="{{ route('daftar.favorit') }}"><i class="fa fa-star"></i>&nbsp;&nbsp;Favorit Saya</a></li>
                            <li @if(Route::currentRouteName()=='riwayat.kunjungan') class="active" @endif><a href="{{ route('riwayat.kunjungan') }}"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;Riwayat Kunjungan</a></li>
                            <li @if($isSettingsPage) class="active" @endif><a href="{{ route('settings') }}"><i class="fa fa-gear"></i>&nbsp;&nbsp;Pengaturan</a></li>
                        </ul>
                    </nav>
                </aside>

                <div class="col-lg-9 col-md-9 col-sm-8">
                    @yield('contents')
                </div>
            </div>
        </div>
@endsection

@if(Auth::check())
    @section('js')
        <script src="{{ asset('js/jquery.form.js') }}"></script>
        <script src="{{ asset('js/user.js') }}"></script>
		@if(Route::currentRouteName() == 'pesan')
		<script src="{{ asset('js/message.js') }}"></script>
		@endif
        @if($route === 'tambah.kosan' || $route === 'edit.kosan' || $route === 'tambah.kamar' || $route === 'edit.kamar')
        <script src="{{ asset('tinymce/tinymce.min.js')}}"></script>
        <script>
            tinymce.init({
                selector : '#deskripsi',
                menubar : false
            });
        </script>
        @endif
        @endsection
@endif
