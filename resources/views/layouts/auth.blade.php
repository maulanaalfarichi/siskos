@extends('layout.public.umum')

@section('title')
    @yield('title')
@endsection

@section('css')
<link rel="stylesheet" href="{{ url('css/auth.css') }}"/>
@endsection

@section('content')
    @yield('content')
@endsection

@section('js')
<script src="{{ url('js/auth.js') }}"></script>
<script src="{{ url('js/form.js') }}"></script>
@endsection
