<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <title>User Management</title>
  <style>
    /* Action buttons styling for mobile */
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

    /* Desktop styles */
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

    /* Floating button styles */
    .floating-btn {
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .floating-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">User Management</h1>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-3xl mx-auto p-4 sm:p-6">
    <!-- Search Bar -->
    <div class="mb-4 sm:mb-6">
      <form method="GET" action="{{ route('users.index') }}" class="w-full">
        <div class="relative">
          <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search users..."
            class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 text-sm sm:text-base rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <div class="absolute left-2 sm:left-3 top-2 sm:top-2.5 text-gray-400">
            <i class="fas fa-search text-sm sm:text-base"></i>
          </div>
        </div>
      </form>
    </div>

    <!-- User List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <!-- Table Header -->
      <div class="grid grid-cols-12 bg-gray-50 px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-200 text-gray-600 font-medium text-xs sm:text-sm uppercase tracking-wider">
        <div class="col-span-1">No</div>
        <div class="col-span-7 sm:col-span-8">Name</div>
        <div class="col-span-4 sm:col-span-3 text-right">Actions</div>
      </div>
      
      <!-- User Rows -->
      @forelse ($users as $user)
        <div class="grid grid-cols-12 px-3 sm:px-4 py-3 sm:py-3 border-b border-gray-100 hover:bg-gray-50 items-center transition-colors">
          <div class="col-span-1 text-gray-500 text-sm sm:text-base">
            {{ $loop->iteration}}
          </div>
          <div class="col-span-7 sm:col-span-8 font-medium text-gray-800 flex items-center text-sm sm:text-base">
            <span class="truncate">{{ $user->name }}</span>
          </div>
          <div class="col-span-4 sm:col-span-3 flex justify-end">
            <div class="action-buttons">
              <a href="{{ route('users.edit', $user->id) }}" 
                 class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                 title="Edit">
                <i class="fas fa-edit text-sm"></i>
                <span class="action-text text-sm">Edit</span>
              </a>
              <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="action-btn bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                        title="Delete" 
                        onclick="return confirm('Are you sure you want to delete this user?')">
                  <i class="fas fa-trash-alt text-sm"></i>
                  <span class="action-text text-sm">Delete</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="px-4 py-6 text-center text-gray-500">
          <i class="fas fa-users-slash text-2xl sm:text-3xl mb-2 text-gray-300"></i>
          <p class="text-sm sm:text-base">No users found</p>
        </div>
      @endforelse
    </div>
  </main>

  <!-- Floating Add Button -->
  <a href="{{ route('users.create') }}" 
     class="floating-btn fixed bottom-5 right-5 bg-blue-600 text-white rounded-full p-4 hover:bg-blue-700 transition duration-200"
     title="Add User">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="12" y1="5" x2="12" y2="19"></line>
      <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    <span class="sr-only">Add User</span>
  </a>

</body>
</html>