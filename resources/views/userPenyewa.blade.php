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
                                       <th>Email</th>
                                       <th>Nama</th>
                                       <th>Nomer Hp</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($users as $user)
                                       <tr>
                                        <td>{{ $loop->iteration }}</td>
                                           <td>{{ $user->email }}</td>
                                           <td>{{ $user->name }}</td>
                                           <td>{{ $user->nomor_hp }}</td>
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
