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
                       
            
                            
                            <div class="col-6">
                                <div class="col">
                                    <div style="float: left" class="row mt">
                                        <p style="font-weight: bold;font-size: 20px" >Total Saldo Penyedia Tempat :</p>
                                        <p style="font-size: 20px;color:rgb(255, 94, 0)" class="ml-2"> Rp. {{ number_format($saldos->sum('jumlah') + $withdraws->where('status','Diproses')->sum('jumlah'),0,',','.') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        
                       
                        <div class="col">
                            <button data-toggle="modal" data-target="#modal-export-withdraw"
                                class="btn btn-success float-right mb-3"><i class="fa-solid fa-file-export mr-2"></i>Export
                                PDF</button>
                        </div>

                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nama Bank</th>
                                <th>Nomer Rekening</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdraws as $withdraw)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $withdraw->user->name }}</td>
                                    <td>{{ $withdraw->user->pembayaran->nama_bank }}</td>
                                    <td>{{ $withdraw->user->pembayaran->nomer_rekening }}</td>
                                    <td>{{ $withdraw->updated_at }}</td>
                                    <td>Rp. {{ number_format($withdraw->jumlah, 0, ',', '.') }}</td>
                                    <td style="color: {{ $withdraw->status == 'Diproses' ? 'red' : 'green' }} ;">
                                        {{ $withdraw->status }}</td>
                                    <td>

                                        <button id="myBtn" data-toggle="modal"
                                            data-target="#modal-konfirmasi-withdraw{{ $withdraw->id }}" type="button"
                                            class="btn btn-warning "> <i class="fa-solid fa-images"
                                                style="color: white;"></i> </button>
                                        <button data-toggle="modal" onclick="{{ $dataku = 1 }}"
                                            data-target="#modal-withdraw{{ $withdraw->id }}" type="button"
                                            class="btn btn-primary "> <i class="fa-regular fa-eye"
                                                style="color: white;"></i> </button>
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

        @foreach ($withdraws as $withdraw)
            <!-- modal konfirmasi withdraw -->
            <form action="/dataWithdraw/upload" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="modal fade" id="modal-konfirmasi-withdraw{{ $withdraw->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="konfirmasi" class="modal-title">
                                    @if (DB::table('bukti_transfers')->where('withdraw_id', $withdraw->id)->get() == '[]')
                                        Konfirmasi withdraw..?
                                    @else
                                        Bukti Transfer Withdraw
                                    @endif
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <img id="img-old{{ $withdraw->id }}"
                                    src="{{ DB::table('bukti_transfers')->where('withdraw_id', $withdraw->id)->get() != '[]'? asset('storage/' . $withdraw->bukti_transfer->image): '' }}"
                                    class="img-fluid" style="width: 100%;">

                                <img class="img-fluid" id="img-preview{{ $withdraw->id }}">
                                {{-- <p id="img-preview{{ $withdraw->id }}" >Coba</p> --}}

                                <p id="notice{{ $withdraw->id }}" style="text-align: center">
                                    @if (DB::table('bukti_transfers')->where('withdraw_id', $withdraw->id)->get() == '[]')
                                        Belum melakukan upload Bukti Transfer!
                                    @endif
                                </p>
                                <div class="input-group mt-4">
                                    {{-- {{ asset('storage/'.$withdraw->image) }} --}}
                                    <div class="custom-file">
                                        <input name="image" type="file"
                                            class="custom-file-input @error('image') is-invalid @enderror"
                                            id="image{{ $withdraw->id }}" onchange="previewImage{{ $withdraw->id }}()"
                                            required>
                                        <input style="visibility: true" type="number" name="withdraw_id"
                                            value="{{ $withdraw->id }}" id="">
                                        <label class="custom-file-label" for="exampleInputFile">Upload bukti
                                            transfer...</label>
                                    </div>
                                </div>
                                <script>
                                    function previewImage{{ $withdraw->id }}() {
                                        const image = document.querySelector('#image{{ $withdraw->id }}');
                                        const imgPreview = document.querySelector('#img-preview{{ $withdraw->id }}');
                                        const imgOld = document.querySelector('#img-old{{ $withdraw->id }}');
                                        const notice = document.querySelector('#notice{{ $withdraw->id }}');

                                        imgPreview.style.display = 'block';
                                        imgOld.style.display = 'none';
                                        notice.style.display = 'none';

                                        const oFReader = new FileReader();
                                        oFReader.readAsDataURL(image.files[0]);

                                        oFReader.onload = function(oFREvent) {
                                            imgPreview.src = oFREvent.target.result;
                                        }
                                    }
                                </script>


                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="modal-footer justify-content-between">

                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">
                                    @if (DB::table('bukti_transfers')->where('withdraw_id', $withdraw->id)->get()->first() == null)
                                        {{ 'Lunas' }}
                                    @else
                                        {{ 'Lunas' }}
                                    @endif
                                </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </form>
            <!-- modal detail withdraw -->
            <div class="modal fade" id="modal-withdraw{{ $withdraw->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="konfirmasi" class="modal-title">Detail Withdraw</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <p>Total Penarikan Saldo</p>
                                        <p id="nama"></p>
                                    </div>
                                </div>
                                <h4 style="color: orangered ;">Rp. {{ number_format($withdraw->jumlah, 0, ',', '.') }}</h4>
                                <div class="row col">
                                    <div>
                                        <p>Status : </p>
                                    </div>
                                    <div class="ml-2"
                                        style="color:{{ $withdraw->status == 'Diproses' ? 'red' : 'green' }} ;">
                                        <p>{{ $withdraw->status }}</p>
                                    </div>
                                </div>
                                <hr class="mt-1">
                                <div class="row col">
                                    <table>
                                        <tr>
                                            <td class="pr-3" rowspan="3"><i class="fa-solid fa-building-columns fa-lg"
                                                    style="color:orangered ;"></i></td>
                                            <td class="text-bold">No. Rekening</td>
                                            <td>:</td>
                                            <td>{{ $withdraw->user->pembayaran->nomer_rekening }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold">Nama Bank</td>
                                            <td>:</td>
                                            <td>{{ $withdraw->user->pembayaran->nama_bank }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold">Nama Pemilik</td>
                                            <td>:</td>
                                            <td>{{ $withdraw->user->pembayaran->nama_pemilik }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="container p-4" style="background-color: rgb(216, 216, 216);width:100%;">
                            <div class="row col">
                                <p class="text-bold" style="color: rgb(87, 86, 86) ;">Note :</p>
                            </div>
                            <div class="row col">
                                <p style="color: rgb(87, 86, 86) ;" class="text-justify">Segera lakukan transfer
                                    ke nomer rekering yang tersedia sesuai dengan nominal yang diberikan dan ulpload
                                    bukti transfer pada aplikasi</p>
                            </div>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        @endforeach
        {{-- <script>
            $(document).ready(function() {
                $(document).on('click', '#datanya', function() {
                    var nama = $(this).data('nama');
                    $('#nama').text(nama);
                })
            })
        </script> --}}
    @endsection
