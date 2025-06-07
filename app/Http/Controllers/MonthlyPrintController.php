<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Presence;


class MonthlyPrintController extends Controller
{
   // app/Http/Controllers/MonthlyPrintController.php
public function printBulanan(Request $request)
{
    $month = $request->input('month');

    if ($month) {
        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
    } else {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    }

    // Pastikan field yang difilter sesuai dengan yang disimpan
    $attendances = Presence::with('user')
        ->whereBetween('scan_time', [$startDate, $endDate])
        ->orderBy('scan_time', 'asc')
        ->get();

    return view('prints.print-bulanan', [
        'attendances' => $attendances,
        'month' => $startDate->translatedFormat('F Y')
    ]);
}
}