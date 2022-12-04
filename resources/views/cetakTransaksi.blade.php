<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div>
        <div class="row">
            <div class="col">
                <h3 class="text-center mt-5">Laporan Transaksi Penyewaan</h3>
                <div class="row justify-content-center mb-5">
                    <p style="font-style: italic">{{ $tglawal }}</p>
                    <p class="ml-3 mr-3" style="font-weight: bold">s/d</p>
                    <p style="font-style: italic">{{ $tglakhir }}</p>
                </div>
                <table class="table table-striped table-bordered" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID Transaksi</th>
                            <th scope="col">Penyewa</th>
                            <th scope="col">Studio</th>
                            <th scope="col">Pemilik</th>
                            <th scope="col">Pembayaran</th>
                            <th scope="col">-5%</th>
                            <th scope="col">Total</th>
                            <th scope="col">Tanggal</th>
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
                                <td>Rp. {{ number_format($transaksi->total - $transaksi->biaya_admin, 0, ',', '.') }}
                                </td>
                                <td>{{ $transaksi->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-12">
                <div class="col-12">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <p style="font-weight: bold">Total Pembayaran</p>
                                </td>
                                <td>
                                    <p class="ml-2"> : </p>
                                </td>
                                <td>
                                    <p class="ml-2 float-right"> Rp.
                                        {{ number_format($transaksis->sum('total'), 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="ml-2" style="width: 10px" rowspan="4"><p> </p></td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="font-weight: bold">Total Pemasukan dari 5% Biaya Admin</p>
                                </td>
                                <td>
                                    <p class="ml-2"> : </p>
                                </td>
                                <td>
                                    <p class="ml-2 float-right"> Rp.
                                        {{ number_format($transaksis->sum('biaya_admin'), 0, ',', '.') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="border-top: 1px solid black">

                                </td>
                                <td >
                                    <p>
                                        
                                    </p>
                                </td>
                                <td style="border-top: 3px solid black;width:15px">
                                    <p>
                                        
                                    </p>
                                </td>
                            </tr>
                            <tr >
                                <td>
                                    <p style="font-weight: bold">Total Pemasukan Penyedia Tempat</p>
                                </td>
                                <td>
                                    <p class="ml-2"> : </p>
                                </td>
                                <td>
                                    <p class="ml-2 float-right"> Rp.
                                        {{ number_format($transaksis->sum('total') - $transaksis->sum('biaya_admin'), 0, ',', '.') }}
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
