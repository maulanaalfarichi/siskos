@extends('layouts.app')

@section('title')
    {{ $kamar->nama }} pada {{ $kosan->nama }}
@endsection

@section('content')

    <div class="container">
        <h2>{{ $kamar->nama }}</h2>
        <div class="line-round primary" style="width:75px"></div>
        <h4>Kamar dari <a href="{{ url('kosan',['id' => $kosan->id]) }}">{{ $kosan->nama }}</a></h4>

        <div class="row">
            <div class="col-lg-4">
                <div class="box-icon">
                    <div class="icon primary">
                        <i class="fa fa-tag fa-2x"></i>
                    </div>
                    <p>
                        <span>Harga</span>
                        <span>{{ Currency::format($kamar->harga) }}/bln</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box-icon">
                    <div class="icon warning">
                        <i class="fa fa-star fa-2x"></i>
                    </div>
                    <p>
                        <span>Difavoritkan oleh</span>
                        <span>{{ $favorit }} pengguna</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box-icon">
                    <div class="icon success">
                        <i class="fa fa-home fa-2x"></i>
                    </div>
                    <p>
                        <span>Disewa sebanyak</span>
                        <span>{{ $jumlahsewa or 0 }} kali</span>
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

                <br/>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Keterangan</h3>
                    </div>

                    <div class="panel-body">
                        {!! $kamar->keterangan !!}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="image-zoom-area" style="background-image:url('{{ asset('storage/' . $foto[0]->nama) }}')"></div>
                <div class="panel panel-default panel-fasilitas">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fasilitas Kamar</h3>
                        @if(Auth::check() && Auth::user()->id != $kosan->idpemilik)
                            <i class="fa  fa-2x favorit {{ $favorited > 0 ? 'fa-star favorited' : 'fa-star-o'}}"
                               title="Favoritkan kamar ini" data-fav="{{ $kamar->id }}"></i>
                        @endif
                    </div>
                    <div class="panel-body">
                        <ul>
                            <li>
                                <span>AC</span>
                                <span class="{{ $kamar->ac ? 'green' : 'red' }}">{{ $kamar->ac ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Kipas Angin</span>
                                <span class="{{ $kamar->kipasangin ? 'green' : 'red' }}">{{ $kamar->kipasangin ? 'Ya' : 'Tidak' }}</span>
                            </li>
                            <li>
                                <span>Lemari</span>
                                <span class="{{ $kamar->lemari ? 'green' : 'red' }}">{{ $kamar->lemari ? 'Ya' : 'Tidak' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(Auth::check() && Auth::user()->id != $kosan->idpemilik)
                    <div class="row">
                        @if($kamar->tersedia)
                            <a class="btn btn-primary col-lg-8 col-lg-offset-2 btn-lg {{ !$tersedia || Auth::user()->ditangguhkan ? 'disabled' : '' }}"
                               href="{{ route('sewa.kamar') }}"
                               onclick="event.preventDefault();
                    document.getElementById('sewa-form').submit();"><i
                                        class="fa fa-home"></i> Sewa kamar ini</a>
                            @if(!$tersedia)
                                <div style="clear:both;margin-bottom:20px"></div>
                                <p class="alert alert-danger">Kamar kosan ini tidak tersedia untuk jenis akun anda atau
                                    mungkin sedang ditempati oleh orang lain.</p>
                            @elseif(Auth::user()->ditangguhkan)
                                <div style="clear:both;margin-bottom:20px"></div>
                                <p class="alert alert-danger">Akun anda sedang ditangguhkan, sehingga anda tidak bisa
                                    melakukan pemesanan.</p>
                            @endif
                            <form id="sewa-form" action="{{ route('sewa.kamar') }}" method="POST"
                                  style="display: none;">
                                <input type="hidden" name="id" value="{{ $kamar->id }}">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </div>
                @endif
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('js/zoomove.min.js') }}"></script>
@endsection
