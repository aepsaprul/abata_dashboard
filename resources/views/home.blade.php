@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- data antrian -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card mt-4">
                        <div class="card-header">
                          <div class="d-flex justify-content-between">
                            <div>
                              <span class="font-weight-bold">Data Antrian</span>
                            </div>
                            <div>
                              <form action="#" method="post">
                                @csrf
                                <div class="row">
                                  <div class="col-3">
                                    <span for="activity_plan_cabang_id">Cabang</span>
                                    <select name="activity_plan_cabang_id" id="activity_plan_cabang_id" class="form-control form-control-sm">
                                      <option value="">--Pilih Cabang--</option>
                                      @foreach ($cabangs as $item)
                                          <option value="{{ $item->id }}">{{ $item->nama_cabang }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="col-3">
                                    <span for="activity_plan_start_date">Start Date</span>
                                    <input type="date" name="activity_plan_start_date" id="activity_plan_start_date" class="form-control form-control-sm" value="{{ date('Y-m-') }}01" required>
                                  </div>
                                  <div class="col-3">
                                    <span for="activity_plan_end_date">End Date</span>
                                    <input type="date" name="activity_plan_end_date" id="activity_plan_end_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                                  </div>
                                  <div class="col-3">
                                    <span for="">Aksi</span>
                                    <button type="submit" class="btn btn-success btn-sm btn-block">Excel</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="antrianChart" width="1000" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- data espk -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card mt-4">
                        <div class="card-header">
                          <div class="d-flex justify-content-between">
                            <div>
                              <span class="font-weight-bold">Data Pesanan ESPK</span>
                            </div>
                            <div>
                              <form action="#" method="post">
                                @csrf
                                <div class="row">
                                  <div class="col-3">
                                    <span for="activity_plan_cabang_id">Cabang</span>
                                    <select name="activity_plan_cabang_id" id="activity_plan_cabang_id" class="form-control form-control-sm">
                                      <option value="">--Pilih Cabang--</option>
                                      @foreach ($cabangs as $item)
                                          <option value="{{ $item->id }}">{{ $item->nama_cabang }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="col-3">
                                    <span for="activity_plan_start_date">Start Date</span>
                                    <input type="date" name="activity_plan_start_date" id="activity_plan_start_date" class="form-control form-control-sm" value="{{ date('Y-m-') }}01" required>
                                  </div>
                                  <div class="col-3">
                                    <span for="activity_plan_end_date">End Date</span>
                                    <input type="date" name="activity_plan_end_date" id="activity_plan_end_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                                  </div>
                                  <div class="col-3">
                                    <span for="">Aksi</span>
                                    <button type="submit" class="btn btn-success btn-sm btn-block">Excel</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="espkCart" width="1000" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{ asset('themes/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('themes/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('themes/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('themes/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('themes/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>

<script>
    $(document).ready(function () {
        pengunjung();
        function pengunjung() {
            $.ajax({
                url: "{{ URL::route('antrian.grafik') }}",
                type: 'get',
                success: function (response) {
                    const ctx = document.getElementById('antrianChart').getContext('2d');
                    let data_labels = response.tanggal;
                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data_labels,
                            datasets: [
                                {
                                    label: 'Situmpur',
                                    data: response.total_pengunjung_situmpur,
                                    backgroundColor: [
                                        '#cc0000'
                                    ],
                                    borderColor: [
                                        '#cc0000'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Dukuh Waluh',
                                    data: response.total_pengunjung_dkw,
                                    backgroundColor: [
                                        '#30845e'
                                    ],
                                    borderColor: [
                                        '#30845e'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'HR Bunyamin',
                                    data: response.total_pengunjung_hr,
                                    backgroundColor: [
                                        '#ffe800'
                                    ],
                                    borderColor: [
                                        '#ffe800'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Purbalingga',
                                    data: response.total_pengunjung_pbg,
                                    backgroundColor: [
                                        '#123abc'
                                    ],
                                    borderColor: [
                                        '#123abc'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Cilacap',
                                    data: response.total_pengunjung_cilacap,
                                    backgroundColor: [
                                        '#ff3e99'
                                    ],
                                    borderColor: [
                                        '#ff3e99'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Bumiayu',
                                    data: response.total_pengunjung_bumiayu,
                                    backgroundColor: [
                                        '#637999'
                                    ],
                                    borderColor: [
                                        '#637999'
                                    ],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            })
        }

        espk();
        function espk() {
            $.ajax({
                url: "{{ URL::route('espk.grafik') }}",
                type: 'get',
                success: function (response) {
                    console.log(response);
                    const ctx = document.getElementById('espkCart').getContext('2d');
                    let data_labels = response.tanggal;
                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data_labels,
                            datasets: [
                                {
                                    label: 'Situmpur',
                                    data: response.total_pesanan_situmpur,
                                    backgroundColor: [
                                        '#cc0000'
                                    ],
                                    borderColor: [
                                        '#cc0000'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Dukuh Waluh',
                                    data: response.total_pesanan_dkw,
                                    backgroundColor: [
                                        '#30845e'
                                    ],
                                    borderColor: [
                                        '#30845e'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'HR Bunyamin',
                                    data: response.total_pesanan_hr,
                                    backgroundColor: [
                                        '#ffe800'
                                    ],
                                    borderColor: [
                                        '#ffe800'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Purbalingga',
                                    data: response.total_pesanan_pbg,
                                    backgroundColor: [
                                        '#123abc'
                                    ],
                                    borderColor: [
                                        '#123abc'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Cilacap',
                                    data: response.total_pesanan_cilacap,
                                    backgroundColor: [
                                        '#ff3e99'
                                    ],
                                    borderColor: [
                                        '#ff3e99'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Bumiayu',
                                    data: response.total_pesanan_bumiayu,
                                    backgroundColor: [
                                        '#637999'
                                    ],
                                    borderColor: [
                                        '#637999'
                                    ],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            })
        }
    })
</script>

@endsection
