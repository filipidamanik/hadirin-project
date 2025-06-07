<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <title>Event Management</title>
  <style>
    @media (max-width: 767px) {
      .mobile-hidden {
        display: none;
      }
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
      .event-title {
        font-weight: 600;
        color: #E0E0E0;
      }
    }
    @media (min-width: 768px) {
      .action-btn {
        padding: 0.4rem 0.75rem;
        border-radius: 0.375rem;
      }
      .action-text {
        display: inline;
        margin-left: 0.375rem;
      }
    }
    .floating-btn {
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5),
                  0 2px 4px -1px rgba(0, 0, 0, 0.3);
    }
    .floating-btn:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5),
                  0 4px 6px -2px rgba(0, 0, 0, 0.4);
    }
    .event-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.6);
    }
    .empty-state {
      background-color: #2C2C3E;
      border: 1px dashed #444;
    }
  </style>
</head>
<body class="bg-[#1E1E2F] min-h-screen text-[#E0E0E0]">

  <!-- Header -->
  <header class="bg-[#2C2C3E] shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="<?php echo e(url('/')); ?>" class="text-[#E0E0E0] hover:text-[#4F46E5] transition-colors">
          <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-[#E0E0E0]">Event Management</h1>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-6xl mx-auto p-4 sm:p-6">

    <!-- Search Bar -->
    <div class="mb-4 sm:mb-6">
      <form method="GET" action="<?php echo e(route('events.index')); ?>" class="w-full">
        <div class="relative">
          <input
            type="text"
            name="search"
            value="<?php echo e(request('search')); ?>"
            placeholder="Search events..."
            class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 text-sm sm:text-base rounded-lg border border-[#444] bg-[#2C2C3E] text-[#E0E0E0] placeholder-[#999] focus:outline-none focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent"
          />
          <div class="absolute left-2 sm:left-3 top-2 sm:top-2.5 text-[#999]">
            <i class="fas fa-search text-sm sm:text-base"></i>
          </div>
        </div>
      </form>
    </div>

    <?php if(session('success')): ?>
      <div class="mb-4 p-3 bg-green-600 text-white rounded-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-[#2C2C3E] rounded-lg shadow overflow-hidden">
      <div class="grid grid-cols-12 bg-[#1E1E2F] px-4 py-3 border-b border-[#444] text-[#E0E0E0] font-medium text-sm uppercase tracking-wider">
        <div class="col-span-1">No</div>
        <div class="col-span-3">Title</div>
        <div class="col-span-4">Description</div>
        <div class="col-span-2">Date</div>
        <div class="col-span-2 text-right">Actions</div>
      </div>

      <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="grid grid-cols-12 px-4 py-3 border-b border-[#333] hover:bg-[#3A3A4F] items-center transition-colors">
          <div class="col-span-1 text-[#AAA]"><?php echo e($loop->iteration); ?></div>
          <div class="col-span-3 font-medium truncate"><?php echo e($event->title); ?></div>
          <div class="col-span-4 text-sm truncate"><?php echo e($event->description); ?></div>
          <div class="col-span-2 text-sm text-[#CCC]">
            <?php echo e(\Carbon\Carbon::parse($event->date)->format('d M Y')); ?>

          </div>
          <div class="col-span-2 flex justify-end">
            <div class="action-buttons">
              <a href="<?php echo e(route('events.edit', $event->id)); ?>"
                 class="action-btn bg-[#4F46E5] text-white hover:bg-[#6C63FF] transition-colors"
                 title="Edit">
                <i class="fas fa-edit"></i>
                <span class="action-text">Edit</span>
              </a>
              <form action="<?php echo e(route('events.destroy', $event->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?')" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        class="action-btn bg-red-600 text-white hover:bg-red-700 transition-colors"
                        title="Delete">
                  <i class="fas fa-trash-alt"></i>
                  <span class="action-text">Delete</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state px-4 py-8 text-center rounded-lg">
          <i class="fas fa-calendar-times text-4xl mb-3 text-[#666]"></i>
          <p class="text-[#AAA] font-medium">No events found</p>
          <p class="text-[#888] text-sm mt-1">Create your first event by clicking the + button</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
      <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="event-card bg-[#2C2C3E] rounded-lg shadow p-4 transition-all">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="event-title"><?php echo e($event->title); ?></h3>
              <p class="text-[#CCC] text-sm mt-1">
                <i class="far fa-calendar-alt mr-1"></i>
                <?php echo e(\Carbon\Carbon::parse($event->date)->format('d M Y')); ?>

              </p>
            </div>
            <div class="action-buttons">
              <a href="<?php echo e(route('events.edit', $event->id)); ?>"
                 class="action-btn bg-[#4F46E5] text-white hover:bg-[#6C63FF] transition-colors"
                 title="Edit">
                <i class="fas fa-edit text-sm"></i>
              </a>
              <form action="<?php echo e(route('events.destroy', $event->id)); ?>" method="POST" onsubmit="return confirm('Delete this event?')" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        class="action-btn bg-red-600 text-white hover:bg-red-700 transition-colors"
                        title="Delete">
                  <i class="fas fa-trash-alt text-sm"></i>
                </button>
              </form>
            </div>
          </div>
          <?php if($event->description): ?>
            <p class="text-[#DDD] text-sm mt-2 line-clamp-2"><?php echo e($event->description); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state px-4 py-8 text-center rounded-lg">
          <i class="fas fa-calendar-times text-3xl mb-3 text-[#666]"></i>
          <p class="text-[#AAA] font-medium">No events found</p>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- Floating Add Event Button -->
  <a href="<?php echo e(route('events.create')); ?>" 
     class="floating-btn fixed bottom-5 right-5 bg-[#4F46E5] text-white rounded-full p-4 hover:bg-[#6C63FF] transition duration-200"
     title="Add Event">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
         stroke-linecap="round" stroke-linejoin="round">
      <line x1="12" y1="5" x2="12" y2="19"></line>
      <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    <span class="sr-only">Add Event</span>
  </a>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\hadirin5\resources\views/events/index.blade.php ENDPATH**/ ?>