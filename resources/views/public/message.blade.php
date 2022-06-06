@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="row">
                <div class="col-md-2">
                    <i class="fa fa-warning fa-3x"></i>
                </div>

                <div class="col-md-10">
                    <p>{{ $message }}</p>
                    <a href="{{ $back }}">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
