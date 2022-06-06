@extends('layouts.app')

@section('title')
    Beranda
@endsection

@section('content')
    <section class="container-fluid" id="landing-wrapper">
        <div class="row">
            <h1>Butuh Rumah Kedua ?</h1>
            <h4>Cari sekarang, dan nikmati kenyamanannya</h4>
            <div class="col-lg-8 col-lg-offset-2">
                <form id="search-tron" action="{{ route('cari') }}" method="get">
                    <input type="hidden" id="lat-search" name="latitude"/>
                    <input type="hidden" id="lng-search" name="longitude"/>
                    <div class="input-group" id="main-search">
                        <input type="text" name="location" id="location-field" placeholder="Ketikkan sebuah lokasi ..."
                               required autocomplete="off" autofocus/>
                        <span class="input-group-btn">
                            <button type="submit" class="btn-submit">
                                <svg focusable="false" width="20" height="20" viewBox="0 0 10 10">
                                <path fill="#000" d="M7.73732912,6.67985439 C7.75204857,6.69246326 7.76639529,
                                6.70573509 7.7803301,6.7196699 L9.65165045,8.59099025 C9.94454365,
                                8.8838835 9.94454365,9.3587572 9.65165045,9.65165045 C9.3587572,
                                9.94454365 8.8838835,9.94454365 8.59099025,9.65165045 L6.7196699,
                                7.7803301 C6.70573509,7.76639529 6.69246326,7.75204857 6.67985439,
                                7.73732912 C5.99121283,8.21804812 5.15353311,8.5 4.25,8.5 C1.90278981,
                                8.5 0,6.59721019 0,4.25 C0,1.90278981 1.90278981,0 4.25,0 C6.59721019,
                                0 8.5,1.90278981 8.5,4.25 C8.5,5.15353311 8.21804812,5.99121283
                                7.73732912,6.67985439 L7.73732912,6.67985439 Z M4.25,7.5 C6.04492544,
                                7.5 7.5,6.04492544 7.5,4.25 C7.5,2.45507456 6.04492544,1 4.25,1
                                C2.45507456,1 1,2.45507456 1,4.25 C1,6.04492544 2.45507456,7.5 4.25,
                                7.5 L4.25,7.5 Z"></path>
                            </svg>
                            </button>
                        </span>
                    </div>
                    <div class="separator">
                        <div class="filter-btn"><i class="fa fa-chevron-circle-up fa-3x"></i></div>
                    </div>
                    <div class="filter-tron">
					<div class="row">
						<div class="col-lg-4">
							<h3>Filter Pencarian</h3>
						</div>
						<div class="col-lg-4"></div>
						<div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Aktifkan Filter</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" value="0" id="filter"
                                               name="filter"/>
                                    </div>
                                </div>
                            </div>
					</div>
					
					<h4>Fasilitas</h4>
					
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Tempat Parkir</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" value="2" id="tempatparkir"
                                               name="tempatparkir"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Wifi</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" name="wifi" id="wifi" value="2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Dapur</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" value="2" name="dapur" id="dapur"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Kamar Mandi Dalam</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" value="2" name="kmdalam" id="kmdalam"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Televisi</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" value="2" name="televisi" id="televisi"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Akses 24 Jam</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" value="2" name="jammalam" id="jammalam"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label col-lg-8">Lemari Es</label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="check-input" value="2" name="lemaries" id="lemaries"/>
                                    </div>
                                </div>
                            </div>
                        </div>
						<h4>Harga dan Jenis Kosan</h4>
						<div class="row">
							<div class="col-lg-3">
                                <input type="number" min="0" class="bukosan input-ui ui-primary" name="hargamin"
                                       placeholder="Harga Minimal"/>
                            </div>
                            <div class="col-lg-3">
                                <input type="number" min="0" class="bukosan input-ui ui-primary" name="hargamax"
                                       placeholder="Harga Maksimal"/>
                            </div>
                            <div class="col-lg-3">
								<input id="jeniskosan" type="hidden" class="form-control" name="jeniskosan"
                               value="0"
                               required autofocus>
                        <div class="dropdown" target="#jeniskosan" id="jeniskelamin-drop">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                Jenis Kosan
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-value="0">Semua</a></li>
                                <li><a href="#" data-value="1">Kosan Laki-Laki</a></li>
                                <li><a href="#" data-value="2">Kosan Perempuan</a></li>
                                <li><a href="#" data-value="3">Kosan Keluarga</a></li>
                            </ul>
                        </div>
                            </div>
							<button class="col-lg-3 btn btn-success" type="submit">
								<i class="fa fa-search"></i> Cari
							</button>
						</div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
