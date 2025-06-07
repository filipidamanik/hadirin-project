<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generate ID Anggota</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
  <style>
    /* Styling untuk tombol aksi di mobile */
    @media (max-width: 640px) {
      .action-buttons {
        display: flex;
        flex-direction: row;
        gap: 0.5rem;
        justify-content: flex-end;
      }
      .action-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
      }
      .action-text {
        display: none;
      }
    }

    /* Styling untuk desktop */
    @media (min-width: 641px) {
      .action-btn {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
      }
      .action-text {
        display: inline;
        margin-left: 0.25rem;
      }
    }

    /* Styling untuk tombol floating */
    .floating-btn {
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .floating-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Styling untuk QR Code */
    .qr-container {
      width: 100px;
      height: 100px;
      margin: 0 auto;
      background: white;
      padding: 8px;
      border: 1px solid #e5e7eb;
      border-radius: 4px;
    }
    
    .modal-qr-container {
      width: 240px;
      height: 240px;
      margin: 0 auto;
      background: white;
      padding: 16px;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .modal-qr-container canvas {
      border-radius: 4px;
    }

    /* Hidden canvas for QR generation */
    #qrCanvas {
      display: none;
    }

    /* Animasi modal */
    .modal-backdrop {
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .modal-backdrop.show {
      opacity: 1;
    }

    .modal-content {
      transform: scale(0.9) translateY(-20px);
      opacity: 0;
      transition: all 0.3s ease;
    }
    
    .modal-content.show {
      transform: scale(1) translateY(0);
      opacity: 1;
    }

    /* Responsive modal */
    @media (max-width: 640px) {
      .modal-qr-container {
        width: 200px;
        height: 200px;
        padding: 12px;
      }
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors" title="Kembali ke Beranda">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">
          Generate ID Anggota
        </h1>
      </div>
    </div>
  </header>

  <div class="max-w-7xl mx-auto p-4 sm:p-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
      @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-full md:w-auto" role="alert">
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif
    </div>

    <!-- Generate Button -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
      <form action="{{ route('generate.id.process') }}" method="POST">
        @csrf
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center gap-2">
          <i class="fas fa-qrcode"></i>
          Generate ID Sekarang
        </button>
      </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-6 py-4 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Anggota</h2>
        <div class="relative w-full sm:w-64">
          <input type="text" id="searchInput" placeholder="Cari anggota..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
      </div>
      
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50 text-left">
            <tr>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Email</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                <div class="text-sm text-gray-500 sm:hidden">{{ $user->email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                {{ $user->email }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                @if($user->user_id)
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $user->user_id }}
                  </span>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($user->user_id)
                  <div class="qr-container" id="qr-{{ $user->user_id }}">
                    {!! DNS2D::getBarcodeSVG($user->user_id, 'QRCODE', 4, 4) !!}
                  </div>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                @if($user->user_id)
                  <div class="action-buttons">
                    <button
                      class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100"
                      onclick="showQRModal('{{ $user->user_id }}', '{{ $user->name }}', '{{ $user->user_id }}')"
                      type="button"
                      title="View QR Code"
                    >
                      <i class="fas fa-eye"></i>
                      <span class="action-text">View</span>
                    </button>
                    <button
                      class="action-btn bg-green-50 text-green-600 hover:bg-green-100 ml-2"
                      onclick="downloadQRCode('{{ $user->user_id }}', '{{ $user->name }}')"
                      type="button"
                      title="Download QR Code"
                    >
                      <i class="fas fa-download"></i>
                      <span class="action-text">Download</span>
                    </button>
                  </div>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- QR Code Modal -->
  <div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden modal-backdrop">
    <div class="bg-white rounded-xl w-full max-w-md mx-4 shadow-2xl modal-content">
      
      <!-- Modal Header -->
      <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <div class="flex-1">
          <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">John Doe</h3>
          <p class="text-sm text-gray-500 mt-1">QR Code ID Anggota</p>
        </div>
        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-100 rounded-full">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      
      <!-- Modal Body -->
      <div class="p-6">
        <!-- QR Code Container -->
        <div class="modal-qr-container">
          <canvas id="modalQRCanvas"></canvas>
        </div>
        
        <!-- User ID Display -->
        <div class="text-center mt-6 p-4 bg-gray-50 rounded-lg">
          <p class="text-sm font-medium text-gray-600 mb-1">User ID:</p>
          <p class="text-xl font-bold text-blue-600" id="modaluserId">USR001</p>
        </div>
      </div>
      
      <!-- Modal Footer -->
      <div class="flex justify-center p-6 pt-0">
        <button 
          id="modalDownloadBtn"
          class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition duration-300 flex items-center gap-3 shadow-lg hover:shadow-xl"
        >
          <i class="fas fa-download"></i>
          Download QR Code
        </button>
      </div>
    </div>
  </div>

  <!-- Hidden canvas for QR generation -->
  <canvas id="qrCanvas" style="display: none;"></canvas>

  <script>
    // Fungsi pencarian
    document.getElementById('searchInput').addEventListener('input', function() {
      const searchValue = this.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');
      
      rows.forEach(row => {
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const userId = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        
        if (name.includes(searchValue) || email.includes(searchValue) || userId.includes(searchValue)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });

    // Fungsi untuk menampilkan modal QR Code
    function showQRModal(userId, name, userIdText) {
      document.getElementById('modalTitle').textContent = name;
      document.getElementById('modaluserId').textContent = userIdText;
      
      // Generate QR code
      const canvas = document.getElementById('modalQRCanvas');
      generateQRCode(canvas, userId, 208); // 208px untuk pas di container 240px
      
      // Update tombol download
      const downloadBtn = document.getElementById('modalDownloadBtn');
      downloadBtn.onclick = () => downloadQRCode(userId, name);
      
      // Tampilkan modal dengan animasi
      const modal = document.getElementById('qrModal');
      const backdrop = modal;
      const content = modal.querySelector('.modal-content');
      
      modal.classList.remove('hidden');
      
      // Trigger animasi
      setTimeout(() => {
        backdrop.classList.add('show');
        content.classList.add('show');
      }, 10);
    }

    // Fungsi untuk menutup modal
    function closeModal() {
      const modal = document.getElementById('qrModal');
      const backdrop = modal;
      const content = modal.querySelector('.modal-content');
      
      backdrop.classList.remove('show');
      content.classList.remove('show');
      
      setTimeout(() => {
        modal.classList.add('hidden');
      }, 300);
    }

    // Fungsi untuk generate QR code ke canvas
    function generateQRCode(canvas, text, size) {
      const qr = qrcode(0, 'L');
      qr.addData(text);
      qr.make();
      
      const cellSize = size / qr.getModuleCount();
      const ctx = canvas.getContext('2d');
      
      canvas.width = size;
      canvas.height = size;
      
      // Background putih
      ctx.fillStyle = 'white';
      ctx.fillRect(0, 0, size, size);
      
      // Gambar QR code
      ctx.fillStyle = 'black';
      for (let row = 0; row < qr.getModuleCount(); row++) {
        for (let col = 0; col < qr.getModuleCount(); col++) {
          if (qr.isDark(row, col)) {
            ctx.fillRect(col * cellSize, row * cellSize, cellSize, cellSize);
          }
        }
      }
    }

    // Fungsi untuk download QR Code
    function downloadQRCode(userId, name) {
      const canvas = document.getElementById('qrCanvas');
      generateQRCode(canvas, userId, 512);
      
      // Konversi ke PNG dan download
      const pngUrl = canvas.toDataURL('image/png');
      const a = document.createElement('a');
      a.href = pngUrl;
      a.download = `${name.replace(/\s+/g, '_')}_${userId}_qrcode.png`;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    }

    // Close modal ketika klik di luar konten modal
    document.getElementById('qrModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeModal();
      }
    });

    // Close modal dengan ESC key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const modal = document.getElementById('qrModal');
        if (!modal.classList.contains('hidden')) {
          closeModal();
        }
      }
    });
  </script>

</body>
</html>