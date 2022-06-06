@extends('layouts.user.page')

@section('title')
    Kelola User
@endsection

@section('contents')
    <div class="row">
        <div class="col-lg-6">
            <h3 style="margin:15px 0 0">Kelola User</h3>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-4">
            <form action="{{ route('kelola.user') }}" method="get">
                <div class="input-group">
                    <input type="text" class="bukosan input-ui ui-primary" placeholder="Cari User..." name="nama"/>
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
            <p>Menampilkan hasil pencarian untuk '{{ $cari }}'. <a href="{{ route('kelola.user') }}">Tampilkan semua user</a></p>
        </div>
    @endif
	<table class="table-ui">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
		@foreach($users as $user)
            <tr>
                <td><b>{{ $user->displayname }}</b></td>
                <td>{{ $user->alamat }}</td>
                <td class="aksi">
                    <div class="x-group-btn">
                        <a href="{{ route('tangguhkan.user',['id' => $user->id]) }}" class="btn btn-warning">{{ $user->ditangguhkan ? 'Batalkan Penangguhan' : 'Tangguhkan' }}</a>
						<a href="{{ route('hapus.user',['id' => $user->id]) }}" class="btn btn-danger delete-user">Hapus</a>
                    </div>
                </td>
            </tr>
		@endforeach
        </tbody>
    </table>


    {{ $users->links() }}

@endsection

@section('js')
<script src="{{ asset('js/admin.js') }}"></script>
@endsection