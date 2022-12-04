@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-3">

        </div>
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan Akun Admin</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/akunAdmin/update" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama User</label>
                            <input name="name" value="{{ old('name', auth()->user()->name) }}" type="text"
                                class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1"
                                placeholder="Masukkan nama user">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input name="email" value="{{ old('email', auth()->user()->email) }}" type="email"
                                class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1"
                                placeholder="Enter email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nomer Hp</label>
                            <input name="nomor_hp" value="{{ old('nomor_hp', auth()->user()->nomor_hp) }}" type="number"
                                class="form-control @error('nomor_hp') is-invalid @enderror" id="exampleInputEmail1"
                                placeholder="Masukkan Nomer Hp">
                            @error('nomor_hp')
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
