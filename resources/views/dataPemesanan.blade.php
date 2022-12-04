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
                                <th>ID Transaksi</th>
                                <th>Nama</th>
                                <th>Studio</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemesanans as $pemesanan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pemesanan->invoice }}</td>
                                    <td>{{ $pemesanan->user->name }}</td>
                                    <td>{{ $pemesanan->studio->nama_studio }}</td>
                                    <td>{{ $pemesanan->tanggal }}</td>
                                    <td>Rp. {{ number_format($pemesanan->total_tarif, 0, ',', '.') }}</td>
                                    <td>
                                        <p style="color: red" id="p1{{ $pemesanan->id }}">{{ $pemesanan->status }}</p>
                                    </td>
                                    <script>
                                        if ("{{ $pemesanan->status }}" == 'Berhasil Dipesan') {
                                            document.getElementById("p1{{ $pemesanan->id }}").style.color = "green";
                                        } else if ("{{ $pemesanan->status }}" == 'Menunggu Konfirmasi') {
                                            document.getElementById("p1{{ $pemesanan->id }}").style.color = "blue";
                                        }
                                        //document.getElementById("p1{{ $pemesanan->status }}").innerHTML = "New text!";
                                    </script>
                                    <td>
                                        <p style="color: blue;font-weight:bold" id="timer{{ $pemesanan->id }}"></p>
                                    </td>
                                    <td>
                                        <button data-toggle="modal" data-target="#modal-cek{{ $pemesanan->id }}"
                                            type="button" class="btn btn-warning "> <i class="fa-solid fa-images"
                                                style="color: white;"></i> </button>
                                        {{-- <button data-toggle="modal" data-target="#modal-default{{ $pemesanan->id }}"
                                            type="button" class="btn btn-success "> <i class="fa-solid fa fa-check-circle"
                                                style="color: white;"></i> </button> --}}
                                        <button onclick="" data-toggle="modal"
                                            data-target="#modal-detail{{ $pemesanan->id }}" type="button"
                                            class="btn btn-primary "> <i class="fa-regular fa-eye"
                                                style="color: white;"></i> </button>
                                    </td>
                                </tr>
                                <script>
                                    // Set the date we're counting down to
                                    function timer{{ $pemesanan->id }}() {
                                        var date = new Date("{{ $pemesanan->dedline }}");
                                        var countDownDate = new Date(date.setMinutes(date.getMinutes() + 0));

                                        // Update the count down every 1 second
                                        var x = setInterval(function() {

                                            // Get today's date and time
                                            var now = new Date().getTime();

                                            // Find the distance between now and the count down date
                                            var distance = countDownDate - now;

                                            // Time calculations for days, hours, minutes and seconds
                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            // Output the result in an element with id="demo"
                                            document.getElementById("timer{{ $pemesanan->id }}").innerHTML = (minutes < 10 ? "0" + minutes :
                                                minutes) + ":" + (seconds <
                                                10 ? "0" + seconds : seconds);

                                            // If the count down is over, write some text
                                            var data = document.getElementById("p1{{ $pemesanan->id }}").innerHTML;
                                            if (distance < 0 && data != 'Berhasil Dipesan' && data != 'Menunggu Konfirmasi') {
                                                clearInterval(x);
                                                document.getElementById("timer{{ $pemesanan->id }}").innerHTML = "Time Out";
                                                document.getElementById("timer{{ $pemesanan->id }}").style.color = "black";
                                                document.getElementById("p1{{ $pemesanan->id }}").innerHTML = "Kadaluarsa";
                                                document.getElementById("p2{{ $pemesanan->id }}").innerHTML = "Kadaluarsa";

                                            } else if (distance < 0) {
                                                clearInterval(x);
                                                document.getElementById("timer{{ $pemesanan->id }}").innerHTML = "Time Out";
                                                document.getElementById("timer{{ $pemesanan->id }}").style.color = "black";
                                            }
                                        }, 1000);
                                    }
                                    window.onload = timer{{ $pemesanan->id }}();
                                </script>
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



    <!-- modal detail pemesanan -->
    @foreach ($pemesanans as $pemesanan)
        <!-- modal cek bukti pembayaran -->
        <div class="modal fade" id="modal-cek{{ $pemesanan->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Bukti Pembayaran</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($pemesanan->buktiPembayaran != null)
                            <img src="{{asset('storage/' . $pemesanan->buktiPembayaran->image)  }}"
                                class="img-fluid" style="width: 100%;">
                        @else
                            <p style="text-align: center">Belum upload bukti pembayaran !</p>
                        @endif

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <div>
                            <button data-dismiss="modal" data-toggle="modal" data-target="#modal-batal{{ $pemesanan->id }}"
                                type="button" class="btn btn-danger">Batalkan Pemesanan</button>
                            <button data-dismiss="modal" data-toggle="modal"
                                data-target="#modal-default{{ $pemesanan->id }}" type="button"
                                class="btn btn-success">Konfirmasi</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- modal konfirmasi pembayaran -->
        <div class="modal fade" id="modal-default{{ $pemesanan->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="konfirmasi" class="modal-title">Konfirmasi Pembayaran...?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <form action="/pemesanan/konfirmasi/{{ $pemesanan->id }}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-success">Konfirmasi</button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <!-- modal batalkan pembayaran -->
        <div class="modal fade" id="modal-batal{{ $pemesanan->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="konfirmasi" class="modal-title">Batalkan Pemesanan...?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <form
                            action="/pemesanan/batalkan/{{ $pemesanan->id }}"
                            method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-danger">Konfirmasi</button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



        <div class="modal fade" id="modal-detail{{ $pemesanan->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Pemesanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-bold" sstyle="color:grey ;">Identitas</h5>
                        <table>
                            <tr>
                                <td style="color:grey ;" class="col-6"><i class="far fa-regular fa-user mr-1"></i>Nama
                                </td>
                                <td style="color:grey ;" class="col-2"><i class="fa fa-phone mr-1"></i>
                                    Telepon</td>
                            </tr>
                            <tr>
                                <td class="col-6 text-bold">{{ $pemesanan->user->name }}</td>
                                <td class="col-2 text-bold"> {{ $pemesanan->user->nomor_hp }}</td>
                            </tr>
                        </table>
                        <hr>
                        <h4 class="text-bold">{{ $pemesanan->studio->nama_studio }}</h4>
                        <table>
                            <tr>
                                <td>
                                    <div style="position:relative ;">
                                        <i class="fa-2x fas fa-location" style="color: orangered;position:absolute;"></i>
                                        <p class="ml-5">{{ $pemesanan->studio->alamat }}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <table>
                            <tr>
                                <td class="col-6" style="color:grey ;"><i class=" fa-solid fa-credit-card mr-1"></i>ID
                                    Booking
                                </td>
                                <td class="col-4" style="color:grey ;"><i class="fa-solid fa-calendar-days"></i> Tanggal
                                </td>
                            </tr>
                            <tr>
                                <td class="col-6 text-bold" style="color: black;">{{ $pemesanan->invoice }}</td>
                                <td class="col-4 text-bold"> {{ $pemesanan->tanggal }}</td>
                            </tr>
                            <tr style="height: 20px;"></tr>
                            <tr>
                                <td class="col-6" style="color:grey ;"><i class="fa-solid fa-bars mr-1"></i>Sewa Ruang
                                </td>
                                <td class="col-4" style="color:grey ;"><i class="fa-solid fa-stopwatch"></i>
                                    Durasi</td>
                            </tr>

                            @for ($i = 0; $i < count(json_decode($pemesanan->fasilitas_dipesan)); $i++)
                                <tr>

                                    <td class="col-6 text-bold" style="color: black;">
                                        {{ json_decode($pemesanan->fasilitas_dipesan)[$i]->nama_fasilitas }}
                                    </td>
                                    <td class="col-4 text-bold">
                                        {{ json_decode($pemesanan->fasilitas_dipesan)[$i]->durasi }} Jam
                                        ({{ json_decode($pemesanan->fasilitas_dipesan)[$i]->jam_awal }}-{{ json_decode($pemesanan->fasilitas_dipesan)[$i]->jam_akhir }})
                                    </td>
                                </tr>
                            @endfor

                            <tr style="height: 20px;"></tr>
                            <tr>
                                <td class="col-6" style="color:grey ;"><i
                                        class="fa-solid fa-ticket-simple mr-1"></i>Status
                                </td>
                            </tr>

                            <tr>
                                <td id="p2{{ $pemesanan->id }}" class="col-6 text-bold" style="color:red ;">
                                    {{ $pemesanan->status }}
                                </td>
                                <script>
                                    if ("{{ $pemesanan->status }}" == 'Berhasil Dipesan') {
                                        document.getElementById("p2{{ $pemesanan->id }}").style.color = "green";
                                    }
                                    //document.getElementById("p1{{ $pemesanan->status }}").innerHTML = "New text!";
                                </script>
                            </tr>


                        </table>
                        <hr>
                        <div>
                            <div class="row">
                                <div class="col">
                                    <h5 class="text-bold">Rincian Biaya</h5>
                                </div>
                            </div>
                            @for ($i = 0; $i < count(json_decode($pemesanan->fasilitas_dipesan)); $i++)
                                <div class="row ">
                                    <div class="col">
                                        {{ json_decode($pemesanan->fasilitas_dipesan)[$i]->nama_fasilitas }}
                                    </div>
                                    <div class="mr-2 text-bold">
                                        Rp.
                                        {{ number_format(json_decode($pemesanan->fasilitas_dipesan)[$i]->total, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <hr style="margin-top: 5px ;">
                        <div class="row" style="margin-top: -10px ;">
                            <div class="row col">
                                <div class="col-1 mr-3 ">
                                    Total
                                </div>
                                <div style="color: grey;font-style:italic;">
                                    (Harga sudah termasuk PPN)
                                </div>
                            </div>
                            <div class="mr-2 text-bold">
                                Rp. {{ number_format($pemesanan->total_tarif, 0, ',', '.') }}
                            </div>
                        </div>
                        <div style="height: 20px;"></div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
    <!-- /.modal -->
@endsection
