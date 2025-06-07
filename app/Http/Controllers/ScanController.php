<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    /**
     * Menampilkan halaman scanner QR Code
     */
    public function showScanner()
    {
        return view('scan.index');
    }

    /**
     * Memproses hasil scan QR Code
     */
    public function processScan(Request $request)
    {
        try {
            Log::info('Memproses permintaan scan:', $request->all());
            
            // Ganti find() dengan where('user_id', ...) agar cocok dengan kolom user_id
            $user = User::where('user_id', $request->user_id)->first();

            if (!$user) {
                Log::error('User tidak ditemukan:', ['user_id' => $request->user_id]);
                return redirect()->route('scan.error')->with('error', 'ID anggota tidak ditemukan.');
            }

            $alreadyPresent = Presence::where('user_id', $user->id)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if ($alreadyPresent) {
                Log::warning('Percobaan presensi ganda:', ['user_id' => $user->id]);
                return redirect()->route('scan.error')->with('error', 'Anda sudah melakukan presensi hari ini.');
            }

            $presenceData = [
                'user_id' => $user->id,
                'status' => $request->status ?? 'hadir',
                'keterangan' => $request->keterangan,
                'scan_time' => now()
            ];

            Log::info('Membuat data presensi:', $presenceData);
            
            $presence = Presence::create($presenceData);

            Log::info('Presensi berhasil dibuat:', $presence->toArray());

            return redirect()->route('scan.success')->with([
                'success' => 'Presensi berhasil dicatat',
                'data' => [
                    'nama' => $user->name,
                    'status' => $presence->status,
                    'waktu' => $presence->scan_time->format('d-m-Y H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal memproses presensi:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('scan.error')->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman sukses scan
     */
    public function scanSuccess()
    {
        if (!session()->has('success')) {
            return redirect()->route('scan.show');
        }

        return view('scan.success', [
            'message' => session('success'),
            'data' => session('data')
        ]);
    }

    /**
     * Menampilkan halaman error scan
     */
    public function scanError()
    {
        if (!session()->has('error')) {
            return redirect()->route('scan.show');
        }

        return view('scan.error', [
            'message' => session('error')
        ]);
    }
}
