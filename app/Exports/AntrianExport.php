<?php

namespace App\Exports;

use App\Models\AntrianPengunjung;
use App\Models\Cabang;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Str;

class AntrianExport implements FromView
{
  public function __construct($tahun, $bulan, $cabang_id)
  {
      $this->tahun = $tahun;
      $this->bulan = $bulan;
      $this->cabang_id = $cabang_id;
  }

  public function view(): View
  {
    $bulan_sekarang = $this->tahun . "-" . $this->bulan;

    // array tanggal
    $kalender = CAL_GREGORIAN;
    $bulan = $this->bulan;
    $tahun = $this->tahun;
    $jumlah_hari = cal_days_in_month($kalender, $bulan, $tahun);

    $dates = [];
    for ($i=1; $i <= $jumlah_hari ; $i++) {
      $dates[] = $i;
    }

    $cabang = Cabang::get();

    if ($this->cabang_id == "") {
      return view('pages.antrian.template_excel', [
        'antrians' => AntrianPengunjung::with('cabang')->select(DB::raw('master_cabang_id AS master_cabang'))
          ->whereNotNull('master_cabang_id')
          ->groupBy('master_cabang')
          ->get(),
          'tanggals' => $dates,
          'cabangs' => $cabang
      ]);
    } else {
      return view('pages.antrian.template_excel', [
        'antrians' => AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
          ->where('master_cabang_id', 2)
          ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
          ->groupBy('tanggal_pengunjung')
          ->get(),
          'tanggals' => $dates,
          'cabangs' => $cabang
      ]);
    }
  }
}
