  @extends('layouts.main')

  @section('container')
      <div class="row">
          <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                  <div class="inner">
                      <h3>{{ count(DB::table('pemesanans')->where('dedline', '>', date('Y-m-d H:i:s'))->where('status','Menunggu Pembayaran' )->get()) + count(DB::table('pemesanans')->where('status','Menunggu Konfirmasi' )->get()) }}
                      </h3>

                      <p>New Orders</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-bag"></i>
                  </div>
                  <a href="/dataPemesanan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                  <div class="inner">
                      <h3>{{ count(DB::table('transaksis')->where('biaya_admin','!=',0)->get()) }}</h3>

                      <p>Transaction Success</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="/dataTransaksi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                  <div class="inner">
                      <h3>{{ count(DB::table('users')->where('level', 'penyewa')->get()) +count(DB::table('users')->where('level', 'penyedia')->get()) }}
                      </h3>

                      <p>User Customer</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-person-add"></i>
                  </div>
                  <a href="/userPenyewa" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                  <div class="inner">
                      <h3>{{ count(DB::table('studios')->get()) }}</h3>

                      <p>Studios</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="/dataStudio" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
          <!-- ./col -->
      </div>
  @endsection
