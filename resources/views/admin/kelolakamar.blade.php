@extends('layouts.user.page')

@section('title')
    Kelola Kamar Kosan dari {{ $kosan->nama }}
@endsection

@section('contents')
	
	<div class="row">
	<div class="col-lg-6">
    <h3 style="margin:15px 0 0">Kelola Kamar Kosan dari {{ $kosan->nama }}</h3>
	</div>
	<div class="col-lg-2"></div>
	<div class="col-lg-4">
		<form action="{{ route('kelola.kamar',['idkosan' => $kosan->id]) }}" method="get">
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
		<p>Menampilkan hasil pencarian untuk '{{ $cari }}'. <a href="{{ route('kelola.kamar',['id' => $kosan->id]) }}">Tampilkan semua kamar</a></p>
		</div>
	@endif
	<table class="table-ui">
        <thead>
            <tr>
                <th>Nama Kamar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
		@foreach($kamar as $item)
            <tr>
                <td><b><a target="_blank" href="{{ route('lihat.kamar',['idkamar' => $item->id]) }}">{{ $item->nama }}  <i class="fa fa-external-link"></i></a></b></td>
                <td class="aksi">
                    <div class="btn-group">
						<a class="btn btn-warning" href="{{ route('tangguhkan.kamar',['id' => $item->id]) }}">{{ $item->ditangguhkan ? 'Batalkan Penangguhan' : 'Tangguhkan' }}</a>
						<a class="btn btn-danger" href="{{ route('hapus.kamar',['idkamar' => $item->id]) }}">Hapus</a>
                    </div>
                </td>
            </tr>
		@endforeach
        </tbody>
    </table>

	{{ $kamar->links() }}

@endsection