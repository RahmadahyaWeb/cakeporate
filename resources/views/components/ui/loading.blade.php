<div wire:loading.flex wire:target="{{ $target ?? '' }}, gotoPage"
    class="fixed inset-0 z-[9999] bg-black/10 flex items-center justify-center text-center">
    <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
