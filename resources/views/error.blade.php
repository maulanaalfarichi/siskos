@extends('layouts.app')

@section('title')

@endsection

@section('content')
    <div class="container">
        <div class="panel panel-error">
            <div class="panel-heading">
                <h3 style="text-align:center">{{ $message }}</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4 line-round primary"></div>
                </div>
                <br/>
                <div class="alert alert-warning">
                    <p>{{ $info }}</p
                </div>
            </div>
        </div>
    </div>
@endsection
