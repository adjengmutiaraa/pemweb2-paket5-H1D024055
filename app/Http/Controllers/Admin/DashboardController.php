<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'total_bookings'  => Booking::count(),
            'today_bookings'  => Booking::whereDate('booking_date', $today)->count(),
            'pending_payment' => Booking::where('status', 'menunggu_pembayaran')->count(),
            'today_revenue'   => Booking::whereDate('booking_date', $today)
                                    ->where('status', 'terkonfirmasi')
                                    ->sum('total_price'),
            'total_fields'    => Field::count(),
            'total_users'     => User::where('role', 'user')->count(),
        ];

        // Booking terkonfirmasi 7 hari ke depan untuk kalender
        $calendarBookings = Booking::with(['field', 'user'])
            ->where('booking_date', '>=', $today)
            ->where('booking_date', '<=', $today->copy()->addDays(6))
            ->where('status', 'terkonfirmasi')
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($b) => $b->booking_date->format('Y-m-d'));

        // Pendapatan harian 7 hari terakhir
        $dailyRevenue = Booking::where('status', 'terkonfirmasi')
            ->where('booking_date', '>=', $today->copy()->subDays(6))
            ->selectRaw('booking_date, SUM(total_price) as revenue, COUNT(*) as count')
            ->groupBy('booking_date')
            ->orderBy('booking_date')
            ->get();

        // Booking menunggu konfirmasi (sudah upload bukti bayar)
        $pendingBookings = Booking::with(['user', 'field'])
            ->where('status', 'menunggu_pembayaran')
            ->whereNotNull('payment_proof')
            ->latest()
            ->take(5)
            ->get();
        // Total pendapatan (hanya yang sudah terkonfirmasi atau selesai)
        $totalRevenue = Booking::whereIn('status', ['terkonfirmasi', 'selesai'])->sum('amount_paid');
        
        return view('admin.dashboard', compact(
            'stats',
            'calendarBookings',
            'dailyRevenue',
            'pendingBookings',
            'totalRevenue',
            'today'
        ));
    }
}
