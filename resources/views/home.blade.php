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
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6>Data Antrian</h6>
                        </div>
                        <div class="card-body">
                            <table id="tabel_antrian" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center text-indigo">Nama Cabang</th>
                                        <th class="text-center text-indigo">Pengunjung Hari Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cabangs as $key => $item)
                                        @if (count($item->antrianPengunjung) > 0)
                                            <tr>
                                                <td><a href="{{ route('home.antrian', [$item->id]) }}">{{ $item->nama_cabang }}</a></td>
                                                <td class="text-center">
                                                    {{ count($item->antrianSementara) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
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

    })
</script>

@endsection
