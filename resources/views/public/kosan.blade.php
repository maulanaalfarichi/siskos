@extends('layouts.app')

@section('title')
    {{ $kosan->nama }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/zoomove.min.css') }}">
@endsection
@section('content')
    <script>
        var route = 'kosan';
        var definedLocation = {
            lat: {{ $kosan->latitude }},
            lng: {{ $kosan->longitude  }}
        };
    </script>
    <div class="container">
        <h2>{{ $kosan->nama }}</h2>

        <div class="row">
            <div class="col-lg-3">
                <div class="box-icon">
                    <div class="icon success">
                        <i class="fa fa-map-marker fa-2x"></i>
                    </div>
                    <p>
                        <span>Alamat</span>
                        <span>{{ $kosan->alamat }}</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box-icon">
                    <div class="icon primary">
                        <i class="fa fa-tag fa-2x"></i>
                    </div>
                    <p>
                        <span>{{ $hargamax - $hargamin > 0 ? 'Kisaran' : '' }} Harga</span>
                        <span>{{ Currency::pricing($hargamin,$hargamax) }}</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box-icon">
                    <div class="icon warning">
                        <i class="fa fa-star fa-2x"></i>
                    </div>
                    <p>
                        <span>Difavoritkan sebanyak</span>
                        <span>{{ $favorit }}</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box-icon">
                    <div class="icon success">
                        <i class="fa fa-home fa-2x"></i>
                    </div>
                    <p>
                        <span>Disewa sebanyak</span>
                        <span>{{ $sewa }}</span>
                    </p>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-8">
                <div id="foto-kosan">
                    <div class="image-viewer">
                        <div class="image-main"
                             style="background-image:url('{{ asset('storage/' . $foto[0]->nama) }}')">
                            <div class="image-zoomer"></div>
                        </div>
                        <div class="image-list">
                            @foreach($foto as $counter => $detail)
                                <img {{ $counter == 0  ? 'class=active' : ''}} src="{{ asset('storage/' . $detail->nama) }}"/>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bigtron" id="searchresult">
                    <div class="row">
                        <h3 style="padding:10px;">Daftar Kamar yang Tersedia</h3>
                        @if(count($kamar) == 0)
                            <div class="alert alert-info">
                                <p>Untuk saat ini, tidak ada kamar yang tersedia</p>
                            </div>
                            @endif
                        @foreach($kamar as $hasil)
                            <div class="col-lg-4">
                                <div class="thumbnail">
                                    <div class="image"
                                         style="background-image:url('{{ asset('storage/' . $hasil->foto) }}')"></div>
                                    <div class="name">
                                        <h3>{{ $hasil->nama }}</h3>
                                        <p class="price">{{ Currency::format($hasil->harga) }}</p>
                                    </div>
                                    <div class="detail">
                                        <div class="bottom">
                                            <p class="detail-item">
                                                <span>AC</span>
                                                <span class="{{ $hasil->ac ? 'green' : 'red' }}">{{ $hasil->ac ? 'Ya' : 'Tidak' }}</span>
                                            </p>
                                            <p class="detail-item">
                                                <span>Kipas Angin</span>
                                                <span class="{{ $hasil->kipasangin ? 'green' : 'red' }}">{{ $hasil->kipasangin ? 'Ya' : 'Tidak' }}</span>
                                            </p>
                                            <p class="detail-item">
                                                <span>Lemari</span>
                                                <span class="{{ $hasil->lemari ? 'green' : 'red' }}">{{ $hasil->lemari ? 'Ya' : 'Tidak' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="action">
                                        <a href="{{ route('lihat.kamar',[ 'id' => $hasil->id ]) }}">Lihat <i
                                                    class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Keterangan</h3>
                    </div>

                    <div class="panel-body">
                        {!! $kosan->keterangan !!}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="image-zoom-area" style="background-image:url('{{ asset('storage/' . $foto[0]->nama) }}')">
                </div>

                <div class="panel panel-default panel-fasilitas">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fasilitas Kosan</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <li>
                                <span>Akses 24 jam</span>
                                <span class="{{ $kosan->jammalam ? 'green' : 'red' }}">{{ $kosan->jammalam ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Kamar mandi dalam</span>
                                <span class="{{ $kosan->kmdalam ? 'green' : 'red' }}">{{ $kosan->kmdalam ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Tempat Parkir</span>
                                <span class="{{ $kosan->tempatparkir ? 'green' : 'red' }}">{{ $kosan->tempatparkir ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Wifi</span>
                                <span class="{{ $kosan->wifi ? 'green' : 'red' }}">{{ $kosan->wifi ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Dapur</span>
                                <span class="{{ $kosan->dapur ? 'green' : 'red' }}">{{ $kosan->dapur ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Lemari Es</span>
                                <span class="{{ $kosan->lemaries ? 'green' : 'red' }}">{{ $kosan->lemaries ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Televisi</span>
                                <span class="{{ $kosan->televisi ? 'green' : 'red' }}">{{ $kosan->televisi ? 'Ya' : 'Tidak' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <h4>Lokasi Kosan</h4>
                <div id="map" style="height:250px;width:100%">
                </div>

                <br/>
                <div class="panel panel-profile">
                    <div class="panel-heading">
                        <h3 class="panel-title">Info Pemilik Kosan</h3>
                    </div>

                    <div class="panel-body">
                        <img src="{{ asset('storage/' . $pemilik->avatar) }}" class="img-circle"
                             style="width:100px;height:100px;margin:20px auto;display:block"/>
                        <h4 style="text-align:center">{{ $pemilik->displayname }}</h4>
                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-4">
                                <div class="line-round primary"></div>
                            </div>
                        </div>
                        <h5 style="text-align:center">Kontak</h5>
                        <ul>
                            <li>
                                <span>E-mail</span>
                                <span>{{ $pemilik->email }}</span>
                            </li>
                            <li>
                                <span>No. Telp</span>
                                <span>{{ $pemilik->telp }}</span>
                            </li>
                        </ul>@if(Auth::check() && Auth::user()->id != $pemilik->id)
                            <div style="padding:10px">
                                <a href="{{ route('pesan',['id' => $pemilik->id]) }}" class="btn btn-success"><i
                                            class="fa fa-paper-plane"></i>&nbsp;&nbsp;Kirim Pesan</a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('js/zoomove.min.js') }}"></script>
@endsection
