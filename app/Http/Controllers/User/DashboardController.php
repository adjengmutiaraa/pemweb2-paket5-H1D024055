<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total'       => $user->bookings()->count(),
            'aktif'       => $user->bookings()->where('status', 'terkonfirmasi')
                                ->where('booking_date', '>=', today())->count(),
            'menunggu'    => $user->bookings()->where('status', 'menunggu_pembayaran')->count(),
            'selesai'     => $user->bookings()->where('status', 'selesai')->count(),
        ];

        $recentBookings = $user->bookings()
            ->with('field.fieldType')
            ->latest()
            ->take(5)
            ->get();

        $upcomingBookings = $user->bookings()
            ->with('field.fieldType')
            ->where('status', 'terkonfirmasi')
            ->where('booking_date', '>=', today())
            ->orderBy('booking_date')
            ->take(3)
            ->get();

        return view('user.dashboard', compact('stats', 'recentBookings', 'upcomingBookings'));
    }
}
