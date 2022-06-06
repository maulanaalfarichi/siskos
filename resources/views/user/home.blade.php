@extends('layouts.user.page')

@section('title')
    Beranda
@endsection

@section('contents')
    @if(Auth::user()->admin)
        <div class="row" style="margin-bottom: 15px">
        <div class="col-lg-4">
            <div class="box-icon box-lg">
                <div class="icon primary">
                    <i class="fa fa-user fa-3x"></i>
                </div>
                <p>
                    <span>Total User</span>
                    <span>{{ $totaluser }}</span>
                </p>
            </div>
        </div>
            <div class="col-lg-4">
            <div class="box-icon box-lg">
                <div class="icon primary">
                    <i class="fa fa-hotel fa-3x"></i>
                </div>
                <p>
                    <span>Total Kosan</span>
                    <span>{{ $totalkosan }}</span>
                </p>
            </div>
        </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-4">
            <div class="box-icon box-lg">
                <div class="icon primary">
                    <i class="fa fa-hotel fa-3x"></i>
                </div>
                <p>
                    <span>Kosan Saya</span>
                    <span>{{ $jumlahkosan }}</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box-icon box-lg">
                <div class="icon warning">
                    <i class="fa fa-star fa-3x"></i>
                </div>
                <p>
                    <span>Favorit Saya</span>
                    <span>{{ $jumlahfavorit }}</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box-icon box-lg">
                <div class="icon success">
                    <i class="fa fa-envelope fa-3x"></i>
                </div>
                <p>
                    <span>Pesan Baru</span>
                    <span>{{ $pesanbaru }} pesan baru</span>
                </p>
            </div>
        </div>
    </div>

    <h3 style="margin-top: 15px">Kosan yang Terakhir Kali dikunjungi</h3>

    <div class="row">
        @foreach($kunjungan as $item)
            <div class="col-lg-4">
                <div class="thumbnail">
                    <div class="header">
                        <h3><a href="{{ route('lihat.kosan',['idkosan' => $item->id]) }}">{{ $item->nama }}</a> <a
                                    href="{{ route('lihat.kosan',['idkamar' => $item->id]) }}" target="_blank"
                                    title="lihat di tab baru"><sup><i class="fa fa-external-link"></i></sup></a></h3>
                        <h4>{{ $item->alamat }}</h4>
                    </div>
                    <div class="image">
                        <img src="{{ asset('storage/'.$item->foto) }}"/>
                    </div>
                    <span class="price">
					{{ Currency::pricing($item->hargamin, $item->hargamax) }}
                    </span>
                    <div class="info">
                        <div>
                            <span>Jenis Kosan</span>
                            <span>{{ $item->keluarga ? 'Keluarga' : 'Perorangan' }}</span>
                        </div>
                        <div>
                            <span>Kamar Tersedia</span>
                            <span>{{ $item->jumlahkamar }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
