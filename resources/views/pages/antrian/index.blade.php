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
                <div class="col-12 text-right mt-4">
                    <a href="{{ route('home') }}" class="btn btn-danger"><i class="fas fa-home"></i> Kembali ke Dashboard</a>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="cabang_id" id="cabang_id" value="{{ $cabang_id }}">
                <!-- pengunjung terbanyak -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card card-info mt-4">
                        <div class="card-header">
                            <h6>Data Pengunjung Terbanyak</h6>
                        </div>
                        <div class="card-body">
                            <table id="tabel_customer" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center text-indigo">No</th>
                                        <th class="text-center text-indigo">Nama</th>
                                        <th class="text-center text-indigo">Telepon</th>
                                        <th class="text-center text-indigo">Total Kunjungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->nama_customer }}</td>
                                            <td class="text-center">{{ $item->telepon }}</td>
                                            <td class="text-center">{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 100 pengunjung terakhir -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card card-info mt-4">
                        <div class="card-header">
                            <h6>Data Pengunjung Terakhir</h6>
                        </div>
                        <div class="card-body">
                            <table id="tabel_customer_terakhir" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center text-indigo">No</th>
                                        <th class="text-center text-indigo">Nama</th>
                                        <th class="text-center text-indigo">Telepon</th>
                                        <th class="text-center text-indigo">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer_terakhirs as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->nama_customer }}</td>
                                            <td class="text-center">{{ $item->telepon }}</td>
                                            <td class="text-center">{{ $item->updated_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h6>Total Pengunjung Per Hari</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h6>Total Pengunjung Per Shift</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="chart_shif" width="400" height="200"></canvas>
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
        let cabang_id = $('#cabang_id').val();

        $("#tabel_customer").DataTable({
            'ordering': false
        });
        $("#tabel_customer_terakhir").DataTable({
            'ordering': false
        });

        pengunjung();
        function pengunjung() {
            var id = cabang_id;
            var url = '{{ route("home.antrian.pengunjung", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                success: function (response) {
                    const ctx = document.getElementById('myChart').getContext('2d');
                    let data_labels = response.tanggal_pengunjung;
                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data_labels,
                            datasets: [{
                                label: 'Data Pengunjung',
                                data: response.total_pengunjung,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 1
                            }]
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

        pengunjungShift();
        function pengunjungShift() {
            var id = cabang_id;
            var url = '{{ route("home.antrian.pengunjung", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                success: function (response) {
                    const ctx = document.getElementById('chart_shif').getContext('2d');
                    let data_labels = response.tanggal_customer_shift_1;
                    const myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data_labels,
                            datasets: [{
                                    label: 'Pengunjung Shift 1',
                                    data: response.pengunjung_shift_1,
                                    backgroundColor: [
                                        '#0d9170'
                                    ],
                                    borderColor: [
                                        '#0d9170'
                                    ],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Pengunjung Shift 2',
                                    data: response.pengunjung_shift_2,
                                    backgroundColor: [
                                        '#ff80dd'
                                    ],
                                    borderColor: [
                                        '#ff80dd'
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

