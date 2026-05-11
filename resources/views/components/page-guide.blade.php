@props(['title', 'description'])

<div class="mb-6 rounded-xl border border-blue-100 bg-blue-50/50 p-4">
    <div class="flex items-start gap-3">
        <span class="material-symbols-outlined text-blue-500 mt-0.5">help</span>
        <div class="text-sm text-blue-800">
            <p class="font-semibold mb-1">{{ $title }}</p>
            <p class="text-blue-600 text-xs leading-relaxed">{{ $description }}</p>
        </div>
    </div>
</div>
