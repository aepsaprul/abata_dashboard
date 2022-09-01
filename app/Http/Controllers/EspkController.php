<?php

namespace App\Http\Controllers;

use App\Models\EspkPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspkController extends Controller
{
    public function grafik()
    {
        $bulan_sekarang = date("Y-m");
        $tanggal_sekarang = date("d");

        $tanggal = [];
        for ($i=1; $i <= $tanggal_sekarang ; $i++) {
            $tanggal[] = $i;
        }

        // situmpur
        $pesanan_situmpur = EspkPekerjaan::select(DB::raw('count(*) AS total_pesanan'), DB::raw('DAY(created_at) AS tanggal_input'))
            ->where('cabang_pemesan_id', 2)
            ->where('created_at', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_input')
            ->get();

        $tanggal_situmpur = [];
        foreach ($pesanan_situmpur as $key => $value) {
            $tanggal_situmpur[] = $value->tanggal_input;
        }

        // dkw
        $pesanan_dkw = EspkPekerjaan::select(DB::raw('count(*) AS total_pesanan'), DB::raw('DAY(created_at) AS tanggal_input'))
            ->where('cabang_pemesan_id', 3)
            ->where('created_at', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_input')
            ->get();

        $tanggal_dkw = [];
        foreach ($pesanan_dkw as $key => $value) {
            $tanggal_dkw[] = $value->tanggal_input;
        }

        // hr
        $pesanan_hr = EspkPekerjaan::select(DB::raw('count(*) AS total_pesanan'), DB::raw('DAY(created_at) AS tanggal_input'))
            ->where('cabang_pemesan_id', 4)
            ->where('created_at', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_input')
            ->get();

        $tanggal_hr = [];
        foreach ($pesanan_hr as $key => $value) {
            $tanggal_hr[] = $value->tanggal_input;
        }

        // pbg
        $pesanan_pbg = EspkPekerjaan::select(DB::raw('count(*) AS total_pesanan'), DB::raw('DAY(created_at) AS tanggal_input'))
            ->where('cabang_pemesan_id', 5)
            ->where('created_at', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_input')
            ->get();

        $tanggal_pbg = [];
        foreach ($pesanan_pbg as $key => $value) {
            $tanggal_pbg[] = $value->tanggal_input;
        }

        // cilacap
        $pesanan_cilacap = EspkPekerjaan::select(DB::raw('count(*) AS total_pesanan'), DB::raw('DAY(created_at) AS tanggal_input'))
            ->where('cabang_pemesan_id', 6)
            ->where('created_at', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_input')
            ->get();

        $tanggal_cilacap = [];
        foreach ($pesanan_cilacap as $key => $value) {
            $tanggal_cilacap[] = $value->tanggal_input;
        }

        // bumiayu
        $pesanan_bumiayu = EspkPekerjaan::select(DB::raw('count(*) AS total_pesanan'), DB::raw('DAY(created_at) AS tanggal_input'))
            ->where('cabang_pemesan_id', 11)
            ->where('created_at', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_input')
            ->get();

        $tanggal_bumiayu = [];
        foreach ($pesanan_bumiayu as $key => $value) {
            $tanggal_bumiayu[] = $value->tanggal_input;
        }

        $situmpur = [];
        $dkw = [];
        $hr = [];
        $pbg = [];
        $cilacap = [];
        $bumiayu = [];
        foreach ($tanggal as $key => $value) {
            // data situmpur
            if (in_array($value, $tanggal_situmpur)) {
                foreach ($pesanan_situmpur as $key => $value_situmpur) {
                    if ($value_situmpur->tanggal_input == $value) {
                        $situmpur[] = $value_situmpur->total_pesanan;
                    }
                }
            } else {
                $situmpur[] = 0;
            }

            // data dkw
            if (in_array($value, $tanggal_dkw)) {
                foreach ($pesanan_dkw as $key => $value_dkw) {
                    if ($value_dkw->tanggal_input == $value) {
                        $dkw[] = $value_dkw->total_pesanan;
                    }
                }
            } else {
                $dkw[] = 0;
            }

            // data hr
            if (in_array($value, $tanggal_hr)) {
                foreach ($pesanan_hr as $key => $value_hr) {
                    if ($value_hr->tanggal_input == $value) {
                        $hr[] = $value_hr->total_pesanan;
                    }
                }
            } else {
                $hr[] = 0;
            }

            // data pbg
            if (in_array($value, $tanggal_pbg)) {
                foreach ($pesanan_pbg as $key => $value_pbg) {
                    if ($value_pbg->tanggal_input == $value) {
                        $pbg[] = $value_pbg->total_pesanan;
                    }
                }
            } else {
                $pbg[] = 0;
            }

            // data bumiayu
            if (in_array($value, $tanggal_bumiayu)) {
                foreach ($pesanan_bumiayu as $key => $value_bumiayu) {
                    if ($value_bumiayu->tanggal_input == $value) {
                        $bumiayu[] = $value_bumiayu->total_pesanan;
                    }
                }
            } else {
                $bumiayu[] = 0;
            }

            // data cilacap
            if (in_array($value, $tanggal_cilacap)) {
                foreach ($pesanan_cilacap as $key => $value_cilacap) {
                    if ($value_cilacap->tanggal_input == $value) {
                        $cilacap[] = $value_cilacap->total_pesanan;
                    }
                }
            } else {
                $cilacap[] = 0;
            }
        }

        return response()->json([
            'tanggal' => $tanggal,
            'total_pesanan_situmpur' => $situmpur,
            'total_pesanan_dkw' => $dkw,
            'total_pesanan_hr' => $hr,
            'total_pesanan_pbg' => $pbg,
            'total_pesanan_cilacap' => $cilacap,
            'total_pesanan_bumiayu' => $bumiayu
        ]);
    }
}
