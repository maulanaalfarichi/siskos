@extends('layouts.user.page')

@section('title')
    Kosan Saya
@endsection

@section('contents')
    @if(count($kamar) == 0)
    <div class="panel panel-notif notif-lg row">
        <div class="notif-body col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <h3 class="notif-heading">Ups, Belum ada kamar dalam kosan ini</h3>
            <div class="notif-content">
                <p>Tambahkan kamar kosan anda sekarang dan dapatkan berbagai kemudahan !</p>
                <a href="{{ url('tambah/kamar/'.$kosan->id) }}" class="btn btn-primary">Tambah Kamar Sekarang</a>
            </div>
        </div>
        <div class="notif-icon col-lg-3 col-md-3 col-sm-3 hidden-xs">
            <img class="img-responsive" src="{{ asset('images/ava.jpg') }}"/>
        </div>
    </div>

    @else

    <div class="panel panel-thumb-list">
        <div class="panel-heading">
            <h2 class="panel-title" style="font-size:25px">Kamar pada {{ $kosan->nama }}</h2>
            <div class="panel-tool">
                <a href="{{ route('tambah.kamar',['idkosan' => $kosan->id]) }}" class="btn btn-primary">Tambah Kamar Baru</a>
            </div>
        </div>

        <div class="row">
            @foreach($kamar as $detail)
                <div class="col-lg-4 kamar-{{ $detail->id }}">
                    <div class="thumbnail">
                        <div class="header">
                            <h3><a href="{{ route('lihat.kamar',['idkamar' => $detail->id]) }}">{{ $detail->nama }}</a> <a href="{{ route('lihat.kamar',['idkamar' => $detail->id]) }}" target="_blank" title="lihat di tab baru"><sup><i class="fa fa-external-link"></i></sup></a></h3>
                        </div>
                        <div class="image">
                            <img src="{{ asset('storage/'.$detail->foto) }}"/>
                        </div>
                        <span class="price">{{ Currency::format($detail->harga) }}</span>
                        <div class="info">
                            <div>
                                <span>Ditangguhkan</span>
                                <span>{{ $detail->ditangguhkan ? 'Ya' : 'Tidak' }}</span>
                            </div>
                            <div>
                                <span>Status</span>
                                <span>{{ $detail->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                            </div>
                        </div>
                        <div class="action">
                            <div class="btn btn-group">
                                <a href="{{ route('edit.kamar',['idkamar' => $detail->id]) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit Kamar</a>
                                <a href="{{ route('hapus.kamar',['idkamar' => $detail->id]) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus Kamar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection
