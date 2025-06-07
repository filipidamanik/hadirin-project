<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Kehadiran Bulanan </title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @media print {
      body { 
        padding: 0; 
        margin: 0; 
        font-size: 12pt;
        background: white;
      }
      .no-print { 
        display: none !important; 
      }
      .page-break { 
        page-break-after: always; 
      }
      header { 
        display: none; 
      }
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th, td {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
      }
      .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 20px;
      }
    }
    
    @page {
      size: A4 portrait;
      margin: 15mm;
    }
    
    .action-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.2s ease;
      cursor: pointer;
    }
    
    .action-btn:hover {
      transform: translateY(-1px);
    }
    
    @media (max-width: 640px) {
      .action-text {
        display: none;
      }
      .action-btn {
        padding: 8px 12px;
      }
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header untuk tampilan web -->
  <header class="bg-white shadow-sm no-print">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors" title="Kembali ke Beranda">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">
          Rekap Kehadiran Bulanan Guru
        </h1>
      </div>
    </div>
  </header>

   <!-- Header untuk cetakan -->
   <div class="print-header hidden bg-white py-4 border-b-2 border-blue-600">
    <div class="text-center">
      <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="h-16 mx-auto mb-2">
      <h1 class="text-xl font-bold">SMK NEGERI 1 KOTA BENGKULU</h1>
      <p class="text-sm">Jl. Jati No 41, Kelurahan Padang Jati<br>Kecamatan Ratu Samban, Kota Bengkulu 38222</p>
      <h2 class="text-lg font-semibold mt-4">REKAPITULASI KEHADIRAN BULANAN GURU</h2>
      <p class="text-md font-medium text-blue-600">{{ $month }}</p>
    </div>
  </div>

  <div class="max-w-7xl mx-auto p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="px-6 py-4 border-b bg-gray-50 no-print">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div class="text-center md:text-left">
            <h2 class="text-xl font-semibold text-gray-800">REKAP KEHADIRAN GURU BULANAN</h2>
            <p class="text-gray-600">SMKN 1 Kota Bengkulu</p>
            <p class="text-md font-medium text-blue-600">{{ $month }}</p>
          </div>
          <div class="flex items-center gap-2">
            <button onclick="window.print()" class="action-btn bg-blue-600 text-white hover:bg-blue-700">
              <i class="fas fa-print"></i>
              <span class="action-text">Cetak</span>
            </button>
          </div>
        </div>
      </div>
      
      <div class="p-4 sm:p-6">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Guru</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Waktu</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Keterangan</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($attendances as $index => $attendance)
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center">{{ $index + 1 }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ $attendance->user->name }}</div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                  {{ $attendance->scan_time->format('d-m-Y') }}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                  {{ $attendance->scan_time->format('H:i:s') }}
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $attendance->status === 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $attendance->status === 'izin' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $attendance->status === 'sakit' ? 'bg-purple-100 text-purple-800' : '' }}
                      {{ $attendance->status === 'tidak hadir' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($attendance->status) }}
                  </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                  {{ $attendance->keterangan ?? '-' }}
                  
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                  Tidak ada data kehadiran guru bulan ini
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($attendances->count() > 0)
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="text-sm text-gray-600">
              Total Kehadiran Guru: <span class="font-semibold">{{ $attendances->count() }} data</span>
            </div>
            <div class="text-sm text-gray-500">
              Dicetak pada : {{ now()->format('d-m-Y H:i:s') }}
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <script>
    // Menyiapkan halaman sebelum dicetak
    function beforePrint() {
      document.querySelectorAll('.hover\\:bg-gray-50').forEach(el => el.classList.remove('hover:bg-gray-50'));
      document.querySelector('.print-header').classList.remove('hidden');
    }
    
    // Mengembalikan setelah cetakan
    function afterPrint() {
      document.querySelectorAll('.hover\\:bg-gray-50').forEach(el => el.classList.add('hover:bg-gray-50'));
      document.querySelector('.print-header').classList.add('hidden');
    }
    
    // Event listeners untuk cetak
    if (window.matchMedia) {
      const mediaQueryList = window.matchMedia('print');
      mediaQueryList.addListener(mql => {
        if (mql.matches) {
          beforePrint();
        } else {
          afterPrint();
        }
      });
    }
    
    window.addEventListener('beforeprint', beforePrint);
    window.addEventListener('afterprint', afterPrint);
  </script>
</body>
</html>