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
                    <div class="row">
                        <div class="col"></div>
                        <div class="col">
                            <button data-toggle="modal" data-target="#modal-add-member"
                                class="btn btn-primary float-right mb-3"><i class="fa-solid fa-add mr-2"></i>Tambah
                                Member</button>
                        </div>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>Nomer Hp</th>
                                <th>Nomer Rekening</th>
                                <th>Nama Bank</th>
                                <th>Nasabah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->nomor_hp }}</td>
                                    <td>
                                        @if ($user->pembayaran != null)
                                            {{ $user->pembayaran->nomer_rekening }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->pembayaran != null)
                                            {{ $user->pembayaran->nama_bank }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->pembayaran != null)
                                            {{ $user->pembayaran->nama_pemilik }}
                                        @endif
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
