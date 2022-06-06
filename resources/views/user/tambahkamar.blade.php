<?php

$editPage = (Route::currentRouteName() == 'edit.kamar');
$errorPage = (count($errors) > 0);

if($errorPage && !$errors->has('image')){
    $fototemp   = explode(',',old('image'));
    $foto       = \Bukosan\Model\Foto::whereIn('nama',$fototemp)->get();
}

$image = '';
if($editPage){
    foreach ($foto as $key => $value) {
        $image .= $value->nama;
        if($key < count($foto) - 1){
            $image .= ',';
        }
    }
}

?>
@extends('layouts.user.page')

@section('title')
    @if($editPage)
        Edit Kamar
    @else
        Tambah Kamar
    @endif
@endsection

@section('contents')



<div class="panel panel-default panel-thumb">

    @if($editPage)
    <div class="panel-heading">Edit Kamar</div>
    @else
    <div class="panel-heading">Tambah Kamar Baru</div>
    @endif

    <div class="panel-body">

        <form action="{{ $editPage ? route('edit.kamar',['idkamar' => $kamar->id ]) : route('proses.tambah.kamar') }}" method="post" class="form-horizontal" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="idkosan" value="{{ $kosan->id }}"/>

            <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">Nama Kamar</label>
                <div class="col-md-6">
                    <input id="name" type="text" value="{{ $errorPage ? old('nama') : $kamar->nama }}" class="bukosan input-ui ui-primary" name="nama" placeholder="Nama Kamar" required autofocus>
                    @if ($errors->has('nama'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nama') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('harga') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">Harga Kamar</label>
                <div class="col-md-6">
                    <input id="name" type="number" value="{{ $errorPage ? old('harga') : $kamar->harga }}" class="bukosan input-ui ui-primary" name="harga" min="0" placeholder="Harga Kamar" required>
                    @if ($errors->has('harga'))
                    <span class="help-block">
                        <strong>{{ $errors->first('harga') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('lantai') ? ' has-error' : '' }}">
                <label for="lantai" class="col-md-3 control-label">Terletak pada lantai</label>
                <div class="col-md-6">
                    <input type="hidden" name="lantai" id="lantai" value="{{ $errorPage ? old('lantai') : $kamar->letaklantai }}"/>
                    <div class="dropdown" target="#lantai" id="letaklantai-drop">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(!$editPage && !$errorPage)
                            Pilih Lantai
                            @elseif($errorPage)
                            Lantai {{ old('lantai') }}
                            @elseif($editPage)
                            Lantai {{ $kamar->letaklantai }}
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                                for($i = 1;$i <= $kosan->jumlahlantai;$i++){
                             ?>
                            <li><a href="#" data-value="{{ $i }}">Lantai {{ $i }}</a></li>
                            <?php
                                }
                             ?>
                        </ul>
                    </div>
                    @if ($errors->has('lantai'))
                    <span class="help-block">
                        <strong>{{ $errors->first('lantai') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="foto" class="col-md-3 control-label">Foto</label>
                <div class="col-md-6">
                    <input type="hidden" name="image" id="image" value="{{ $errorPage ? old('image') : $image }}"/>
                    <button class="btn btn-primary btn-chooser" data-input="#foto" type="button">Pilih Foto</button> Maksimal 4 Foto
                    <div class="progress" style="margin-top: 10px;display: none">
                        <div class="progress-bar progress-bar-striped" style="width:0%" id="progress"></div>
                    </div>
                    <div id="image-show" class="row">
                        @if(Route::currentRouteName() == 'edit.kamar' || ((count($errors) > 0 && !$errors->has('image'))))
                            @foreach($foto as $gambar)
                            <div class="col-lg-6">
                            <div class="thumbnail">
                                <img style="height:150px" class="img-responsive" src="{{ asset('storage/'.$gambar->nama) }}"/>
                                <div class="caption">
                                    <a href="{{ route('hapus.foto') }}" class="btn btn-danger delete-foto" data-img="{{ $gambar->nama }}" role="button">Hapus</a>
                                </div>
                            </div>
                        </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title">Fasilitas Kamar</h3>
            </div>

            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Lemari</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="lemari" id="lemari" value="{{ $errorPage ? old('lemari') : $editPage ? $kamar->lemari : 0 }}"/>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Kipas Angin</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="kipas" id="kipas" value="{{ $errorPage ? old('kipas') : $editPage ? $kamar->kipasangin : 0 }}"/>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">AC</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="ac" id="ac" value="{{ $errorPage ? old('ac') : $editPage ? $kamar->ac : 0 }}"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title">Tambahkan Deskripsi</h3>
            </div>

            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>Tambahkan deskripsi tentang kamar anda</h4>
                <p>Berikan penjelasan lebih tentang kamar anda, mungkin tentang fasilitas tambahan atau informasi tambahan lainnya tentang kamar kosan anda.</p>
            </div>

            <textarea id="deskripsi" name="deskripsi">{{ $errorPage ? old('deskripsi') : $kamar->keterangan }}</textarea>
            @if ($errors->has('deskripsi'))
            <span class="help-block">
                <strong>{{ $errors->first('deskripsi') }}</strong>
            </span>
            @endif
            <br/>

            <div class="form-group">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i>&nbsp;&nbsp;Tambahkan</button>
                </div>
            </div>

        </form>

        <form class="file-upload" action="{{ route('upload.images') }}" method="post" enctype="multipart/form-data" style="display: none">
            {{ csrf_field() }}
            <input type="file" name="images[]" id="foto" multiple/>
        </form>
    </div>
</div>

@endsection
