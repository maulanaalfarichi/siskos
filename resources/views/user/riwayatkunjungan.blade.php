@extends('layouts.user.page')

@section('title')
    Riwayat Kunjungan
@endsection

@section('contents')
    <h3>Kosan yang Pernah Anda Lihat</h3>

    <div class="row">
        @foreach($kosan as $item)
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