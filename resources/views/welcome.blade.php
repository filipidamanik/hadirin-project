<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Sistem Pengelola Kehadiran SMKN 1 Kota Bengkulu">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        fontFamily: {
          sans: ['Poppins', 'sans-serif'],
        },
        extend: {
          colors: {
            primary: {
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a',
            },
            secondary: {
              400: '#fbbf24',
            }
          },
          boxShadow: {
            'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
            'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
          },
          animation: {
            'fade-in': 'fadeIn 0.3s ease-in-out',
            'slide-up': 'slideUp 0.3s ease-out'
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' }
            },
            slideUp: {
              '0%': { transform: 'translateY(20px)' },
              '100%': { transform: 'translateY(0)' }
            }
          }
        }
      }
    }
  </script>
  <script src="https://unpkg.com/feather-icons"></script>
  <title>Hadirin - Sistem Kehadiran SMKN 1 Kota Bengkulu</title>
  <style>
    @media (max-width: 640px) {
      .header-height {
        height: auto;
        min-height: 18rem;
      }
      
      .card-square {
        aspect-ratio: 1/1;
      }
      
      .card-rectangle {
        aspect-ratio: 2/1;
      }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen antialiased">

  <!-- Header -->
  <header class="w-full header-height rounded-b-3xl bg-gradient-to-br from-primary-800 to-primary-900 px-6 py-8 md:px-8 md:py-10 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10">
      <div class="absolute top-10 left-20 w-32 h-32 rounded-full bg-white"></div>
      <div class="absolute bottom-10 right-20 w-24 h-24 rounded-full bg-secondary-400"></div>
      <div class="absolute top-1/3 right-1/4 w-16 h-16 rounded-full bg-white"></div>
    </div>
    
    <div class="relative z-10 max-w-6xl mx-auto">
      <div class="flex justify-between items-start">
      <div class="text-white font-bold text-xl">HADIRIN</div>
      <div class="flex space-x-2">
        <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
        <div class="w-4 h-4 bg-red-300 rounded-full"></div>
      </div>
    </div>

    <div class="text-white text-center mt-6 md:mt-8">
      <div class="mx-auto w-20 h-20 md:w-24 md:h-24">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 1 Kota Bengkulu" class="w-full h-full object-contain" />
      </div>
      <h1 class="text-2xl md:text-3xl font-bold tracking-tight">SMKN 1</h1>
      <p class="text-lg md:text-xl text-blue-100">Kota Bengkulu</p>
    </div>

      <nav class="flex justify-center mt-6 md:mt-8 space-x-2 md:space-x-4 lg:space-x-6">
        <button id="b1" onclick="switchTab(1)" class="text-white font-medium md:font-bold text-sm md:text-base px-3 py-1 md:px-4 md:py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center">
          <i data-feather="tool" class="mr-1 md:mr-2 w-4 h-4 md:w-5 md:h-5"></i> Tools
        </button>
        <button id="b2" onclick="switchTab(2)" class="text-white font-medium md:font-bold text-sm md:text-base px-3 py-1 md:px-4 md:py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center">
          <i data-feather="printer" class="mr-1 md:mr-2 w-4 h-4 md:w-5 md:h-5"></i> Prints
        </button>
        <button id="b3" onclick="switchTab(3)" class="text-white font-medium md:font-bold text-sm md:text-base px-3 py-1 md:px-4 md:py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center">
          <i data-feather="info" class="mr-1 md:mr-2 w-4 h-4 md:w-5 md:h-5"></i> Info
        </button>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="px-4 py-6 md:px-8 md:py-10 max-w-6xl mx-auto transition-all duration-300">

    <!-- Tools Tab -->
    <div id="tab1" class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6 transition-opacity duration-300">
      <!-- Card 1 -->
      <a href="/users" class="card-square bg-white rounded-xl shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-200 group overflow-hidden border border-gray-100 animate-fade-in animate-slide-up">
        <div class="h-full p-4 md:p-6 flex flex-col">
          <div class="w-10 h-10 md:w-14 md:h-14 rounded-lg bg-blue-50 mb-3 md:mb-4 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200 mx-auto">
            <img src="https://img.icons8.com/ios-filled/50/1e40af/add-user-group-man-man.png" class="w-6 h-6 md:w-8 md:h-8" alt="Input Anggota" />
          </div>
          <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-1 text-center">Input Anggota</h3>
          <p class="text-xs text-gray-500 text-center mt-auto">Tambah atau edit data anggota</p>
        </div>
      </a>
      
      <!-- Card 2 -->
      <a href="/events" class="card-square bg-white rounded-xl shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-200 group overflow-hidden border border-gray-100 animate-fade-in animate-slide-up">
        <div class="h-full p-4 md:p-6 flex flex-col">
          <div class="w-10 h-10 md:w-14 md:h-14 rounded-lg bg-blue-50 mb-3 md:mb-4 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200 mx-auto">
            <img src="https://img.icons8.com/ios-filled/50/1e40af/edit-calendar.png" class="w-6 h-6 md:w-8 md:h-8" alt="Input Kegiatan" />
          </div>
          <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-1 text-center">Input Kegiatan</h3>
          <p class="text-xs text-gray-500 text-center mt-auto">Kelola jadwal kegiatan</p>
        </div>
      </a>
      
      <!-- Card 3 -->
      <a href="{{ route('generate.id.show') }}" class="card-square bg-white rounded-xl shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-200 group overflow-hidden border border-gray-100 animate-fade-in animate-slide-up">
        <div class="h-full p-4 md:p-6 flex flex-col">
          <div class="w-10 h-10 md:w-14 md:h-14 rounded-lg bg-blue-50 mb-3 md:mb-4 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200 mx-auto">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSIzMiIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiMxZTQwYWYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1pZC1jYXJkLWljb24gbHVjaWRlLWlkLWNhcmQiPjxwYXRoIGQ9Ik0xNiAxMGgyIi8+PHBhdGggZD0iTTE2IDE0aDIiLz48cGF0aCBkPSJNNi4xNyAxNWEzIDMgMCAwIDEgNS42NiAwIi8+PGNpcmNsZSBjeD0iOSIgY3k9IjExIiByPSIyIi8+PHJlY3QgeD0iMiIgeT0iNSIgd2lkdGg9IjIwIiBoZWlnaHQ9IjE0IiByeD0iMiIvPjwvc3ZnPg==" class="w-6 h-6 md:w-8 md:h-8" alt="Generate ID" />
          </div>
          <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-1 text-center">Generate ID</h3>
          <p class="text-xs text-gray-500 text-center mt-auto">Buat kartu identitas</p>
        </div>
      </a>
      
      <!-- Card 4 -->
      <a href="{{ route('scan.show') }}" class="card-square bg-white rounded-xl shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-200 group overflow-hidden border border-gray-100 animate-fade-in animate-slide-up">
        <div class="h-full p-4 md:p-6 flex flex-col">
          <div class="w-10 h-10 md:w-14 md:h-14 rounded-lg bg-blue-50 mb-3 md:mb-4 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200 mx-auto">
            <i data-feather="maximize" class="w-6 h-6 md:w-8 md:h-8 text-blue-800"></i>
          </div>
          <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-1 text-center">Scan Kehadiran</h3>
          <p class="text-xs text-gray-500 text-center mt-auto">Scan QR code presensi</p>
        </div>
      </a>
    </div>

    <!-- Prints Tab -->
<div id="tab2" class="hidden grid grid-cols-1 gap-3 sm:gap-4 md:gap-6 transition-opacity duration-300">
  <!-- Rectangle Card (Full width) -->
  <a href="{{ route('print.harian') }}" class="bg-white rounded-xl shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-200 group overflow-hidden border border-gray-100 animate-fade-in animate-slide-up">
    <div class="h-full p-4 md:p-6 flex flex-col items-center justify-center">
      <div class="w-10 h-10 md:w-14 md:h-14 rounded-lg bg-blue-50 mb-3 md:mb-4 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200">
        <i data-feather="calendar" class="w-6 h-6 md:w-8 md:h-8 text-blue-800"></i>
      </div>
      <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-1 text-center">Print Kehadiran Harian</h3>
      <p class="text-xs text-gray-500 text-center">Laporan kehadiran harian</p>
    </div>
  </a>
  
  <!-- Bottom Row - 2 Square Cards -->
  <div class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6">
    <!-- Square Card 1 -->
    <a href="{{ route('print.bulanan') }}" class="card-square bg-white rounded-xl shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-200 group overflow-hidden border border-gray-100 animate-fade-in animate-slide-up">
      <div class="h-full p-4 md:p-6 flex flex-col">
        <div class="w-10 h-10 md:w-14 md:h-14 rounded-lg bg-blue-50 mb-3 md:mb-4 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200 mx-auto">
          <i data-feather="calendar" class="w-6 h-6 md:w-8 md:h-8 text-blue-800"></i>
        </div>
        <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-1 text-center">Print Kehadiran Bulanan</h3>
        <p class="text-xs text-gray-500 text-center mt-auto">Laporan kehadiran bulanan</p>
      </div>
    </a>
    
    <!-- Square Card 2 -->
    <a href="{{ route('print.card.id') }}" class="card-square bg-white rounded-xl shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-200 group overflow-hidden border border-gray-100 animate-fade-in animate-slide-up">
      <div class="h-full p-4 md:p-6 flex flex-col">
        <div class="w-10 h-10 md:w-14 md:h-14 rounded-lg bg-blue-50 mb-3 md:mb-4 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200 mx-auto">
          <img src="https://img.icons8.com/ios-filled/50/1e40af/print.png" class="w-6 h-6 md:w-8 md:h-8" alt="Print ID" />
        </div>
        <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-1 text-center">Print Semua ID</h3>
        <p class="text-xs text-gray-500 text-center mt-auto">Cetak semua kartu identitas</p>
      </div>
    </a>
  </div>
</div>

    <!-- Info Tab -->
    <div id="tab3" class="hidden transition-opacity duration-300 animate-fade-in">
      <div class="bg-white rounded-xl shadow-card p-6 md:p-8">
        <div class="flex items-center mb-4 md:mb-6">
          <i data-feather="info" class="w-6 h-6 md:w-8 md:h-8 text-blue-800 mr-2 md:mr-3"></i>
          <h2 class="text-xl md:text-2xl font-bold text-gray-800">Tentang Hadirin</h2>
        </div>
        
        <div class="space-y-3 md:space-y-4">
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
              <div class="w-2 h-2 rounded-full bg-blue-800"></div>
            </div>
            <p class="ml-3 text-gray-700 text-sm md:text-base">
              <span class="font-semibold">Hadirin</span> merupakan sebuah sistem pengelola kehadiran dalam lingkungan sekolah.
            </p>
          </div>
          
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
              <div class="w-2 h-2 rounded-full bg-blue-800"></div>
            </div>
            <p class="ml-3 text-gray-700 text-sm md:text-base">
              Dengan desain minimalis dan sederhana, Hadirin mampu mengakomodasi 
              kebutuhan pencatatan kehadiran masyarakat sekolah dalam berbagai situasi.
            </p>
          </div>
          
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
              <div class="w-2 h-2 rounded-full bg-blue-800"></div>
            </div>
            <p class="ml-3 text-gray-700 text-sm md:text-base">
              Pengembangan sistem ini didukung sepenuhnya secara swadaya, sebagai
              produk hibah dari Guru Produktif Jurusan PPLG SMKN 1 Kota Bengkulu.
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    function switchTab(id) {
      // Hide all tabs
      for (let i = 1; i <= 3; i++) {
        document.getElementById('tab' + i).classList.add('hidden');
        document.getElementById('b' + i).classList.remove('bg-blue-700', 'shadow-md');
      }
      
      // Show selected tab
      document.getElementById('tab' + id).classList.remove('hidden');
      document.getElementById('b' + id).classList.add('bg-blue-700', 'shadow-md');
      
      // Store selected tab in sessionStorage
      sessionStorage.setItem('selectedTab', id);
    }

    // Initialize feather icons
    feather.replace();
    
    // Set initial tab from sessionStorage or default to 1
    document.addEventListener('DOMContentLoaded', () => {
      const selectedTab = sessionStorage.getItem('selectedTab') || 1;
      switchTab(selectedTab);
      
      // Add animation delay to cards
      const cards = document.querySelectorAll('[id^="tab"] a');
      cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 50}ms`;
      });
    });
  </script>
</body>
</html>