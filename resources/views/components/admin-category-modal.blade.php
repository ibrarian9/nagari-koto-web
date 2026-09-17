@props([
    'show' => false,
    'title' => 'Kelola Kategori',
    'subtitle' => 'Tambah, ubah, atau hapus kategori',
    'categories' => [],
    'editingCategoryId' => null,
    'editingCategoryName' => '',
    'newCategoryName' => '',
    'icon' => 'category',
    'iconBg' => 'bg-indigo-100',
    'iconColor' => 'text-indigo-600',
])

<x-admin-modal 
    :show="$show" 
    :title="$title" 
    :subtitle="$subtitle" 
    :icon="$icon" 
    :iconBg="$iconBg" 
    :iconColor="$iconColor" 
    maxWidth="max-w-xl"
    closeProperty="showCategoryModal"
>
    <div class="space-y-4">
        {{-- Form Tambah Kategori Baru --}}
        <div class="flex items-center gap-2">
            <input type="text" wire:model="newCategoryName" wire:keydown.enter="addCategory" class="form-input flex-1 text-sm" placeholder="Nama kategori baru...">
            <button wire:click="addCategory" type="button" class="btn-primary btn-sm whitespace-nowrap"><span class="material-symbols-outlined text-base">add</span> Tambah</button>
        </div>
        @error('newCategoryName')<p class="form-error">{{ $message }}</p>@enderror

        {{-- List Kategori --}}
        <div class="border border-gray-150 rounded-xl overflow-hidden max-h-60 overflow-y-auto divide-y divide-gray-100">
            @forelse($categories as $cat)
                <div class="flex items-center justify-between px-4 py-2.5 hover:bg-gray-50 transition-colors">
                    @if($editingCategoryId === $cat->id)
                        {{-- Edit mode --}}
                        <div class="flex items-center gap-2 flex-1 mr-2">
                            <input type="text" wire:model="editingCategoryName" wire:keydown.enter="updateCategory" class="form-input text-xs py-1 flex-1">
                            <button type="button" wire:click="updateCategory" class="text-emerald-600 hover:text-emerald-700 text-xs font-bold">Simpan</button>
                            <button type="button" wire:click="cancelEditCategory" class="text-gray-400 hover:text-gray-600 text-xs">Batal</button>
                        </div>
                    @else
                        {{-- Normal mode --}}
                        <span class="text-sm font-medium text-gray-800">{{ $cat->name }}</span>
                        <div class="flex items-center gap-1">
                            <button type="button" wire:click="editCategory({{ $cat->id }})" class="p-1 text-gray-400 hover:text-desa-600 rounded transition-colors" title="Edit Kategori">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </button>
                            <button type="button" onclick="confirmAction({{ $cat->id }}, 'deleteCategoryConfirmed', 'Yakin ingin menghapus kategori ini?')" class="p-1 text-gray-400 hover:text-red-600 rounded transition-colors" title="Hapus Kategori">
                                <span class="material-symbols-outlined text-base">delete</span>
                            </button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-6 text-center text-gray-400 text-xs">Belum ada kategori.</div>
            @endforelse
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-end pt-3 border-t border-gray-100">
            <button type="button" wire:click="$set('showCategoryModal', false)" class="btn-secondary">Tutup</button>
        </div>
    </div>
</x-admin-modal>
