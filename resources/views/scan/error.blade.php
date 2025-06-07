<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Error Presensi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  <header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="{{ route('scan.show') }}" class="text-gray-600 hover:text-gray-900 transition-colors" title="Kembali ke Scanner">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">
          Gagal Presensi
        </h1>
      </div>
    </div>
  </header>

  <main class="flex-grow max-w-2xl mx-auto p-4 w-full">
    <div class="bg-white rounded-xl shadow-md p-6 text-center">
      <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
        <h2 class="text-xl font-semibold mb-2">{{ $message }}</h2>
      </div>

      <div class="flex justify-center space-x-4">
        <a href="{{ route('scan.show') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          <i class="fas fa-qrcode mr-2"></i> Coba Lagi
        </a>
        <a href="{{ url('/') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
          <i class="fas fa-home mr-2"></i> Beranda
        </a>
      </div>
    </div>
  </main>
</body>
</html>