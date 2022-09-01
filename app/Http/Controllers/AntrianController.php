<?php

namespace App\Http\Controllers;

use App\Models\AntrianPengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
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
