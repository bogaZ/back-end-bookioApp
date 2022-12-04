@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-3">

        </div>
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ubah Password Admin</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/change/password/admin" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password Lama</label>
                            <input required name="old_password" type="password "
                                class="form-control @error('old_password') is-invalid @enderror" id="exampleInputEmail1"
                                placeholder="Masukkan password lama">
                            @error('old_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password Baru</label>
                            <input required name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" id="exampleInputEmail1"
                                placeholder="Masukkan password baru">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ulangi Password</label>
                            <input required name="password_confirmation" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="exampleInputEmail1" placeholder="Ulangi password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Edit data...?')">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
