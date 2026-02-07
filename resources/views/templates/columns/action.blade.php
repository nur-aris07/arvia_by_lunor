<div class="py-4 px-6">
    <div class="flex items-center justify-center gap-2">
        <a href="javascript:void(0)" class="w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition" title="Detail">
            <i class="fas fa-eye text-[14px]"></i>
        </a>

        <a href="javascript:void(0)" class="edit-btn w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-amber-600 hover:bg-amber-50 hover:border-amber-200 transition" title="Edit" data-id="{{ $template->hash_id }}" data-name="{{ $template->name }}" data-slug="{{ $template->slug }}" data-price="{{ $template->price }}" data-image="{{ $template->preview_image }}" data-description="{{ $template->description }}" data-status="{{ $template->is_active }}">
            <i class="fas fa-pencil-alt text-[14px]"></i>
        </a>

        {{-- @if(($template->invitations_count ?? 0) == 0) --}}
            <button type="button" class="delete-btn w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-red-600 hover:bg-red-50 hover:border-red-200 transition" title="Hapus" data-id="{{ $template->hash_id }}">
                <i class="fas fa-trash-alt text-[14px]"></i>
            </button>
        {{-- @else
            <button type="button" class="w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-gray-400 cursor-not-allowed" title="Tidak bisa dihapus (sedang digunakan)" disabled>
                <i class="fas fa-lock text-[14px]"></i>
            </button>
        @endif --}}
    </div>
</div>
