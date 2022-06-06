@extends('layouts.user.page')

@section('title')
    Kelola Kosan
@endsection

@section('contents')
	<div class="row">
	<div class="col-lg-4">
    <h3 style="margin:15px 0 0">Kelola Kosan</h3>
	</div>
	<div class="col-lg-4"></div>
	<div class="col-lg-4">
		<form action="{{ route('kelola.kosan') }}" method="get">
			<div class="input-group">
				<input type="text" class="bukosan input-ui ui-primary" placeholder="Cari kosan..." name="nama"/>
				<div class="input-group-btn">
					<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
				</div>
			</div>
		</form>
	</div>
	</div>
	<br/>
	@if(isset($cari))
		<div class="alert alert-info">
		<p>Menampilkan hasil pencarian untuk '{{ $cari }}'. <a href="{{ route('kelola.kosan') }}">Tampilkan semua kosan</a></p>
		</div>
	@endif
	<table class="table-ui">
        <thead>
            <tr>
                <th>Nama Kosan</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
		@foreach($kosan as $item)
            <tr>
                <td><b><a target="_blank" href="{{ route('lihat.kosan',['idkosan' => $item->id]) }}">{{ $item->nama }}  <i class="fa fa-external-link"></i></a></b></td>
                <td>{{ $item->alamat }}</td>
                <td class="aksi">
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('kelola.kamar',['id' => $item->id]) }}">Kelola Kamar</a>
						<a class="btn btn-warning" href="{{ route('tangguhkan.kosan',['id' => $item->id]) }}">{{ $item->ditangguhkan ? 'Batalkan Penangguhan' : 'Tangguhkan' }}</a>
						@if(!$item->terverifikasi)
							<a class="btn btn-warning" href="{{ route('verifikasi.kosan',['id' => $item->id]) }}">Verifikasi</a>
						@endif
						<a class="btn btn-danger delete-kosan" href="{{ route('hapus.kosan',['id' => $item->id]) }}" data-id="{{ $item->id }}">Hapus</a>
                    </div>
                </td>
            </tr>
		@endforeach
        </tbody>
    </table>

	{{ $kosan->links() }}
@endsection