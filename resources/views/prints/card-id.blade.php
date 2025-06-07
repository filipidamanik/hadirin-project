<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Kartu Anggota</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/davidshimjs-qrcodejs@0.0.2/qrcode.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Poppins', sans-serif;
    }
    
    @media print {
      body { 
        background-color: white;
        padding: 0;
        margin: 0;
      }
      .navigation, .no-print { 
        display: none !important; 
      }
      .id-card {
        page-break-inside: avoid;
        box-shadow: none;
        margin: 0;
        border: 1px solid #e5e7eb !important;
      }
      .hover\:shadow-lg {
        box-shadow: none !important;
      }
      @page {
        size: auto;
        margin: 5mm;
      }
    }
    
    .id-card-gradient {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }
    
    .school-logo {
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    
    /* Animation for cards */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .id-card {
      animation: fadeIn 0.3s ease-out forwards;
      opacity: 0;
    }
    
    .id-card:nth-child(1) { animation-delay: 0.1s; }
    .id-card:nth-child(2) { animation-delay: 0.2s; }
    .id-card:nth-child(3) { animation-delay: 0.3s; }
    .id-card:nth-child(4) { animation-delay: 0.4s; }
    .id-card:nth-child(5) { animation-delay: 0.5s; }
    .id-card:nth-child(n+6) { animation-delay: 0.6s; }
    
    /* Improved card styling */
    .id-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1px solid rgba(229, 231, 235, 0.8);
    }
    
    .id-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Gradient header */
    .card-header-gradient {
      background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
      height: 8px;
    }
    
    /* QR code styling */
    .qr-container {
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 8px;
      background: white;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    
    /* Print optimization */
    .print-optimized {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
      .id-card {
        margin-left: auto;
        margin-right: auto;
        max-width: 320px;
      }
      .header-buttons {
        flex-wrap: wrap;
        gap: 8px;
      }
      .header-buttons button {
        flex: 1 1 120px;
        font-size: 14px;
        padding: 8px 12px;
      }
    }
    
    @media (max-width: 400px) {
      .user-details {
        font-size: 14px;
      }
      .qr-container {
        width: 80px;
        height: 80px;
      }
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow-sm print:hidden">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors" title="Kembali ke Beranda">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">
          Cetak Kartu Anggota
        </h1>
      </div>
  </header>

  <div class="max-w-7xl mx-auto p-4 sm:p-6 print:p-2">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 print:hidden">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Kartu Anggota</h2>
          <p class="text-gray-600">Dicetak pada: <span id="print-date">{{ date('d F Y H:i') }}</span></p>
          <p class="text-sm text-gray-500 mt-1">Total: <span id="total-members">{{ count($users) }}</span> anggota</p>
        </div>
        <div class="flex flex-wrap gap-2 header-buttons">
          <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center gap-2">
            <i class="fas fa-print"></i>
            <span class="hidden sm:inline">Cetak</span> Semua
          </button>
          <button onclick="printSelected()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center gap-2">
            <i class="fas fa-print"></i>
            <span class="hidden sm:inline">Cetak</span> Terpilih
          </button>
          <button onclick="selectAllCards()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            Pilih Semua
          </button>
        </div>
      </div>
    </div>

    <!-- Cards Container -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 print:grid-cols-2 print:gap-4">
      @foreach ($users as $user)
      <div class="id-card bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-200 print-optimized">
        <!-- Card Header -->
        <div class="card-header-gradient w-full"></div>
        
        <!-- Card Content -->
        <div class="p-5">
          <!-- School Logo and Name -->
          <div class="flex justify-center items-center mb-4 gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="school-logo h-12 w-12">
            <div class="text-center">
              <h3 class="text-lg font-bold text-gray-800">{{ $user->name }}</h3>
              <p class="text-xs text-gray-500">SMKN 1 Kota Bengkulu</p>
            </div>
          </div>
          
          <div class="flex flex-col sm:flex-row gap-4 items-center">
            <!-- QR Code -->
            <div class="flex-shrink-0 mx-auto sm:mx-0">
              <div class="qr-container" id="qrcode-{{ $user->id }}"></div>
            </div>
            
            <!-- User Details -->
            <div class="flex-grow user-details">
              <div class="space-y-2">
                <div>
                  <p class="text-xs font-medium text-gray-500">ID Anggota</p>
                  <p class="text-sm font-semibold text-gray-800 font-mono">{{ $user->user_id }}</p>
                </div>
                @if($user->gender)
                <div>
                  <p class="text-xs font-medium text-gray-500">Jenis Kelamin</p>
                  <p class="text-sm text-gray-800">{{ $user->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                @endif
                @if($user->class)
                <div>
                  <p class="text-xs font-medium text-gray-500">Kelas</p>
                  <p class="text-sm text-gray-800">{{ $user->class }}</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        
        <!-- Card Footer -->
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
          <div class="flex items-center print:hidden">
            <input type="checkbox" class="card-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500" data-user-id="{{ $user->id }}">
            <label class="ml-2 text-xs text-gray-500">Pilih untuk dicetak</label>
          </div>
          <p class="text-xs text-gray-500">ID: {{ $user->id }} | {{ date('Y') }}</p>
        </div>
      </div>

      <script>
        // Generate QR code for this user
        document.addEventListener('DOMContentLoaded', function() {
          new QRCode(document.getElementById("qrcode-{{ $user->id }}"), {
            text: "{{ $user->user_id }}",
            width: 100,
            height: 100,
            colorDark: "#1f2937",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
          });
        });
      </script>
      @endforeach
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden text-center py-12">
      <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <h3 class="text-lg font-medium text-gray-900">Tidak ada kartu anggota</h3>
      <p class="mt-1 text-sm text-gray-500">Tidak ada data anggota yang tersedia untuk ditampilkan.</p>
    </div>
  </div>

  <script>
    // Check if there are any users, if not show empty state
    document.addEventListener('DOMContentLoaded', function() {
      const totalMembers = parseInt(document.getElementById('total-members').textContent);
      if (totalMembers === 0) {
        document.getElementById('empty-state').classList.remove('hidden');
      }
      
      // Update print date in real-time
      updatePrintDate();
      setInterval(updatePrintDate, 60000); // Update every minute
    });
    
    function updatePrintDate() {
      const now = new Date();
      const options = { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit' 
      };
      document.getElementById('print-date').textContent = now.toLocaleDateString('id-ID', options);
    }
    
    // Auto-print after 1 second (optional)
    window.onload = function() {
      setTimeout(function() {
        // Uncomment to enable auto-print
        // window.print();
      }, 1000);
    }
    
    // Select all cards function (toggle)
    function selectAllCards() {
      const checkboxes = document.querySelectorAll('.card-checkbox');
      const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
      
      checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
      });
      
      // Change button text based on state
      const button = document.querySelector('[onclick="selectAllCards()"]');
      const icon = button.querySelector('i');
      icon.className = allChecked ? 'fas fa-check-circle' : 'fas fa-times-circle';
    }
    
    // Print selected cards function
    function printSelected() {
      const selectedIds = [];
      document.querySelectorAll('.card-checkbox:checked').forEach(checkbox => {
        selectedIds.push(checkbox.dataset.userId);
      });
      
      if (selectedIds.length === 0) {
        alert('Silakan pilih setidaknya satu kartu untuk dicetak');
        return;
      }
      
      // Store original display values
      const originalDisplays = [];
      const cards = document.querySelectorAll('.id-card');
      cards.forEach(card => {
        originalDisplays.push(card.style.display);
      });
      
      // Hide all cards first
      cards.forEach(card => {
        card.style.display = 'none';
      });
      
      // Show only selected cards
      selectedIds.forEach(id => {
        const card = document.querySelector(`.card-checkbox[data-user-id="${id}"]`)?.closest('.id-card');
        if (card) {
          card.style.display = 'block';
        }
      });
      
      // Add a small delay before printing to ensure DOM is updated
      setTimeout(() => {
        window.print();
        
        // After printing, restore original display values
        setTimeout(() => {
          cards.forEach((card, index) => {
            card.style.display = originalDisplays[index] || '';
          });
        }, 500);
      }, 200);
    }
    
    // Handle window resize for better mobile experience
    window.addEventListener('resize', function() {
      // Adjust card layout if needed
      if (window.innerWidth < 640) {
        document.querySelectorAll('.id-card').forEach(card => {
          card.style.maxWidth = '320px';
        });
      } else {
        document.querySelectorAll('.id-card').forEach(card => {
          card.style.maxWidth = '';
        });
      }
    });
  </script>
</body>
</html>