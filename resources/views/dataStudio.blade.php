@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable with default features</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Studio</th>
                                <th>Owner</th>
                                {{-- <th>Fasilitas</th> --}}
                                <th>Alamat</th>
                                <th>Terakhir Transaksi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studios as $studio)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $studio->nama_studio }}</td>
                                    <td>{{ $studio->user->name }}</td>
                                    {{-- <td>{{ count($studio->fasilitas) }}</td> --}}
                                    <td>{{ $studio->alamat }}</td>
                                    <td>@if ($studio->pemesanan->where('status', 'Berhasil Dipesan')->whereNotIn('user_id', null) != '[]') {{ date('m/d/Y h:i:s a', strtotime($studio->pemesanan->where('user_id','!=', null)->last()->created_at)) }}
                                        @else
                                        Belum Ada Transaksi @endif </td>
                                    <td>
                                        <div class="btn @if ($studio->status_tempat != 'Terverifikasi') btn-danger @endif btn-primary">
                                            {{ $studio->status_tempat }}</div>
                                    </td>
                                    <td><a href="/detailStudio/{{ $studio->id }}" class="btn btn-primary"><i
                                                class="fa-regular fa-eye" style="color: white;"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
