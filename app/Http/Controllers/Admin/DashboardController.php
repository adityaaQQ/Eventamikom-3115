<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menjumlahkan nominal total_price dari transaksi yang lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])
            ->sum('total_price');
 
        // 2. Menghitung jumlah tiket yang sudah lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])
            ->count();
 
        // 3. Menghitung jumlah acara mendatang yang aktif
        $activeEvents = Event::where('date', '>=', now())->count();
 
        // 4. Menghitung transaksi yang statusnya masih pending
        $pendingOrders = Transaction::where('status', 'pending')->count();
 
        // 5. Menyertakan 5 riwayat pesanan paling mutakhir
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();
 
        return view('admin.dashboard', compact(
            'totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders', 'recentTransactions'
        ));
    }

    public function indexEvent()
    {
        return view('admin.events');
    }

    public function indexTransaction()
    {
        return view('admin.transactions');
    }
}