<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <title>Edit Event</title>
  <style>
    .form-input {
      transition: all 0.3s ease;
    }
    .form-input:focus {
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    .form-select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
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
        <a href="{{ route('events.index') }}" class="text-gray-300 hover:text-white transition-colors">
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
        <h2 class="text-2xl font-bold text-white">Edit Event</h2>
        <p class="text-sm text-gray-300">Update event details</p>
      </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
      <!-- Card Header -->
      <div class="px-6 py-4 border-b border-gray-700 bg-gradient-to-r from-gray-700 to-gray-900">
        <h3 class="text-lg font-semibold text-white">
          <i class="fas fa-calendar-edit mr-2"></i>Event Details
        </h3>
      </div>

      <!-- Card Body -->
      <div class="p-6">
        <!-- Error Messages -->
        @if ($errors->any())
          <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg text-red-900">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500"></i>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium">
                  There were {{ $errors->count() }} errors with your submission
                </h3>
                <div class="mt-2 text-sm">
                  <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        @endif

        <!-- Form -->
        <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-300 mb-1">
              Event Title <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-heading text-gray-400"></i>
              </div>
              <input 
                type="text" 
                name="title" 
                id="title" 
                value="{{ old('title', $event->title) }}"
                class="form-input block w-full pl-10 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-gray-400 focus:border-white"
                placeholder="Enter event title"
                required
              >
            </div>
          </div>

          <!-- Description Field -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
              Description <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                <i class="fas fa-align-left text-gray-400"></i>
              </div>
              <textarea 
                name="description" 
                id="description" 
                rows="4"
                class="form-input block w-full pl-10 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-gray-400 focus:border-white"
                placeholder="Enter event description"
                required
              >{{ old('description', $event->description) }}</textarea>
            </div>
          </div>

          <!-- Date -->
          <div>
            <label for="date" class="block text-sm font-medium text-gray-300 mb-1">
              Event Date <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-calendar-day text-gray-400"></i>
              </div>
              <input 
                type="date" 
                name="date" 
                id="date" 
                value="{{ old('date', $event->date->format('Y-m-d')) }}"
                class="form-input block w-full pl-10 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-gray-400 focus:border-white"
                required
              >
            </div>
          </div>

          <!-- Buttons -->
          <div class="flex items-center justify-end pt-6 border-t border-gray-700">
            <a 
              href="{{ route('events.index') }}" 
              class="mr-4 inline-flex items-center px-4 py-2 border border-gray-500 text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
            >
              <i class="fas fa-times mr-2"></i> Cancel
            </a>
            <button 
              type="submit"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
            >
              <i class="fas fa-save mr-2"></i> Update Event
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>
</html>