@extends('layouts.user.page')

@section('title')
    Beranda
@endsection

@section('contents')

    <h3>Favorit Saya</h3>

    <div class="row">
        @foreach($favorit as $kamar)
            <div class="col-lg-4">
                <div class="thumbnail">
                    <div class="header">
                        <h3><a href="{{ route('lihat.kamar',['idkamar' => $kamar->id]) }}">{{ $kamar->nama }}</a> <a href="{{ route('lihat.kamar',['idkamar' => $kamar->id]) }}" target="_blank" title="lihat di tab baru"><sup><i class="fa fa-external-link"></i></sup></a></h3>
                        <h4>{{ $kamar->namakosan }}</h4>
                    </div>
                    <div class="image">
                        <img src="{{ asset('storage/'.$kamar->foto) }}"/>
                    </div>
                    <span class="price">{{ Currency::format($kamar->harga) }}</span>
                    <div class="info">
                        <div>
                            <span>Jenis Kosan</span>
                            <span>{{ $kamar->keluarga ? 'Keluarga' : 'Perorangan' }}</span>
                        </div>
                        <div>
                            <span>Status</span>
                            <span>{{ $kamar->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
