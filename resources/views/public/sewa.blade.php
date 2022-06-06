@extends('layouts.app')

@section('title')
    Konfirmasi Penyewaan Kosan
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h2>Konfirmasi Penyewaan anda</h2>
        <div class="panel panel-confirm">
            <div class="panel-heading">
                <h3 class="panel-title" style="text-align:center;margin-top:10px">Konfirmasi penyewaan anda pada {{ $kosan->nama }}</h3>
            </div>

            <div class="panel-body">
                <div class="alert alert-info">
                    <p>Untuk saast ini, anda hanya bisa melakukan proses penyewaan dengan pembayaran COD atau bayar di tempat saat anda telah sampai pada kosan yang akan anda sewa</p>
                </div>
                <div class="row">
                    <div class="col-lg-2 line-round primary col-lg-offset-5"></div>
                </div>
                <h4 style="text-align:center">Detail Tiket</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <img class="img-responsive" src="{{ asset('storage/' . $foto->nama) }}"/>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel-tiket">
                            <ul>
                                <li>
                                    <span>Nama penyewa</span>
                                    <span>{{ Auth::user()->displayname }}</span>
                                </li>
                                <li>
                                    <span>Nama Kosan</span>
                                    <span>{{ $kosan->nama }}</span>
                                </li>
                                <li>
                                    <span>Alamat Kosan</span>
                                    <span>{{ $kosan->alamat }}, Kelurahan {{ $kosan->kelurahan }}, Kecamatan {{ $kosan->kecamatan }}, {{ $kosan->kotakab }}, {{ $kosan->provinsi }}</span>
                                </li>
                                <li>
                                    <span>Nama Kamar</span>
                                    <span>{{ $kamar->nama }}</span>
                                </li>
                                <li>
                                    <span>Nama Pemilik Kosan</span>
                                    <span>{{ $pemilik->displayname }}</span>
                                </li>
                                <li>
                                    <span>Harga Sewa Kamar</span>
                                    <span>Rp {{ $kamar->harga }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="alert alert-warning">
                            <p>Pastikan kamar yang anda pesan sesuai dengan yang anda inginkan.</p>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-2 line-round primary col-lg-offset-5"></div>
                    <br/>
                    <a class="btn btn-success col-lg-4 col-lg-offset-4 btn-lg" href="{{ route('sewa.tiket') }}"
                    onclick="event.preventDefault();
                    document.getElementById('tiket-form').submit();">Konfirmasi Penyewaan Saya</a>
                    <form id="tiket-form" action="{{ route('sewa.tiket') }}" method="POST"
                    style="display: none;">
                    <input type="hidden" name="id" value="{{ $kamar->id }}">
                    {{ csrf_field() }}
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
