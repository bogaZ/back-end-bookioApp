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
                            <button data-toggle="modal" data-target="#modal-export"
                                class="btn btn-success float-right mb-3"><i class="fa-solid fa-file-export mr-2"></i>Export
                                PDF</button>
                        </div>

                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Transaksi</th>
                                <th>Penyewa</th>
                                <th>Studio</th>
                                <th>Pemilik</th>
                                <th>Pembayaran</th>
                                <th>- 5%</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->invoice }}</td>
                                    <td>{{ $transaksi->nama_penyewa }}</td>
                                    <td>{{ $transaksi->nama_studio }}</td>
                                    <td>{{ $transaksi->nama_pemilik }}</td>
                                    <td>Rp. {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaksi->biaya_admin, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaksi->total - $transaksi->biaya_admin, 0, ',', '.') }}</td>
                                    <td>{{ $transaksi->created_at }}</td>
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
