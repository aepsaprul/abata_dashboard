<?php

namespace App\Http\Controllers;

use App\Models\AntrianPengunjung;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cabangs = Cabang::get();

        return view('home', [
            'cabangs' => $cabangs
        ]);
    }

    public function antrianGrafik()
    {
        $bulan_sekarang = date("Y-m");

        // situmpur
        $pengunjung_situmpur = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', 2)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $tanggal_pengunjung = [];
        $total_pengunjung_situmpur = [];
        foreach ($pengunjung_situmpur as $key => $value) {
            $tanggal_pengunjung[] = $value->tanggal_pengunjung;
            $total_pengunjung_situmpur[] = $value->total_pengunjung;
        }

        // dkw
        $pengunjung_dkw = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', 3)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $total_pengunjung_dkw = [];
        foreach ($pengunjung_dkw as $key => $value) {
            $total_pengunjung_dkw[] = $value->total_pengunjung;
        }

        // hr
        $pengunjung_dkw = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', 4)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $total_pengunjung_hr = [];
        foreach ($pengunjung_dkw as $key => $value) {
            $total_pengunjung_hr[] = $value->total_pengunjung;
        }

        // pbg
        $pengunjung_pbg = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', 5)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $total_pengunjung_pbg = [];
        foreach ($pengunjung_pbg as $key => $value) {
            $total_pengunjung_pbg[] = $value->total_pengunjung;
        }

        // cilacap
        $pengunjung_cilacap = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', 6)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $total_pengunjung_cilacap = [];
        foreach ($pengunjung_cilacap as $key => $value) {
            $total_pengunjung_cilacap[] = $value->total_pengunjung;
        }

        // bumiayu
        $pengunjung_bumiayu = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', 11)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $total_pengunjung_bumiayu = [];
        foreach ($pengunjung_bumiayu as $key => $value) {
            $total_pengunjung_bumiayu[] = $value->total_pengunjung;
        }

        return response()->json([
            'tanggal_pengunjung' => $tanggal_pengunjung,
            'total_pengunjung_situmpur' => $total_pengunjung_situmpur,
            'total_pengunjung_dkw' => $total_pengunjung_dkw,
            'total_pengunjung_hr' => $total_pengunjung_hr,
            'total_pengunjung_pbg' => $total_pengunjung_pbg,
            'total_pengunjung_cilacap' => $total_pengunjung_cilacap,
            'total_pengunjung_bumiayu' => $total_pengunjung_bumiayu
        ]);
    }

    public function antrianPengunjung($id)
    {
        $customers = AntrianPengunjung::select(DB::raw('nama_customer, telepon'), DB::raw('MAX(tanggal) AS tanggal_terakhir_pengunjung'), DB::raw('count(*) AS total'))
            ->where('master_cabang_id', $id)
            ->groupBy('nama_customer', 'telepon')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $customer_terakhirs = AntrianPengunjung::where('master_cabang_id', $id)
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        return view('pages.antrian.index', [
            'customers' => $customers,
            'customer_terakhirs' => $customer_terakhirs,
            'cabang_id' => $id
        ]);
    }

    public function antrianPengunjungGrafik($id)
    {
        // data pengunjung bulan ini--------------------------------------------------------------------
        $bulan_sekarang = date("Y-m");

        $pengunjung = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', $id)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $tanggal_pengunjung = [];
        $total_pengunjung = [];
        foreach ($pengunjung as $key => $value) {
            $tanggal_pengunjung[] = $value->tanggal_pengunjung;
            $total_pengunjung[] = $value->total_pengunjung;
        }

        // data customer yang sering datang berdasarkan shift--------------------------------------------------------------
        $customer_shift_1 = AntrianPengunjung::select(DB::raw('COUNT(HOUR(tanggal)) AS total_pengunjung', 'tanggal'), DB::raw('DAY(tanggal) as tanggal_pengunjung'))
            ->where('master_cabang_id', $id)
            ->whereBetween(DB::raw('HOUR(tanggal)'), [8,14])
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $data_customer_shift_1 = [];
        $tanggal_customer_shift_1 = [];
        foreach ($customer_shift_1 as $key => $value) {
            $data_customer_shift_1[] = $value->total_pengunjung;
            $tanggal_customer_shift_1[] = $value->tanggal_pengunjung;
        }

        $customer_shift_2 = AntrianPengunjung::select(DB::raw('COUNT(HOUR(tanggal)) AS total_pengunjung', 'tanggal'), DB::raw('DAY(tanggal) as tanggal_pengunjung'))
            ->where('master_cabang_id', $id)
            ->whereBetween(DB::raw('HOUR(tanggal)'), [15,21])
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $data_customer_shift_2 = [];
        foreach ($customer_shift_2 as $key => $value) {
            $data_customer_shift_2[] = $value->total_pengunjung;
        }

        return response()->json([
            'tanggal_pengunjung' => $tanggal_pengunjung,
            'total_pengunjung' => $total_pengunjung,
            'pengunjung_shift_1' => $data_customer_shift_1,
            'tanggal_customer_shift_1' => $tanggal_customer_shift_1,
            'pengunjung_shift_2' => $data_customer_shift_2,
        ]);
    }
}
