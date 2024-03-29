@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Antrian</h1>
        </div>
        <div class="col-sm-6">
          <div class="breadcrumb float-sm-right">
            <a href="{{ route('home') }}" class="btn btn-danger"><i class="fas fa-home"></i> Kembali ke Dashboard</a>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <form action="#" method="post">
                @csrf
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="row">
                      <div class="col-3">
                        <span for="cabang_id">Cabang</span>
                        <select name="cabang_id" id="cabang_id" class="form-control form-control-sm">
                          <option value="">--Pilih Cabang--</option>
                          @foreach ($cabang_antrians as $item_cabang_antrian)
                            @foreach ($cabangs as $item_cabang)
                              @if ($item_cabang->id == $item_cabang_antrian->master_cabang)
                                <option value="{{ $item_cabang->id }}">{{ $item_cabang->nama_cabang }}</option>
                              @endif
                            @endforeach          
                          @endforeach
                        </select>
                      </div>
                      <div class="col-3">
                        <span for="start_date">Start Date</span>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ date('Y-m-') }}01" required>
                      </div>
                      <div class="col-3">
                        <span for="end_date">End Date</span>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                      </div>
                      <div class="col-3">
                        <span for="">Aksi</span>
                        <button type="button" class="btn btn-primary btn-sm btn-block tombol-cari"><i class="fas fa-search"></i> Cari</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="height: 200px; width: 100%;">
                  <div class="overlay-wrapper d-none">
                    <div class="overlay bg-light"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2"></div></div>
                  </div>
                  <table id="tabel_cabang_antrian" style="width: 100%;">
                    <tr>
                      <td><div style="width: 100%;" class="border border-secondary bg-secondary px-2 py-1 mb-2 text-center">Cabang</div></td>
                    </tr>
                    @foreach ($cabang_antrians as $item_cabang_antrian)
                      <tr>
                        <td>
                          <div style="width: 100%;" class="border border-primary px-2 py-1 text-center">
                            @foreach ($cabangs as $item_cabang)
                              @if ($item_cabang->id == $item_cabang_antrian->master_cabang)
                                {{ $item_cabang->nama_cabang }} {{--  - {{ $item_cabang_antrian->master_cabang }} --}}
                                <span class="float-right font-weight-bold">
                                  <u>
                                    @if ($item_cabang->id == 2)
                                      {{ $jumlah_total_situmpur }}
                                    @endif
                                    @if ($item_cabang->id == 3)
                                      {{ $jumlah_total_dkw }}                                    
                                    @endif
                                    @if ($item_cabang->id == 4)
                                      {{ $jumlah_total_hr }}                                    
                                    @endif
                                    @if ($item_cabang->id == 5)
                                      {{ $jumlah_total_pbg }}                                    
                                    @endif
                                    @if ($item_cabang->id == 6)
                                      {{ $jumlah_total_cilacap }}                                    
                                    @endif
                                    @if ($item_cabang->id == 11)
                                      {{ $jumlah_total_bumiayu }}                                    
                                    @endif
                                  </u>
                                </span>
                              @endif
                            @endforeach
                          </div>
                        </td>
                      </tr>                        
                    @endforeach
                    <tr>
                      <td>
                        <div style="width: 100%;" class="border border-primary px-2 py-1 text-center bg-info">
                          <b>Total</b>
                          <span class="float-right font-weight-bold">
                            <u>{{ $grand_total }}</u>
                          </span>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-8 col-6 overflow-auto">
                  <div class="overlay-wrapper d-none">
                    <div class="overlay bg-light"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2"></div></div>
                  </div>
                  <table id="tabel_total_antrian">
                    <tr>
                      <td></td>
                      @foreach ($total_tanggal as $item_date)
                        <td>
                          <div style="width: 100px;" class="border border-secondary bg-secondary px-2 py-1 mb-2 text-center">
                            @if ($item_date < 10)
                              0{{ $item_date }}
                            @else
                              {{ $item_date }}
                            @endif
                              / {{ $bulan }}
                          </div>
                        </td>                          
                      @endforeach
                    </tr>
                    @foreach ($cabang_antrians as $item_cabang_antrian)
                      <tr>
                        <td style="visibility: hidden;">
                          <div style="width: 1px;" class="border border-secondary py-1 text-center">
                            -
                          </div>
                        </td>

                        {{-- situmpur --}}
                        @if ($item_cabang_antrian->master_cabang == 2)
                          @foreach ($total_situmpur as $item_total_situmpur)
                            <td>
                              <div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">
                                {{ $item_total_situmpur }}
                              </div>
                            </td>                              
                          @endforeach
                        @endif

                        {{-- dkw --}}
                        @if ($item_cabang_antrian->master_cabang == 3)
                          @foreach ($total_dkw as $item_total_dkw)
                            <td>
                              <div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">
                                {{ $item_total_dkw }}
                              </div>
                            </td>                              
                          @endforeach
                        @endif

                        {{-- hr --}}
                        @if ($item_cabang_antrian->master_cabang == 4)
                          @foreach ($total_hr as $item_total_hr)
                            <td>
                              <div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">
                                {{ $item_total_hr }}
                              </div>
                            </td>                              
                          @endforeach
                        @endif

                        {{-- pbg --}}
                        @if ($item_cabang_antrian->master_cabang == 5)
                          @foreach ($total_pbg as $item_total_pbg)
                            <td>
                              <div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">
                                {{ $item_total_pbg }}
                              </div>
                            </td>                              
                          @endforeach
                        @endif

                        {{-- cilacap --}}
                        @if ($item_cabang_antrian->master_cabang == 6)
                          @foreach ($total_cilacap as $item_total_cilacap)
                            <td>
                              <div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">
                                {{ $item_total_cilacap }}
                              </div>
                            </td>                              
                          @endforeach
                        @endif

                        {{-- bumiayu --}}
                        @if ($item_cabang_antrian->master_cabang == 11)
                          @foreach ($total_bumiayu as $item_total_bumiayu)
                            <td>
                              <div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">
                                {{ $item_total_bumiayu }}
                              </div>
                            </td>                              
                          @endforeach
                        @endif
                      </tr>                        
                    @endforeach
                    <tr>
                      <td></td>
                      @foreach ($total as $item_total)
                        <td>
                          <div style="width: 100px;" class="border border-secondary px-2 py-1 text-center bg-info">
                            <b>{{ $item_total }}</b>
                          </div>
                        </td>                              
                      @endforeach
                    </tr>
                  </table>
                </div>
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
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      let cabang_id = $('#cabang_id').val();

      $("#tabel_customer").DataTable({
          'ordering': false
      });

      $("#tabel_customer_terakhir").DataTable({
          'ordering': false
      });

      $('.tombol-cari').on('click', function () {
        let cabang_id = $('#cabang_id').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        $('#tabel_total_antrian').empty();     
        $('#tabel_cabang_antrian').empty();        

        let formData = {
          cabang_id: cabang_id,
          start_date: start_date,
          end_date: end_date
        }

        $.ajax({
          url: "{{ URL::route('antrian.cari') }}",
          type: 'post',
          data: formData,
          beforeSend: function () {
            $('.overlay-wrapper').removeClass('d-none');
          },
          success: function (response) {
            let data_cabang = '' +
              '<tr>' +
                '<td><div style="width: 100%;" class="border border-secondary bg-secondary px-2 py-1 mb-2 text-center">Cabang</div></td>' +
              '</tr>';
              $.each(response.cabangs, function (index, item) {
                if (response.cabang_id == null) {
                  $.each(response.cabang_antrians, function (index_cabang_antrian, item_cabang_antrian) {
                    if (item_cabang_antrian.master_cabang == item.id) {
                      data_cabang += '<tr>' +
                          '<td>' +
                            '<div style="width: 100%;" class="border border-primary px-2 py-1 text-center">' + item.nama_cabang + 
                              '<span class="float-right font-weight-bold">' +
                                  '<u>';
                                    if (item.id == 2) {
                                      data_cabang += response.jumlah_total_situmpur;
                                    }
                                    if (item.id == 3) {
                                      data_cabang += response.jumlah_total_dkw;
                                    }
                                    if (item.id == 4) {
                                      data_cabang += response.jumlah_total_hr;
                                    }
                                    if (item.id == 5) {
                                      data_cabang += response.jumlah_total_pbg;
                                    }
                                    if (item.id == 6) {
                                      data_cabang += response.jumlah_total_cilacap;
                                    }
                                    if (item.id == 11) {
                                      data_cabang += response.jumlah_total_bumiayu;
                                    }
                                  data_cabang += '</u>' +
                                '</span>' +
                            '</div>' +
                          '</td>' +
                        '</tr>';                      
                    }
                  })
                } else {
                  if (item.id == response.cabang_id) {
                    data_cabang += '<tr>' +
                      '<td>' +
                        '<div style="width: 100%;" class="border border-primary px-2 py-1 text-center">' + item.nama_cabang + 
                          '<span class="float-right font-weight-bold">' +
                            '<u>';
                              if (response.cabang_id == 2) {
                                data_cabang += response.jumlah_total_situmpur;
                              }
                              if (response.cabang_id == 3) {
                                data_cabang += response.jumlah_total_dkw;
                              }
                              if (response.cabang_id == 4) {
                                data_cabang += response.jumlah_total_hr;
                              }
                              if (response.cabang_id == 5) {
                                data_cabang += response.jumlah_total_pbg;
                              }
                              if (response.cabang_id == 6) {
                                data_cabang += response.jumlah_total_cilacap;
                              }
                              if (response.cabang_id == 11) {
                                data_cabang += response.jumlah_total_bumiayu;
                              }
                            data_cabang += '</u>' +
                          '</span>' + 
                        '</div>' +
                      '</td>' +
                    '</tr>';
                  }
                }
              })

              if (response.cabang_id == null) {
                data_cabang += '' +
                  '<tr>' +
                    '<td>' +
                      '<div style="width: 100%;" class="border border-primary px-2 py-1 text-center bg-info">' +
                        '<b>Total</b>' +
                        '<span class="float-right font-weight-bold">' +
                          '<u>' + response.grand_total + '</u>' +
                        '</span>' +
                      '</div>' +
                    '</td>' +
                  '</tr>';
              }
            $('#tabel_cabang_antrian').append(data_cabang);

            let data = '' +
                '<tr>';
                  
                  $.each(response.total_tanggal, function (index, item) {
                    data += '<td>' +
                      '<div style="width: 100px;" class="border border-secondary bg-secondary px-2 py-1 mb-2 text-center">' +
                        item
                      '</div>' +
                    '</td>';
                  })
                data += '</tr>';

                $.each(response.cabang_antrians, function (index, item_cabang_antrian) {
                  data += '<tr>';

                    // situmpur
                    if (item_cabang_antrian.master_cabang == 2) {
                      $.each(response.total_situmpur, function (index, item_total_situmpur) {
                        data += '<td>' +
                          '<div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">' +
                            item_total_situmpur
                          '</div>' +
                        '</td>';
                      })
                    }

                    // dkw
                    else if (item_cabang_antrian.master_cabang == 3) {
                      $.each(response.total_dkw, function (index, item_total_dkw) {
                        data += '<td>' +
                          '<div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">' +
                            item_total_dkw
                          '</div>' +
                        '</td>';
                      })
                    }

                    // hr
                    else if (item_cabang_antrian.master_cabang == 4) {
                      $.each(response.total_hr, function (index, item_total_hr) {
                        data += '<td>' +
                          '<div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">' +
                            item_total_hr
                          '</div>' +
                        '</td>';
                      })
                    }

                    // pbg
                    else if (item_cabang_antrian.master_cabang == 5) {
                      $.each(response.total_pbg, function (index, item_total_pbg) {
                        data += '<td>' +
                          '<div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">' +
                            item_total_pbg
                          '</div>' +
                        '</td>';
                      })
                    }

                    // cilacap
                    else if (item_cabang_antrian.master_cabang == 6) {
                      $.each(response.total_cilacap, function (index, item_total_cilacap) {
                        data += '<td>' +
                          '<div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">' +
                            item_total_cilacap
                          '</div>' +
                        '</td>';
                      })
                    }

                    // bumiayu
                    else if (item_cabang_antrian.master_cabang == 11) {
                      $.each(response.total_bumiayu, function (index, item_total_bumiayu) {
                        data += '<td>' +
                          '<div style="width: 100px;" class="border border-secondary px-2 py-1 text-center">' +
                            item_total_bumiayu
                          '</div>' +
                        '</td>';
                      })
                    }
                    
                    else {
                      
                    }
                })
                data += '</tr>';

                if (response.cabang_id == null) {
                  data += '' +
                    '<tr>';
                      $.each(response.total, function (index, item) {
                        data += '<td>' +
                          '<div style="width: 100px;" class="border border-secondary px-2 py-1 text-center bg-info">' +
                            '<b>' + item + '</b>' +
                          '</div>' +
                        '</td>';
                      })
                  data += '</tr>';
                }

            $('#tabel_total_antrian').append(data);
            $('.overlay-wrapper').addClass('d-none');
          }
        })
      })
    })
</script>

@endsection

