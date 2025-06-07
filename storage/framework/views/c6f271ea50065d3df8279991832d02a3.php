<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <title>Tambah Event</title>
  <style>
    .form-input {
      transition: all 0.3s ease;
      background-color: #1f2937; /* bg-gray-800 */
      color: #f9fafb; /* text-white */
    }
    .form-input:focus {
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
      border-color: #3b82f6;
    }
    .form-select {
      appearance: none;
      background-color: #1f2937;
      color: #f9fafb;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23d1d5db' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 0.5rem center;
      background-repeat: no-repeat;
      background-size: 1.5em 1.5em;
    }
  </style>
</head>
<body class="bg-gray-900 text-white min-h-screen">

  <!-- Header -->
  <header class="bg-gray-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="<?php echo e(route('events.index')); ?>" class="text-gray-300 hover:text-white transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-white">Event Management</h1>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto p-4 sm:p-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-white">Tambah Event Baru</h2>
        <p class="text-sm text-gray-400">Tambahkan event baru ke dalam sistem</p>
      </div>
    </div>

    <!-- Create Form Card -->
    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
      <!-- Card Header -->
      <div class="px-6 py-4 border-b border-gray-700 bg-gradient-to-r from-gray-700 to-gray-800">
        <h3 class="text-lg font-semibold text-white">
          <i class="fas fa-calendar-plus mr-2"></i>Informasi Event
        </h3>
      </div>

      <!-- Card Body -->
      <div class="p-6">
        <!-- Error Messages -->
        <?php if($errors->any()): ?>
          <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg text-red-800">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500"></i>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium">
                  Terdapat <?php echo e($errors->count()); ?> error pada input Anda
                </h3>
                <div class="mt-2 text-sm">
                  <ul class="list-disc pl-5 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="<?php echo e(route('events.store')); ?>" method="POST" class="space-y-6">
          <?php echo csrf_field(); ?>

          <!-- Title Field -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-300 mb-1">
              Judul Event <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-heading text-gray-400"></i>
              </div>
              <input 
                type="text" 
                name="title" 
                id="title" 
                value="<?php echo e(old('title')); ?>"
                class="form-input block w-full pl-10 py-2 border border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="Masukkan judul event"
                required
              >
            </div>
          </div>

          <!-- Description Field -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-300 mb-1">
              Deskripsi <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                <i class="fas fa-align-left text-gray-400"></i>
              </div>
              <textarea 
                name="description" 
                id="description" 
                rows="4"
                class="form-input block w-full pl-10 py-2 border border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="Masukkan deskripsi event"
                required
              ><?php echo e(old('description')); ?></textarea>
            </div>
          </div>

          <!-- Date Field -->
          <div>
            <label for="date" class="block text-sm font-medium text-gray-300 mb-1">
              Tanggal Event <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-calendar-day text-gray-400"></i>
              </div>
              <input 
                type="date" 
                name="date" 
                id="date" 
                value="<?php echo e(old('date')); ?>"
                class="form-input block w-full pl-10 py-2 border border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500"
                required
              >
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex items-center justify-end pt-6 border-t border-gray-700">
            <a 
              href="<?php echo e(route('events.index')); ?>" 
              class="mr-4 inline-flex items-center px-4 py-2 border border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-200 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <i class="fas fa-times mr-2"></i> Batal
            </a>
            <button 
              type="submit"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <i class="fas fa-save mr-2"></i> Simpan Event
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\hadirin5\resources\views/events/create.blade.php ENDPATH**/ ?>