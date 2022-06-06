@extends('layouts.user.page')

@section('title')
Kosan Saya
@endsection

@section('contents')

<?php

$editPage       = (Route::currentRouteName() == 'edit.kosan');
$errorPage      = (count($errors) > 0);

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

<div class="panel panel-default panel-thumb">
    @if($editPage)
    <div class="panel-heading"><h3 class="panel-title">Edit Kosan</h3></div>
    @else
    <div class="panel-heading"><h3 class="panel-title">Daftar Kosan Baru</h3></div>
    @endif

    <div class="panel-body">

        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>Ingat, pendaftaran ini adalah untuk pendaftaran kosan anda secara umum, bukan merupakan pendaftaran dari kamar yang ada pada kosan anda. Butuh bantuan ? Silahkan hubungi Customer Service kami</p>
        </div>

        <form action="@if($editPage) {{ route('edit.kosan',[ 'id' => $kosan->id]) }} @else {{ route('tambah.kosan') }} @endif" method="post" class="form-horizontal" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">Nama Kosan</label>
                <div class="col-md-6">
                    <input id="name" type="text" value="{{ $errorPage ? old('nama') : $kosan->nama }}" class="bukosan input-ui ui-primary" name="nama" placeholder="Nama Kosan" required autofocus>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                <label for="alamat" class="col-md-3 control-label">Alamat</label>
                <div class="col-md-6">
                    <input id="alamat" type="text" value="{{ $errorPage ? old('alamat') : $kosan->alamat }}" class="bukosan input-ui ui-primary" name="alamat" placeholder="Alamat" required>
                    @if ($errors->has('alamat'))
                    <span class="help-block">
                        <strong>{{ $errors->first('alamat') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('lantai') ? ' has-error' : '' }}">
                <label for="lantai" class="col-md-3 control-label">Jumlah lantai</label>
                <div class="col-md-6">
                    <input placeholder="Jumlah lantai" id="lantai"  type="number" min="1" class="bukosan input-ui ui-primary" value="{{ $errorPage ? old('lantai') : $editPage ? $kosan->jumlahlantai : 1 }}" name="lantai" required>
                    @if ($errors->has('lantai'))
                    <span class="help-block">
                        <strong>{{ $errors->first('lantai') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="foto" class="col-md-3 control-label">Foto</label>
                <div class="col-md-9">
                    <input type="hidden" name="image" id="image" value="{{ $errorPage ? old('image') : $image }}"/>
                    <button class="btn btn-primary btn-chooser" data-input="#foto" type="button">Pilih Foto</button> Maksimal 4 Foto
                    <div class="progress" style="margin-top: 10px;display: none">
                        <div class="progress-bar progress-bar-striped" style="width:0%" id="progress"></div>
                    </div>
                    @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                    <div id="image-show" class="row">
                        @if(Route::currentRouteName() == 'edit.kosan' || ((count($errors) > 0 && !$errors->has('image'))))
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
                <h3 class="panel-title">Lokasi Kosan</h3>
            </div>

                    <input type="hidden" id="latitude" name="latitude" value="-7.557"/>
                    <input type="hidden" id="longitude" name="longitude" value="131.13"/>
                    @if ($errors->has('latitude') || $errors->has('longitude'))
                    <span class="help-block">
                        <strong>Pilih lokasi kosan anda !</strong>
                    </span>
                    @endif
                    <div id="map" style="width:100%;height:350px"></div>

            <div class="form-group">
                <div class="col-lg-3">
                    <h4>Provinsi</h4>
                    <input type="hidden" name="provinsi" id="provinsi" value="{{ $errorPage ? old('provinsi') : $kosan->provinsi }}"/>
                    <div class="dropdown" target="#provinsi" id="provinsi-drop">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(!$errorPage && !$editPage)
                                Pilih Provinsi
                            @elseif($errorPage)
                                {{old('provinsi')}}
                            @elseif($editPage)
                                {{$kosan->provinsi}}
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <input type="text" class="autocomplete form-control"/>
                            @foreach($provinsi as $value)
                            <li><a href="#" data-value="{{ $value->id }}">{{ $value->nama }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Kota / Kabupaten</h4>
                    <input type="hidden" name="kotakab" id="kotakab" value="{{ $errorPage ? old('kotakab') : $kosan->kotakab }}"/>
                    <div class="dropdown" target="#kotakab" id="kotakab-drop">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(!$errorPage && !$editPage)
                                Pilih Kota/Kabupaten
                            @elseif($errorPage)
                                {{old('kotakab')}}
                            @elseif($editPage)
                                {{$kosan->kotakab}}
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <input type="text" class="autocomplete form-control"/>
                            @if($editPage)
                                @foreach($kotakab as $datum)
                                <li><a href="#" data-value="{{ $datum->id }}">{{ $datum->nama }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Kecamatan</h4>
                    <input type="hidden" name="kecamatan" id="kecamatan" value="{{ $errorPage ? old('kecamatan') : $kosan->kecamatan }}"/>
                    <div class="dropdown" target="#kecamatan" id="kecamatan-drop">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(!$errorPage && !$editPage)
                                Pilih Kecamatan
                            @elseif($errorPage)
                                {{old('kecamatan')}}
                            @elseif($editPage)
                                {{$kosan->kecamatan}}
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <input type="text" class="autocomplete form-control"/>
                            @if($editPage)
                                @foreach($kecamatan as $datum)
                                <li><a href="#" data-value="{{ $datum->id }}">{{ $datum->nama }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Kelurahan</h4>
                    <input type="hidden" name="kelurahan" id="kelurahan" value="{{ $errorPage ? old('kelurahan') : $kosan->idkelurahan }}"/>
                    <div class="dropdown" target="#kelurahan" id="kelurahan-drop">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(!$errorPage && !$editPage)
                                Pilih Kelurahan
                            @elseif($errorPage)
                                {{ old('kelurahan') }}
                            @elseif($editPage)
                                {{ $kosan->kelurahan }}
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <input type="text" class="autocomplete form-control"/>
                            @if($editPage)
                                @foreach($kelurahan as $datum)
                                <li><a href="#" data-value="{{ $datum->id }}">{{ $datum->nama }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title">Fasilitas Kosan</h3>
            </div>

            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Wi-fi</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="wifi" id="wifi" value="{{ $errorPage ? old('wifi') : $editPage ? $kosan->wifi : 0 }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Kamar mandi dalam</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="kmdalam" id="kmdalam" value="{{ $errorPage ? old('kmdalam') : $editPage ? $kosan->kmdalam :0 }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Akses 24 jam</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="jammalam" id="jammalam" value="{{ $errorPage ? old('jammalam') : $editPage ? $kosan->jammalam : 0}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Tempat Parkir</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="tempatparkir" id="tempatparkir" value="{{ $errorPage ? old('tempatparkir') : $editPage ? $kosan->tempatparkir :0 }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Dapur</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="dapur" id="dapur" value="{{ $errorPage ? old('dapur') : $editPage ? $kosan->dapur : 0 }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Lemari es</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="lemaries" id="lemaries" value="{{ $errorPage ? old('lemaries') : $editPage ? $kosan->lemaries : 0 }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label class="col-md-6 control-label">Televisi</label>
                        <div class="col-md-6">
                            <input type="hidden" class="boolean-input" name="televisi" id="televisi" value="{{ $errorPage ? old('televisi') : $editPage ? $kosan->televisi : 0 }}"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title">Jenis Kosan</h3>
            </div>

            <div class="form-group">
                <label for="kategori" class="col-md-3 control-label">Kategori Kosan</label>
                <div class="col-md-6">
                    <input type="hidden" name="jeniskosan" id="jeniskosan" value="{{ $errorPage ? old('jeniskosan') : ($kosan->keluarga) ? 'keluarga' : 'perorangan' }}">
                    <div class="dropdown" target="#jeniskosan" id="jeniskosan-drop">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(!$errorPage && !$editPage)
                                Pilih Jenis Penyewa
                            @elseif(($errorPage && old('jeniskosan') == 'keluarga') ||
                                    ($editPage) && $kosan->keluarga)
                                Keluarga
                            @else
                                Perorangan/Pelajar
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-value="perorangan">Perorangan/Pelajar</a></li>
                            <li><a href="#" data-value="keluarga">Keluarga</a></li>
                        </ul>
                    </div>
                    @if ($errors->has('jeniskosan'))
                    <span class="help-block">
                        <strong>Pilih jenis kosan anda !</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group" id="jeniskelamin-form" @if($editPage && $kosan->keluarga) style="display:none" @endif>
                <label for="jeniskelamin" class="col-md-3 control-label">Jenis Kelamin Penyewa</label>
                <div class="col-md-6">
                    <input type="hidden" name="jeniskelamin" id="jeniskelamin" value="{{ $errorPage ? old('jeniskelamin') : ($kosan->kosanperempuan) ? 'P' : 'L' }}"/>
                    <div class="dropdown" target="#jeniskelamin" id="jeniskelamin-drop">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            @if(!$errorPage && !$editPage)
                                Pilih Jenis Kelamin
                            @elseif(($errorPage && old('jeniskelamin') == 'P') ||
                                    ($editPage && $kosan->kosanperempuan))
                                Perempuan
                            @else
                                Laki-laki
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-value="L">Laki-laki</a></li>
                            <li><a href="#" data-value="P">Perempuan</a></li>
                        </ul>
                    </div>
                    @if ($errors->has('jeniskelamin'))
                    <span class="help-block">
                        <strong>Pilih jenis kelamin penyewa kosan anda !</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title">Tambahkan Deskripsi</h3>
            </div>

            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>Tambahkan deskripsi tentang kosan anda</h4>
                <p>Berikan penjelasan lebih tentang kosan anda, mungkin tentang peraturan kosan atau informasi tambahan lainnya tentang kosan anda.</p>
            </div>

            <textarea id="deskripsi" name="deskripsi">{{ $errorPage ? old('deskripsi') : $kosan->keterangan }}</textarea>
            @if ($errors->has('deskripsi'))
            <span class="help-block">
                <strong>{{ $errors->first('deskripsi') }}</strong>
            </span>
            @endif
            <br/>

            <div class="form-group">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i>&nbsp;&nbsp;Daftarkan Sekarang</button>
                </div>
            </div>

        </form>

        <form class="file-upload" action="{{ route('upload.images') }}" method="post" enctype="multipart/form-data" style="display: none">
            {{ csrf_field() }}
            <input type="file" name="images[]" id="foto" multiple/>
        </form>
    </div>
</div>

<script>
    var route = 'kosanform';
</script>

@if(Route::current()->getname() == 'edit.kosan')
    <script>
        var definedLocation = {
            lat : {{ $kosan->latitude }},
            lng : {{ $kosan->longitude  }}
        };
    </script>
@endif

@endsection
