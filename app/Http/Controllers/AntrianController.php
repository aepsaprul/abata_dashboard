<?php

namespace App\Http\Controllers;

use App\Exports\AntrianExport;
use App\Models\AntrianPengunjung;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AntrianController extends Controller
{
  public function __construct()
  {
    // cabang
    $this->cabang = Cabang::get();

    // cabang antrian
    $this->cabang_antrian = AntrianPengunjung::select(DB::raw('master_cabang_id AS master_cabang'))
      ->whereNotNull('master_cabang_id')
      ->groupBy('master_cabang')
      ->get();
  }

  public function index()
  {
    // array tanggal
    function days_in_month($month, $year){
      // calculate number of days in a month
      return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    } 

    // $kalender = CAL_GREGORIAN;
    $bulan = date('m');
    $tahun = date('Y');
    $jumlah_hari = days_in_month($bulan, $tahun);

    $total_tanggal = [];
    for ($i=1; $i <= $jumlah_hari ; $i++) {
      $total_tanggal[] = $i;
    }

    // antrian    
    $bulan_sekarang = date("Y-m");
    $tanggal_sekarang = date("d");

    $tanggal_pengunjung = [];
    for ($i=1; $i <= $tanggal_sekarang ; $i++) {
      $tanggal_pengunjung[] = $i;
    }

    // situmpur
    $pengunjung_situmpur = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 2)
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_situmpur = [];
    foreach ($pengunjung_situmpur as $key => $value) {
      $tanggal_pengunjung_situmpur[] = $value->tanggal_pengunjung;
    }

    // dkw
    $pengunjung_dkw = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 3)
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_dkw = [];
    foreach ($pengunjung_dkw as $key => $value) {
      $tanggal_pengunjung_dkw[] = $value->tanggal_pengunjung;
    }

    // hr
    $pengunjung_hr = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 4)
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_hr = [];
    foreach ($pengunjung_hr as $key => $value) {
      $tanggal_pengunjung_hr[] = $value->tanggal_pengunjung;
    }

    // pbg
    $pengunjung_pbg = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 5)
      ->where('jabatan', 'desain')
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_pbg = [];
    foreach ($pengunjung_pbg as $key => $value) {
      $tanggal_pengunjung_pbg[] = $value->tanggal_pengunjung;
    }

    // cilacap
    $pengunjung_cilacap = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 6)
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_cilacap = [];
    foreach ($pengunjung_cilacap as $key => $value) {
      $tanggal_pengunjung_cilacap[] = $value->tanggal_pengunjung;
    }

    // bumiayu
    $pengunjung_bumiayu = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 11)
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_bumiayu = [];
    foreach ($pengunjung_bumiayu as $key => $value) {
      $tanggal_pengunjung_bumiayu[] = $value->tanggal_pengunjung;
    }

    // total
    $pengunjung_total = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_total = [];
    foreach ($pengunjung_total as $key => $value) {
      $tanggal_pengunjung_total[] = $value->tanggal_pengunjung;
    }

    $situmpur = [];
    $dkw = [];
    $hr = [];
    $pbg = [];
    $cilacap = [];
    $bumiayu = [];
    $total = [];
    foreach ($tanggal_pengunjung as $key => $value) {
      // data situmpur
      if (in_array($value, $tanggal_pengunjung_situmpur)) {
        foreach ($pengunjung_situmpur as $key => $value_situmpur) {
          if ($value_situmpur->tanggal_pengunjung == $value) {
            $situmpur[] = $value_situmpur->total_pengunjung;
          }
        }
      } else {
        $situmpur[] = 0;
      }

      // data dkw
      if (in_array($value, $tanggal_pengunjung_dkw)) {
        foreach ($pengunjung_dkw as $key => $value_dkw) {
          if ($value_dkw->tanggal_pengunjung == $value) {
            $dkw[] = $value_dkw->total_pengunjung;
          }
        }
      } else {
        $dkw[] = 0;
      }

      // data hr
      if (in_array($value, $tanggal_pengunjung_hr)) {
        foreach ($pengunjung_hr as $key => $value_hr) {
          if ($value_hr->tanggal_pengunjung == $value) {
            $hr[] = $value_hr->total_pengunjung;
          }
        }
      } else {
          $hr[] = 0;
      }

      // data pbg
      if (in_array($value, $tanggal_pengunjung_pbg)) {
        foreach ($pengunjung_pbg as $key => $value_pbg) {
          if ($value_pbg->tanggal_pengunjung == $value) {
            $pbg[] = $value_pbg->total_pengunjung;
          }
        }
      } else {
        $pbg[] = 0;
      }

      // data bumiayu
      if (in_array($value, $tanggal_pengunjung_bumiayu)) {
        foreach ($pengunjung_bumiayu as $key => $value_bumiayu) {
          if ($value_bumiayu->tanggal_pengunjung == $value) {
            $bumiayu[] = $value_bumiayu->total_pengunjung;
          }
        }
      } else {
        $bumiayu[] = 0;
      }

      // data cilacap
      if (in_array($value, $tanggal_pengunjung_cilacap)) {
        foreach ($pengunjung_cilacap as $key => $value_cilacap) {
          if ($value_cilacap->tanggal_pengunjung == $value) {
            $cilacap[] = $value_cilacap->total_pengunjung;
          }
        }
      } else {
        $cilacap[] = 0;
      }

      // data total
      if (in_array($value, $tanggal_pengunjung_total)) {
        foreach ($pengunjung_total as $key => $value_total) {
          if ($value_total->tanggal_pengunjung == $value) {
            $total[] = $value_total->total_pengunjung;
          }
        }
      } else {
        $total[] = 0;
      }
    }
    // dd($total);
    return view('pages.antrian.index', [
      'bulan' => $bulan,
      'total_tanggal' => $total_tanggal,
      'cabang_antrians' => $this->cabang_antrian,
      'cabangs' => $this->cabang,
      'total_situmpur' => $situmpur,
      'jumlah_total_situmpur' => array_sum($situmpur),
      'total_dkw' => $dkw,
      'jumlah_total_dkw' => array_sum($dkw),
      'total_hr' => $hr,
      'jumlah_total_hr' => array_sum($hr),
      'total_pbg' => $pbg,
      'jumlah_total_pbg' => array_sum($pbg),
      'total_cilacap' => $cilacap,
      'jumlah_total_cilacap' => array_sum($cilacap),
      'total_bumiayu' => $bumiayu,
      'jumlah_total_bumiayu' => array_sum($bumiayu),
      'total' => $total,
      'grand_total' => array_sum($situmpur) + array_sum($dkw) + array_sum($hr) + array_sum($pbg) + array_sum($cilacap) + array_sum($bumiayu)
    ]);
  }

  public function cari(Request $request)
  {
    $cabang_id = $request->cabang_id;
    $start_date = $request->start_date;
    $end_date = $request->end_date;
   
    $start_date_ = strtotime($start_date); 
    $end_date_ = strtotime($end_date);
  
    $total_tanggal = [];
    for ($i = $start_date_; $i <= $end_date_; $i += 86400) {  
      $total_tanggal[] = date("d/m", $i);  
    }

    // antrian
    $tanggal_pengunjung = [];
    for ($i = $start_date_; $i <= $end_date_ ; $i += 86400) {
      $tanggal_pengunjung[] = date("Y-m-d", $i);
    }

    // situmpur
    $pengunjung_situmpur = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DATE(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 2)
      ->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:00'])
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_situmpur = [];
    foreach ($pengunjung_situmpur as $key => $value) {
      $tanggal_pengunjung_situmpur[] = $value->tanggal_pengunjung;
    }

    // dkw
    $pengunjung_dkw = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DATE(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 3)
      ->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:00'])
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_dkw = [];
    foreach ($pengunjung_dkw as $key => $value) {
      $tanggal_pengunjung_dkw[] = $value->tanggal_pengunjung;
    }

    // hr
    $pengunjung_hr = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DATE(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 4)
      ->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:00'])
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_hr = [];
    foreach ($pengunjung_hr as $key => $value) {
      $tanggal_pengunjung_hr[] = $value->tanggal_pengunjung;
    }

    // pbg
    $pengunjung_pbg = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DATE(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 5)
      ->where('jabatan', 'desain')
      ->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:00'])
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_pbg = [];
    foreach ($pengunjung_pbg as $key => $value) {
      $tanggal_pengunjung_pbg[] = $value->tanggal_pengunjung;
    }

    // cilacap
    $pengunjung_cilacap = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DATE(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 6)
      ->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:00'])
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_cilacap = [];
    foreach ($pengunjung_cilacap as $key => $value) {
      $tanggal_pengunjung_cilacap[] = $value->tanggal_pengunjung;
    }

    // bumiayu
    $pengunjung_bumiayu = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DATE(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 11)
      ->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:00'])
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_bumiayu = [];
    foreach ($pengunjung_bumiayu as $key => $value) {
      $tanggal_pengunjung_bumiayu[] = $value->tanggal_pengunjung;
    }

    // total
    $pengunjung_total = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DATE(tanggal) AS tanggal_pengunjung'))
      ->whereBetween('tanggal', [$start_date . ' 00:00:00', $end_date . ' 23:59:00'])
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_total = [];
    foreach ($pengunjung_total as $key => $value) {
      $tanggal_pengunjung_total[] = $value->tanggal_pengunjung;
    }

    $situmpur = [];
    $dkw = [];
    $hr = [];
    $pbg = [];
    $cilacap = [];
    $bumiayu = [];
    $total = [];
    
    foreach ($tanggal_pengunjung as $key => $value) {
      // data situmpur
      if (in_array($value, $tanggal_pengunjung_situmpur)) {
        foreach ($pengunjung_situmpur as $key => $value_situmpur) {
          if ($value_situmpur->tanggal_pengunjung == $value) {
            $situmpur[] = $value_situmpur->total_pengunjung;
          }
        }
      } else {
        $situmpur[] = 0;
      }

      // data dkw
      if (in_array($value, $tanggal_pengunjung_dkw)) {
        foreach ($pengunjung_dkw as $key => $value_dkw) {
          if ($value_dkw->tanggal_pengunjung == $value) {
            $dkw[] = $value_dkw->total_pengunjung;
          }
        }
      } else {
        $dkw[] = 0;
      }

      // data hr
      if (in_array($value, $tanggal_pengunjung_hr)) {
        foreach ($pengunjung_hr as $key => $value_hr) {
          if ($value_hr->tanggal_pengunjung == $value) {
            $hr[] = $value_hr->total_pengunjung;
          }
        }
      } else {
          $hr[] = 0;
      }

      // data pbg
      if (in_array($value, $tanggal_pengunjung_pbg)) {
        foreach ($pengunjung_pbg as $key => $value_pbg) {
          if ($value_pbg->tanggal_pengunjung == $value) {
            $pbg[] = $value_pbg->total_pengunjung;
          }
        }
      } else {
        $pbg[] = 0;
      }

      // data bumiayu
      if (in_array($value, $tanggal_pengunjung_bumiayu)) {
        foreach ($pengunjung_bumiayu as $key => $value_bumiayu) {
          if ($value_bumiayu->tanggal_pengunjung == $value) {
            $bumiayu[] = $value_bumiayu->total_pengunjung;
          }
        }
      } else {
        $bumiayu[] = 0;
      }

      // data cilacap
      if (in_array($value, $tanggal_pengunjung_cilacap)) {
        foreach ($pengunjung_cilacap as $key => $value_cilacap) {
          if ($value_cilacap->tanggal_pengunjung == $value) {
            $cilacap[] = $value_cilacap->total_pengunjung;
          }
        }
      } else {
        $cilacap[] = 0;
      }

      // data total
      if (in_array($value, $tanggal_pengunjung_total)) {
        foreach ($pengunjung_total as $key => $value_total) {
          if ($value_total->tanggal_pengunjung == $value) {
            $total[] = $value_total->total_pengunjung;
          }
        }
      } else {
        $total[] = 0;
      }
    }

    if ($cabang_id) {
      if ($cabang_id == 2) {
        $total_pengunjung = 'total_situmpur';
        $data_antrian_cabang = $situmpur;
        $jumlah_total_pengunjung = 'jumlah_total_situmpur';
        $data_jumlah_total_pengunjung = array_sum($situmpur);
      } else if ($cabang_id == 3) {
        $total_pengunjung = 'total_dkw';
        $data_antrian_cabang = $dkw;
        $jumlah_total_pengunjung = 'jumlah_total_dkw';
        $data_jumlah_total_pengunjung = array_sum($dkw);
      } else if ($cabang_id == 4) {
        $total_pengunjung = 'total_hr';
        $data_antrian_cabang = $hr;
        $jumlah_total_pengunjung = 'jumlah_total_hr';
        $data_jumlah_total_pengunjung = array_sum($hr);
      } else if ($cabang_id == 5) {
        $total_pengunjung = 'total_pbg';
        $data_antrian_cabang = $pbg;
        $jumlah_total_pengunjung = 'jumlah_total_pbg';
        $data_jumlah_total_pengunjung = array_sum($pbg);
      } else if ($cabang_id == 6) {
        $total_pengunjung = 'total_cilacap';
        $data_antrian_cabang = $cilacap;
        $jumlah_total_pengunjung = 'jumlah_total_cilacap';
        $data_jumlah_total_pengunjung = array_sum($cilacap);
      } else {
        $total_pengunjung = 'total_bumiayu';
        $data_antrian_cabang = $bumiayu;
        $jumlah_total_pengunjung = 'jumlah_total_bumiayu';
        $data_jumlah_total_pengunjung = array_sum($bumiayu);
      }
      
      return response()->json([
        'tes' => $tanggal_pengunjung,
        'total_tanggal' => $total_tanggal,
        'cabang_id' => $cabang_id,
        'cabang_antrians' => $this->cabang_antrian,
        'cabangs' => $this->cabang,
        'total' => $total,
        $total_pengunjung => $data_antrian_cabang,
        $jumlah_total_pengunjung => $data_jumlah_total_pengunjung
      ]);
    } else {
      return response()->json([
        'tes' => $tanggal_pengunjung,
        'total_tanggal' => $total_tanggal,
        'cabang_id' => $cabang_id,
        'cabang_antrians' => $this->cabang_antrian,
        'cabangs' => $this->cabang,
        'total_situmpur' => $situmpur,
        'total_dkw' => $dkw,
        'total_hr' => $hr,
        'total_pbg' => $pbg,
        'total_cilacap' => $cilacap,
        'total_bumiayu' => $bumiayu,
        'jumlah_total_situmpur' => array_sum($situmpur),
        'jumlah_total_dkw' => array_sum($dkw),
        'jumlah_total_hr' => array_sum($hr),
        'jumlah_total_pbg' => array_sum($pbg),
        'jumlah_total_cilacap' => array_sum($cilacap),
        'jumlah_total_bumiayu' => array_sum($bumiayu),
        'total' => $total,
        'grand_total' => array_sum($situmpur) + array_sum($dkw) + array_sum($hr) + array_sum($pbg) + array_sum($cilacap) + array_sum($bumiayu)
      ]);
    }
  }

  public function grafik()
  {
    $bulan_sekarang = date("Y-m");
    $tanggal_sekarang = date("d");

    $tanggal_pengunjung = [];
    for ($i=1; $i <= $tanggal_sekarang ; $i++) {
        $tanggal_pengunjung[] = $i;
    }

    // situmpur
    $pengunjung_situmpur = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
      ->where('master_cabang_id', 2)
      ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
      ->groupBy('tanggal_pengunjung')
      ->get();

    $tanggal_pengunjung_situmpur = [];
    foreach ($pengunjung_situmpur as $key => $value) {
      $tanggal_pengunjung_situmpur[] = $value->tanggal_pengunjung;
    }

    // dkw
    $pengunjung_dkw = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
        ->where('master_cabang_id', 3)
        ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
        ->groupBy('tanggal_pengunjung')
        ->get();

    $tanggal_pengunjung_dkw = [];
    foreach ($pengunjung_dkw as $key => $value) {
        $tanggal_pengunjung_dkw[] = $value->tanggal_pengunjung;
    }

    // hr
    $pengunjung_hr = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
        ->where('master_cabang_id', 4)
        ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
        ->groupBy('tanggal_pengunjung')
        ->get();

    $tanggal_pengunjung_hr = [];
    foreach ($pengunjung_hr as $key => $value) {
        $tanggal_pengunjung_hr[] = $value->tanggal_pengunjung;
    }

    // pbg
    $pengunjung_pbg = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
        ->where('master_cabang_id', 5)
        ->where('jabatan', 'desain')
        ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
        ->groupBy('tanggal_pengunjung')
        ->get();

    $tanggal_pengunjung_pbg = [];
    foreach ($pengunjung_pbg as $key => $value) {
        $tanggal_pengunjung_pbg[] = $value->tanggal_pengunjung;
    }

    // cilacap
    $pengunjung_cilacap = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
        ->where('master_cabang_id', 6)
        ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
        ->groupBy('tanggal_pengunjung')
        ->get();

    $tanggal_pengunjung_cilacap = [];
    foreach ($pengunjung_cilacap as $key => $value) {
        $tanggal_pengunjung_cilacap[] = $value->tanggal_pengunjung;
    }

    // bumiayu
    $pengunjung_bumiayu = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
        ->where('master_cabang_id', 11)
        ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
        ->groupBy('tanggal_pengunjung')
        ->get();

    $tanggal_pengunjung_bumiayu = [];
    foreach ($pengunjung_bumiayu as $key => $value) {
        $tanggal_pengunjung_bumiayu[] = $value->tanggal_pengunjung;
    }

    $situmpur = [];
    $dkw = [];
    $hr = [];
    $pbg = [];
    $cilacap = [];
    $bumiayu = [];
    foreach ($tanggal_pengunjung as $key => $value) {
        // data situmpur
        if (in_array($value, $tanggal_pengunjung_situmpur)) {
            foreach ($pengunjung_situmpur as $key => $value_situmpur) {
                if ($value_situmpur->tanggal_pengunjung == $value) {
                    $situmpur[] = $value_situmpur->total_pengunjung;
                }
            }
        } else {
            $situmpur[] = 0;
        }

        // data dkw
        if (in_array($value, $tanggal_pengunjung_dkw)) {
            foreach ($pengunjung_dkw as $key => $value_dkw) {
                if ($value_dkw->tanggal_pengunjung == $value) {
                    $dkw[] = $value_dkw->total_pengunjung;
                }
            }
        } else {
            $dkw[] = 0;
        }

        // data hr
        if (in_array($value, $tanggal_pengunjung_hr)) {
            foreach ($pengunjung_hr as $key => $value_hr) {
                if ($value_hr->tanggal_pengunjung == $value) {
                    $hr[] = $value_hr->total_pengunjung;
                }
            }
        } else {
            $hr[] = 0;
        }

        // data pbg
        if (in_array($value, $tanggal_pengunjung_pbg)) {
            foreach ($pengunjung_pbg as $key => $value_pbg) {
                if ($value_pbg->tanggal_pengunjung == $value) {
                    $pbg[] = $value_pbg->total_pengunjung;
                }
            }
        } else {
            $pbg[] = 0;
        }

        // data bumiayu
        if (in_array($value, $tanggal_pengunjung_bumiayu)) {
            foreach ($pengunjung_bumiayu as $key => $value_bumiayu) {
                if ($value_bumiayu->tanggal_pengunjung == $value) {
                    $bumiayu[] = $value_bumiayu->total_pengunjung;
                }
            }
        } else {
            $bumiayu[] = 0;
        }

        // data cilacap
        if (in_array($value, $tanggal_pengunjung_cilacap)) {
            foreach ($pengunjung_cilacap as $key => $value_cilacap) {
                if ($value_cilacap->tanggal_pengunjung == $value) {
                    $cilacap[] = $value_cilacap->total_pengunjung;
                }
            }
        } else {
            $cilacap[] = 0;
        }
    }

    return response()->json([
        'tanggal' => $tanggal_pengunjung,
        'total_pengunjung_situmpur' => $situmpur,
        'total_pengunjung_dkw' => $dkw,
        'total_pengunjung_hr' => $hr,
        'total_pengunjung_pbg' => $pbg,
        'total_pengunjung_cilacap' => $cilacap,
        'total_pengunjung_bumiayu' => $bumiayu
    ]);
  }

  public function excel(Request $request)
  {
    $tahun = $request->tahun;
    $bulan = $request->bulan;
    $cabang_id = $request->cabang_id;

    return Excel::download(new AntrianExport($tahun, $bulan, $cabang_id), 'antrian.xlsx');
  }

    // public function antrianPengunjung($id)
    // {
    //     $customers = AntrianPengunjung::select(DB::raw('nama_customer, telepon'), DB::raw('MAX(tanggal) AS tanggal_terakhir_pengunjung'), DB::raw('count(*) AS total'))
    //         ->where('master_cabang_id', $id)
    //         ->groupBy('nama_customer', 'telepon')
    //         ->orderBy('total', 'desc')
    //         ->limit(10)
    //         ->get();

    //     $customer_terakhirs = AntrianPengunjung::where('master_cabang_id', $id)
    //         ->orderBy('id', 'desc')
    //         ->limit(100)
    //         ->get();

    //     return view('pages.antrian.index', [
    //         'customers' => $customers,
    //         'customer_terakhirs' => $customer_terakhirs,
    //         'cabang_id' => $id
    //     ]);
    // }

    // public function antrianPengunjungGrafik($id)
    // {
    //     // data pengunjung bulan ini--------------------------------------------------------------------
    //     $bulan_sekarang = date("Y-m");

    //     $pengunjung = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
    //         ->where('master_cabang_id', $id)
    //         ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
    //         ->groupBy('tanggal_pengunjung')
    //         ->get();

    //     $tanggal_pengunjung = [];
    //     $total_pengunjung = [];
    //     foreach ($pengunjung as $key => $value) {
    //         $tanggal_pengunjung[] = $value->tanggal_pengunjung;
    //         $total_pengunjung[] = $value->total_pengunjung;
    //     }

    //     // data customer yang sering datang berdasarkan shift--------------------------------------------------------------
    //     $customer_shift_1 = AntrianPengunjung::select(DB::raw('COUNT(HOUR(tanggal)) AS total_pengunjung', 'tanggal'), DB::raw('DAY(tanggal) as tanggal_pengunjung'))
    //         ->where('master_cabang_id', $id)
    //         ->whereBetween(DB::raw('HOUR(tanggal)'), [8,14])
    //         ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
    //         ->groupBy('tanggal_pengunjung')
    //         ->get();

    //     $data_customer_shift_1 = [];
    //     $tanggal_customer_shift_1 = [];
    //     foreach ($customer_shift_1 as $key => $value) {
    //         $data_customer_shift_1[] = $value->total_pengunjung;
    //         $tanggal_customer_shift_1[] = $value->tanggal_pengunjung;
    //     }

    //     $customer_shift_2 = AntrianPengunjung::select(DB::raw('COUNT(HOUR(tanggal)) AS total_pengunjung', 'tanggal'), DB::raw('DAY(tanggal) as tanggal_pengunjung'))
    //         ->where('master_cabang_id', $id)
    //         ->whereBetween(DB::raw('HOUR(tanggal)'), [15,21])
    //         ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
    //         ->groupBy('tanggal_pengunjung')
    //         ->get();

    //     $data_customer_shift_2 = [];
    //     foreach ($customer_shift_2 as $key => $value) {
    //         $data_customer_shift_2[] = $value->total_pengunjung;
    //     }

    //     return response()->json([
    //         'tanggal_pengunjung' => $tanggal_pengunjung,
    //         'total_pengunjung' => $total_pengunjung,
    //         'pengunjung_shift_1' => $data_customer_shift_1,
    //         'tanggal_customer_shift_1' => $tanggal_customer_shift_1,
    //         'pengunjung_shift_2' => $data_customer_shift_2,
    //     ]);
    // }
}
