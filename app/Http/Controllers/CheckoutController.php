<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Transaction;
use App\Mail\EventTicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        // 1. Validasi Input Kredensial Pelanggan
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. Cegah Check-out Jika Tiket Habis
        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        // 3. Generate Kode TRX (Unik)
        $orderId = 'TRX-' . time() . '-' . Str::random(5);

        // =========================================================
        // IMPLEMENTASI FITUR: BYPASS TRANSAKSI UNTUK ACARA GRATIS
        // =========================================================
        if ($event->price == 0) {
            // A. Simpan Transaksi Gratis Langsung Sukses (Tanpa Biaya Admin & Tanpa Midtrans)
            $transaction = Transaction::create([
                'event_id'       => $event->id,
                'order_id'       => $orderId,
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price'    => 0,
                'status'         => 'success', // Langsung set lunas/sukses
                'snap_token'     => null,
            ]);

            // B. Kurangi Stok Tiket Event (-1)
            $event->decrement('stock');

            // C. Kirim E-Ticket ke Email Pembeli
            try {
                Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email E-Ticket gratis: ' . $e->getMessage());
            }

            // D. Langsung Alihkan ke Halaman Sukses
            return redirect()->route('checkout.success', $transaction->order_id)
                             ->with('success', 'Selamat! Tiket gratis berhasil diklaim.');
        }

        // =========================================================
        // TRANSAKSI TIKET BERBAYAR (MIDTRANS INTEGRATION)
        // =========================================================
        $totalPrice = $event->price + 5000; // Menambahkan biaya admin Rp 5.000 untuk event berbayar

        // Merekam Transaksi ke Database sebelum panggil Midtrans
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'pending',
        ]);

        // Konfigurasi kredensial environment Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Mode Sandbox!
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Susun array data transaksi
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ],
        ];

        try {
            // Perintah generate Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Update rekaman transaksi dengan snap_token
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman pembayaran
            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        // Jika transaksi gratis / sudah sukses sebelumnya, langsung tampilkan halaman tanpa cek Midtrans API
        if ($transaction->total_price == 0 || $transaction->status === 'success') {
            return view('checkout.success', compact('transaction', 'categories'));
        }

        // Konfigurasi Midtrans untuk mengecek status transaksi berbayar langsung ke API
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            // Mengecek status pesanan secara mandiri (Bypass)
            $status = MidtransTransaction::status($order_id);
            
            if ($status) {
                // Mengambil nilai status transaksi
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');
                
                // Jika API Midtrans mengonfirmasi bahwa transaksi telah berhasil (settlement / capture)
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    // Hanya lakukan update jika status di database lokal masih 'pending' (indikasi Webhook tidak masuk)
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'success']);
                        
                        if ($transaction->event && $transaction->event->stock > 0) {
                            $transaction->event->decrement('stock');
                            
                            try {
                                Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
                            } catch (\Exception $e) {
                                Log::error('Gagal mengirim email E-Ticket secara manual (Bypass): ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika terjadi error dari API Midtrans (transaksi tidak valid), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}