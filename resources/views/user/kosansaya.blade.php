@extends('layouts.user.page')

@section('title')
    Kosan Saya
@endsection

@section('contents')
    @if(count($DaftarKosan) == 0)
        <div class="panel panel-notif notif-lg row">
            <div class="notif-body col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <h3 class="notif-heading">Tampaknya anda belum mendaftarkan kosan</h3>
                <div class="notif-content">
                    <p>Daftarkan kosan anda sekarang dan dapatkan berbagai kemudahan !</p>
                    <a href="{{ route('tambah.kosan') }}" class="btn btn-primary">Daftarkan Kosan Sekarang</a>
                </div>
            </div>
            <div class="notif-icon col-lg-3 col-md-3 col-sm-3 hidden-xs">
                <img class="img-responsive" src="{{ asset('images/ava.jpg') }}"/>
            </div>
        </div>

    @else

        <div class="pane panel-thumb-list">
            <div class="panel-heading">
                <h2 class="panel-title" style="font-size:25px">Kosan Saya</h2>
                <div class="panel-tool">
                    <a href="{{ route('tambah.kosan') }}" class="btn btn-primary">Daftarkan Kosan Baru</a>
                </div>
            </div>
            <div class="row">
            @foreach($DaftarKosan as $kosan)
                <div class="col-lg-4 kosan-{{ $kosan->id }}">
                    <div class="thumbnail">
                        <div class="header">
                            <h3><a href="{{ route('lihat.kosan',['idkosan' => $kosan->id]) }}">{{ $kosan->nama }}</a> <a href="{{ route('lihat.kosan',['idkosan' => $kosan->id]) }}" target="_blank" title="lihat di tab baru"><sup><i class="fa fa-external-link"></i></sup></a></h3>
                            <h4>{{ $kosan->alamat }}</h4>
                        </div>
                        <div class="image">
                            <img src="{{ asset('storage/'.$kosan->foto) }}"/>
                        </div>
                        <span class="price">{{ Currency::pricing($kosan->hargamin,$kosan->hargamax) }}</span>
                        <div class="info">
                            <div>
                                <span>Jenis Kosan</span>
                                <span>{{ $kosan->keluarga ? 'Keluarga' : 'Perorangan' }}</span>
                            </div>
                            <div>
                                <span>Kamar Tersedia</span>
                                <span>{{ $kosan->jumlahkamar or 0 }}</span>
                            </div>
                        </div>
                        <div class="action">
                            <div class="btn-group">
                                <a href="{{ route('edit.kosan',['idkosan' => $kosan->id]) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="{{ route('daftar.kamar',['idkosan' => $kosan->id]) }}" class="btn btn-primary"><i class="fa fa-list"></i> Daftar Kamar</a>
                                <a href="{{ route('hapus.kosan',['idkosan' => $kosan->id]) }}" class="btn btn-danger delete-kosan"><i class="fa fa-trash"></i> Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    @endif
@endsection
