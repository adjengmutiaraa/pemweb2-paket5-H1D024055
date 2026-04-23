<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');
        [$year, $monthNum] = explode('-', $month);

        $bookings = Booking::with(['user', 'field.fieldType'])
            ->whereYear('booking_date', $year)
            ->whereMonth('booking_date', $monthNum)
            ->where('status', 'terkonfirmasi')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totalRevenue = Booking::whereYear('booking_date', $year)
            ->whereMonth('booking_date', $monthNum)
            ->where('status', 'terkonfirmasi')
            ->sum('total_price');

        $revenueByField = Booking::with('field.fieldType')
            ->whereYear('booking_date', $year)
            ->whereMonth('booking_date', $monthNum)
            ->where('status', 'terkonfirmasi')
            ->selectRaw('field_id, SUM(total_price) as total, COUNT(*) as count')
            ->groupBy('field_id')
            ->get();

        return view('admin.reports.index', compact(
            'bookings', 'totalRevenue', 'revenueByField', 'month'
        ));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');
        [$year, $monthNum] = explode('-', $month);

        $bookings = Booking::with(['user', 'field.fieldType'])
            ->whereYear('booking_date', $year)
            ->whereMonth('booking_date', $monthNum)
            ->where('status', 'terkonfirmasi')
            ->get();

        $totalRevenue = $bookings->sum('total_price');

        $revenueByField = $bookings->groupBy('field_id')->map(function ($group) {
            return [
                'field' => $group->first()->field,
                'total' => $group->sum('total_price'),
                'count' => $group->count(),
            ];
        });

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'bookings', 'totalRevenue', 'revenueByField', 'month', 'year', 'monthNum'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("laporan-pendapatan-{$month}.pdf");
    }
}
