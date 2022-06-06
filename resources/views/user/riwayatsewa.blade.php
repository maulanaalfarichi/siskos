@extends('layouts.user.page')

@section('title')
    Beranda
@endsection

@section('contents')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Riwayat Sewa Saya</h3>
        </div>

        <div class="panel-body">
            @if(count($sewa) == 0)
                <div class="alert alert-info">
                    <p>Belum ada penyewa untuk kosan anda.</p>
                </div>
            @else
            <table class="table table-hover">
                <thead>
                <tr>
                    <td><i class="fa fa-ticket"></i>&nbsp;&nbsp;&nbsp;&nbsp;Kode</td>
                    <td class="hidden-sm hidden-xs"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Nama Kosan</td>
                    <td class="hidden-sm hidden-xs"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Sewa
                    </td>
                    <td><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;&nbsp;Status</td>
                </tr>
                @foreach($sewa as $daftar)
                    <tr>
                        <td><a href="{{ route('lihat.tiket',['idtiket' => $daftar->kode]) }}"
                               target="_blank"> {{ $daftar->kode }}&nbsp;&nbsp; <i class="fa fa-external-link"></i></a>
                        </td>
                        <td class="hidden-sm hidden-xs">{{ $daftar->namakamar }}, {{ $daftar->namakosan }}</td>
                        <td class="hidden-sm hidden-xs">{{ $daftar->tanggal }}</td>
                        <td>{{ $daftar->status == 'MP' ? 'Menunggu Pembayaran' : 'Selesai' }}</td>
                    </tr>
                @endforeach
                </thead>
            </table>
                @endif
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Riwayat Sewa Kosan Saya</h3>
        </div>

        <div class="panel-body">
            @if(count($disewakan) == 0)
                <div class="alert alert-info">
                    <p>Anda belum menyewa kosan apapun.</p>
                </div>
            @else
                <table class="table table-hover table-riwayat-sewa">
                    <thead>
                    <tr>
                        <td><i class="fa fa-ticket"></i>&nbsp;&nbsp;&nbsp;&nbsp;Kode</td>
                        <td class="hidden-sm hidden-xs"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Nama Kosan
                        </td>
                        <td class="hidden-sm hidden-xs"><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal
                            Sewa
                        </td>
                        <td><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;&nbsp;Status</td>
                    </tr>

                    @foreach($disewakan as $daftar)
                        <tr>
                            <td><a href="{{ route('lihat.tiket',['idtiket' => $daftar->kode]) }}"
                                   target="_blank"> {{ $daftar->kode }}&nbsp;&nbsp; <i class="fa fa-external-link"></i></a>
                            </td>
                            <td class="hidden-sm hidden-xs">{{ $daftar->namakamar }}, {{ $daftar->namakosan }}</td>
                            <td class="hidden-sm hidden-xs">{{ $daftar->tanggal }}</td>
                            <td>{{ $daftar->status == 'MP' ? 'Menunggu Pembayaran' : 'Selesai' }}</td>
                        </tr>
                    @endforeach

                    </thead>
                </table>
            @endif
        </div>
    </div>
@endsection
