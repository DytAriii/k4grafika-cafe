<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\LogActivity;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
$logs = ActivityLog::whereDate('created_at', Carbon::today())
    ->orderBy('created_at', 'desc')
    ->get();

        // ----- Total pendapatan hari ini -----
        $todayIncome = DB::table('transaksis')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        // ----- Jumlah transaksi hari ini -----
        $todayTransactions = DB::table('transaksis')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // ----- Total menu aktif -----
        $activeMenu = DB::table('menus')
    ->where('status_id', 1)
    ->count();

        // ----- Menu terlaris hari ini -----
        $topMenuToday = DB::table('transaksi_details')
            ->join('menus', 'transaksi_details.menu_id', '=', 'menus.id')
            ->select('menus.nama', DB::raw('SUM(transaksi_details.jumlah) as total'))
            ->whereDate('transaksi_details.created_at', Carbon::today())
            ->groupBy('menus.nama')
            ->orderByDesc('total')
            ->first();

        // ----- Grafik: Penjualan 7 hari -----
        $sevenDays = DB::table('transaksis')
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // ----- Grafik: Pendapatan Bulanan -----
        $monthlySales = DB::table('transaksis')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(total) as total')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // ----- Menu terlaris (top 5) -----
        $topMenu = DB::table('transaksi_details')
            ->join('menus', 'transaksi_details.menu_id', '=', 'menus.id')
            ->select('menus.nama', DB::raw('SUM(transaksi_details.jumlah) as total'))
            ->groupBy('menus.nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'todayIncome',
            'todayTransactions',
            'activeMenu',
            'topMenuToday',
            'sevenDays',
            'monthlySales',
            'topMenu',
              'logs'
        ));
    }

    public function filterByDate()
{
    $date = request('date'); // yyyy-mm-dd

    // ---- Total pendapatan pada tanggal tersebut ----
    $income = DB::table('transaksis')
        ->whereDate('created_at', $date)
        ->sum('total');

    // ---- Jumlah transaksi pada tanggal tersebut ----
    $transactions = DB::table('transaksis')
        ->whereDate('created_at', $date)
        ->count();

    // ---- Menu aktif (tetap sama) ----
    $activeMenu = DB::table('menus')
        ->where('status_id', 1)
        ->count();

    // ---- Menu terlaris tanggal tersebut ----
    $topMenu = DB::table('transaksi_details')
        ->join('menus', 'transaksi_details.menu_id', '=', 'menus.id')
        ->select('menus.nama', DB::raw('SUM(transaksi_details.jumlah) as total'))
        ->whereDate('transaksi_details.created_at', $date)
        ->groupBy('menus.nama')
        ->orderByDesc('total')
        ->first();

        $logs = ActivityLog::whereDate('created_at', $date)
    ->orderBy('created_at', 'desc')
    ->get();


    return response()->json([
        'income' => $income,
        'transactions' => $transactions,
        'activeMenu' => $activeMenu,
        'topMenu' => $topMenu ? $topMenu->nama : "-",
        'topMenuTotal' => $topMenu ? $topMenu->total : 0,
            'logs' => $logs
    ]);
}

}