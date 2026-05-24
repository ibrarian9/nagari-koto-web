<div>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">PPID — Informasi Dikecualikan</h2>
        <p class="text-sm text-gray-500 mt-0.5">Edit konten halaman informasi yang dikecualikan</p>
    </div>

    <form wire:submit="save" class="card p-6 space-y-4">
        <div>
            <label class="form-label">Konten Halaman</label>
            <div wire:ignore>
                <input id="dikecualikan-content" type="hidden" value="{{ $content }}">
                <trix-editor input="dikecualikan-content" class="trix-content form-input min-h-[300px]"
                    x-on:trix-change="$wire.set('content', $event.target.value)"></trix-editor>
            </div>
            @error('content')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Simpan Perubahan</span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </form>
</div>
