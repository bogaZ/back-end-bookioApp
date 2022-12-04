@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Detail</h3>
                </div>
                <form>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Tempat</label>
                                    <input type="email" class="form-control" disabled value="{{ $studio->nama_studio }}"
                                        id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Pemilik / Owner</label>
                                    <input type="email" class="form-control" disabled value="{{ $studio->user->name }}"
                                        id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Alamat Tempat</label>
                                    <textarea disabled class="form-control" rows="3" placeholder="">{{ $studio->alamat }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Status Tempat</label>
                                            <br>
                                            <button data-toggle="modal" data-target="#modal-verifikasi" type="button"
                                                class="btn @if ($studio->status_tempat != 'Terverifikasi') btn-danger @endif btn-primary  col-12">
                                                {{ $studio->status_tempat }}</button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Status Transaksi</label>
                                            <br>
                                            <button data-toggle="modal" data-target="#modal-aktivasi" type="button"
                                                class="@if ($studio->status_transaksi != 'Aktif')btn  btn-secondary @else btn btn-success  @endif  col-12">
                                                {{ $studio->status_transaksi }}</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomer Telepon Pemilik</label>
                                    <input type="email" class="form-control" disabled
                                        value="{{ $studio->user->nomor_hp }}" id="exampleInputEmail1"
                                        placeholder="Enter email">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tarif Minimal</label>
                                            <input type="email" class="form-control" disabled
                                                value="Rp.  {{ number_format($studio->tarif_minimal, 0, ',', '.') }}"
                                                id="exampleInputEmail1" placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tarif Maksimal</label>
                                            <input type="email" class="form-control" disabled
                                                value="Rp. {{ number_format($studio->tarif_maksimal, 0, ',', '.') }}"
                                                id="exampleInputEmail1" placeholder="Enter email">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Deskripsi Tempat</label>
                                    <textarea disabled class="form-control" rows="3" placeholder="">{{ $studio->deskripsi }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Terakhir Transaksi</label>
                                            <input type="email" class="form-control" disabled
                                                value="@if ($studio->pemesanan->where('status', 'Berhasil Dipesan')->whereNotIn('user_id', null) != '[]') {{ date('m/d/Y h:i:s a', strtotime($studio->pemesanan->where('user_id','!=', null)->last()->created_at)) }}
                                                    @else
                                                    Belum Ada Transaksi @endif "
                                                id="exampleInputEmail1" placeholder="Enter email">
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div style="background-color: grey;height:1px"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fasilitas Dimiliki</label>
                                    <div class="row">
                                        @foreach ($fasilitas as $afasilitas)
                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-orange">
                                                    <div class="inner">
                                                        <h5 class="text-bold" style="color: white">
                                                            {{ $afasilitas->nama_fasilitas }}
                                                        </h5>

                                                        <p style="color: white">Rp.
                                                            {{ number_format($afasilitas->tarif, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="nav-icon far fa-solid fa-house"></i>
                                                    </div>
                                                    <div style="height: 10px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div style="background-color: grey;height:1px"></div>
                        </div>
                        <div class="col-12">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Foto Tempat</label>
                                    <div class="row">

                                        @foreach ($foto_studios as $foto_studio)
                                            <div class="col-md-4">
                                                <div class="card"
                                                    style="height: 300px; background-image: url('{{ asset('storage/'.$foto_studio->image)  }}');background-repeat: no-repeat;background-size: cover;">

                                                </div>


                                            </div>
                                        @endforeach

                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col -->

    </div>

     <!-- modal Verifikasi Tempat -->
     <div class="modal fade" id="modal-verifikasi">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="konfirmasi" class="modal-title">Update Status Tempat ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <div class="row">
                        <form action="/update/status/tempat/belum/{{ $studio->id }}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-danger mr-2">Belum Terverifikasi</button>
                        </form>
                        <form action="/update/status/tempat/{{ $studio->id }}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-primary">Terverifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- modal mengaktifkan Tempat -->
    <div class="modal fade" id="modal-aktivasi">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="konfirmasi" class="modal-title">Update Status Transaksi ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <div class="row">
                        <form action="/update/status/transaksi/nonaktif/{{ $studio->id }}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-secondary mr-2">Nonaktif</button>
                        </form>
                        <form action="/update/status/transaksi/aktif/{{ $studio->id }}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-success">Aktif</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
