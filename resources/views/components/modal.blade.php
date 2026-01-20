<!-- Modal Component -->
<!-- Usage: @include('components.modal', ['id' => 'modal-id', 'title' => 'Modal Title']) -->
<!-- Content goes in slot -->

<div id="{{ $id ?? 'modal' }}" class="fixed inset-0 bg-black/50 z-50 hidden flex items-end sm:items-center justify-center" @keydown.escape="closeModal('{{ $id ?? 'modal' }}')">
    <div class="bg-white dark:bg-gray-800 rounded-t-2xl sm:rounded-lg w-full sm:max-w-lg max-h-[90vh] overflow-y-auto sm:shadow-xl border border-gray-200 dark:border-gray-700 animate-slide-up">
        <!-- Modal Header -->
        <div class="sticky top-0 flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $title ?? 'Modal' }}</h2>
            <button onclick="closeModal('{{ $id ?? 'modal' }}')" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full text-gray-600 dark:text-gray-400">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="p-4">
            {{ $slot ?? '' }}
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('fixed') && event.target.classList.contains('bg-black')) {
            closeModal(event.target.id);
        }
    });
});
</script>

<style>
@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-slide-up {
    animation: slideUp 0.3s ease-out;
}
</style>
