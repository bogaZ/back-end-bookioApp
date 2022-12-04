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
                <h3 class="text-center mt-5">Laporan Witdhraw Penyedia Tempat</h3>
                <div class="row justify-content-center mb-5">
                    <p style="font-style: italic">{{ $tglawal }}</p>
                    <p class="ml-3 mr-3" style="font-weight: bold">s/d</p>
                    <p style="font-style: italic">{{ $tglakhir }}</p>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            {{-- <th scope="col">ID Transaksi</th> --}}
                            <th scope="col">Nama Penyedia</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nomer HP </th>
                            <th scope="col">Jumlah Withdraw</th>
                            {{-- <th scope="col">Status</th> --}}
                            <th scope="col">Tanggal</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($withdraws as $withdraw)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $withdraw->user->name }}</td>
                                <td>{{ $withdraw->user->email }}</td>
                                <td>{{ $withdraw->user->nomor_hp }}</td>
                                <td>Rp. {{ number_format($withdraw->jumlah,0,',','.') }}</td>
                                {{-- <td>{{ $withdraw->status }}</td> --}}
                                <td>{{ $withdraw->updated_at }}</td>
                                
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
                                    <p style="font-weight: bold" >Total Withdraw</p>                                </td>
                                <td >
                                    <p class="ml-2"> : </p>
                                </td>
                                <td>
                                    <p class="ml-2"> Rp. {{ number_format($withdraws->sum('jumlah'),0,',','.') }}</p>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="font-weight: bold" >Total Saldo Penyedia Tempat :</p>
                                </td>
                                <td> <p class="ml-2"> : </p> </td>
                                <td>
                                    <p class="ml-2"> Rp. {{ number_format($saldos->sum('jumlah') + $allWithdraw->where('status','Diproses')->sum('jumlah'),0,',','.') }}</p>

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
