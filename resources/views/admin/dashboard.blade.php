@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Ringkasan')
@section('content')
 
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
 
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
 
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
        <h3 class="text-2xl font-black">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
    </div>
 
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Aktif</p>
        <h3 class="text-2xl font-black">{{ $activeEvents }} Event</h3>
    </div>
 
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Pesanan Pending</p>
        <h3 class="text-2xl font-black">{{ $pendingOrders }} Pesanan</h3>
    </div>
 
</div>
 
<!-- Latest Sales Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex justify-between items-center">
        <h3 class="font-black text-xl">Transaksi Terakhir</h3>
        <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
    </div>
 
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                    <th class="px-8 py-4 w-1/4">Pembeli</th>
                    <th class="px-8 py-4 w-1/4">Event</th>
                    <th class="px-8 py-4 w-[10%]">Status</th>
                    <th class="px-8 py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentTransactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6 text-sm text-slate-600 max-w-xs break-all">
                        {{ $trx->created_at->format('d M y - H:i') }}<br>
                        <span class="text-xs text-slate-400">{{ $trx->order_id }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold uppercase tracking-wide text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-8 py-6 font-medium text-slate-600 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                    <td class="px-8 py-6 whitespace-nowrap">
                        @if($trx->status === 'settlement' || $trx->status === 'success')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                        @elseif($trx->status === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
 
@endsection
