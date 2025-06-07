<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scan QR Code</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors" title="Kembali ke Beranda">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">
          Scan Presensi QR Code
        </h1>
      </div>
      <div class="flex items-center">
        <i class="fas fa-qrcode text-blue-500 text-xl"></i>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow max-w-2xl mx-auto p-4 w-full">
    <div class="bg-white rounded-xl shadow-md p-6">

      @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
          <i class="fas fa-exclamation-circle mr-2"></i>
          {{ session('error') }}
        </div>
      @endif

      <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Pemindai QR Code</h2>
        <p class="text-gray-600">Arahkan kamera ke QR Code untuk melakukan presensi</p>
      </div>

      <div class="mb-4">
        <label for="cameraSelect" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamera</label>
        <div class="flex space-x-2">
          <select id="cameraSelect" class="flex-grow p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="">-- Pilih Kamera --</option>
          </select>
          <button onclick="startScan()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <i class="fas fa-play mr-2"></i> Mulai
          </button>
        </div>
      </div>

      <div id="reader" class="border-4 border-blue-500 rounded-lg w-full max-w-md aspect-square mx-auto overflow-hidden bg-gray-100 flex items-center justify-center">
        <div class="text-center p-4 text-gray-500">
          <i class="fas fa-camera text-4xl mb-2"></i>
          <p>Kamera belum diaktifkan</p>
        </div>
      </div>

      <div id="result" class="p-4 bg-blue-50 rounded-lg border border-blue-200 text-center mb-6 mt-4">
        <div class="flex items-center justify-center space-x-2 text-blue-700">
          <i class="fas fa-qrcode"></i>
          <span>Menunggu scan QR Code...</span>
        </div>
      </div>

      <!-- Form Status Kehadiran -->
      <form id="presenceForm" method="POST" action="{{ route('scan.process') }}" class="hidden bg-white p-4 rounded-lg border border-gray-300 shadow-sm">
        @csrf
        <input type="hidden" name="user_id" id="user_id">
        
        <div class="mb-4">
          <label for="statusSelect" class="block text-sm font-medium text-gray-700 mb-2">Status Kehadiran</label>
          <select id="statusSelect" name="status" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="hadir" selected>Hadir</option>
            <option value="izin">Izin</option>
            <option value="sakit">Sakit</option>
            <option value="tidak hadir">Tidak Hadir</option>
          </select>
        </div>
        
        <div class="mb-4">
          <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan (opsional)</label>
          <textarea id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan..." class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        
        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
          <i class="fas fa-check mr-2"></i> Simpan Presensi
        </button>
      </form>

    </div>
  </main>

  <script>
    let html5QrCode;
    let isScanning = false;
    let scanInProgress = false;

    // Mendapatkan daftar kamera
    Html5Qrcode.getCameras().then(devices => {
      const select = document.getElementById("cameraSelect");
      if (devices.length === 0) {
        const option = document.createElement("option");
        option.text = "Tidak ada kamera yang ditemukan";
        option.disabled = true;
        select.appendChild(option);
      } else {
        devices.forEach((device, index) => {
          const option = document.createElement("option");
          option.value = device.id;
          option.text = device.label || `Kamera ${index + 1}`;
          select.appendChild(option);
        });
      }
    }).catch(err => {
      console.error("Gagal mendapatkan kamera:", err);
      const select = document.getElementById("cameraSelect");
      const option = document.createElement("option");
      option.text = "Gagal mengakses kamera";
      option.disabled = true;
      select.appendChild(option);
    });

    // Memulai scanning
    function startScan() {
      const camId = document.getElementById("cameraSelect").value;
      if (!camId) {
        alert("Pilih kamera terlebih dahulu");
        return;
      }

      if (isScanning) {
        stopScan();
        setTimeout(() => startScanning(camId), 500);
      } else {
        startScanning(camId);
      }
    }

    function startScanning(camId) {
      const readerElement = document.getElementById("reader");
      readerElement.innerHTML = "";
      
      html5QrCode = new Html5Qrcode("reader");
      isScanning = true;
      scanInProgress = false;

      document.getElementById("result").innerHTML = `
        <div class="flex items-center justify-center space-x-2 text-blue-700">
          <i class="fas fa-spinner fa-spin"></i>
          <span>Memindai...</span>
        </div>
      `;

      document.getElementById("presenceForm").classList.add("hidden");

      // Calculate QR box size based on container size
      const containerWidth = readerElement.offsetWidth;
      const qrboxSize = Math.min(300, containerWidth - 40); // 40px padding

      html5QrCode.start(
        camId,
        { 
          fps: 10, 
          qrbox: { width: qrboxSize, height: qrboxSize },
          aspectRatio: 1.0 // Force square aspect ratio
        },
        (decodedText) => {
          handleScanSuccess(decodedText);
        },
        (errorMessage) => {
          // Error handling
        }
      ).catch(err => {
        console.error("Gagal memulai scanner:", err);
        alert("Gagal memulai kamera");
        isScanning = false;
      });
    }

    function stopScan() {
      if (html5QrCode && isScanning) {
        html5QrCode.stop().then(() => {
          isScanning = false;
          // Show placeholder again when stopped
          document.getElementById("reader").innerHTML = `
            <div class="text-center p-4 text-gray-500">
              <i class="fas fa-camera text-4xl mb-2"></i>
              <p>Kamera belum diaktifkan</p>
            </div>
          `;
        }).catch(err => {
          console.error("Gagal menghentikan scanner:", err);
        });
      }
    }

    function handleScanSuccess(decodedText) {
      if (scanInProgress) return;
      scanInProgress = true;

      document.getElementById("result").innerHTML = `
        <div class="flex items-center justify-center space-x-2 text-green-600">
          <i class="fas fa-check-circle"></i>
          <span>QR Code berhasil dipindai</span>
        </div>
      `;

      document.getElementById("user_id").value = decodedText;
      document.getElementById("presenceForm").classList.remove("hidden");

      stopScan();
    }

    window.addEventListener('beforeunload', () => {
      if (html5QrCode && isScanning) {
        html5QrCode.stop();
      }
    });
  </script>
</body>
</html>