@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-3">

        </div>
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan Pembayaran</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/pembayaran" method="POST">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Bank</label>
                            <input
                                value="@if ($pembayaran != null) {{ old('nomer_rekening', $pembayaran->nama_bank) }} @endif"
                                name="nama_bank" type="text"
                                class="form-control @error('nama_bank') is-invalid @enderror"
                                placeholder="Masukkan Nama Bank" required>

                        </div>
                        @error('nama_bank')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nomer Rekening</label>
                            <input name="nomer_rekening"
                                value="@if ($pembayaran != null) {{ $pembayaran->nomer_rekening }} @endif"
                                class="form-control @error('nomer_rekening') is-invalid @enderror" id="exampleInputEmail1"
                                placeholder="Masukkan Nomer Hp">
                            @error('nomer_rekening')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @error('nomer_rekening')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>Nama Pemilik</label>
                            <input
                                value="@if ($pembayaran != null) {{ old('nomer_rekening', $pembayaran->nama_pemilik) }} @endif"
                                name="nama_pemilik" type="text"
                                class="form-control @error('nama_pemilik') is-invalid @enderror"
                                placeholder="Masukkan Nama Pemilik">
                        </div>
                        @error('nama_pemilik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        @if ($pembayaran != null)
                            <button type="submit" class="btn btn-primary">Update</button>
                        @else
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
