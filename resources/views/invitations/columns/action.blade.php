<div class="py-4 px-6">
    <div class="flex items-center justify-center gap-2">
        <a href="javascript:void(0)"
           class="detail-btn w-9 h-9 inline-flex items-center justify-center rounded-xl
                  bg-gray-50 border border-gray-200/70 text-blue-600
                  hover:bg-blue-50 hover:border-blue-200 transition"
           title="Detail">
            <i class="fas fa-eye text-[14px]"></i>
        </a>

        <a href="javascript:void(0)"
           class="edit-btn w-9 h-9 inline-flex items-center justify-center rounded-xl
                  bg-gray-50 border border-gray-200/70 text-amber-600
                  hover:bg-amber-50 hover:border-amber-200 transition"
           title="Edit">
            <i class="fas fa-pencil-alt text-[14px]"></i>
        </a>

        @if(($invitation->payment_status ?? 'unpaid') === 'unpaid')
            <button type="button"
                class="inv-pay-btn w-9 h-9 inline-flex items-center justify-center rounded-xl
                       bg-gray-50 border border-gray-200/70 text-emerald-600
                       hover:bg-emerald-50 hover:border-emerald-200 transition"
                title="Tandai Lunas"
                data-id="{{ $invitation->id }}"
                data-status="paid">
                <i class="fas fa-check text-[14px]"></i>
            </button>
        @endif

        <a href="{{ url($invitation->slug) }}" target="_blank"
           class="w-9 h-9 inline-flex items-center justify-center rounded-xl
                  bg-gray-50 border border-gray-200/70 text-purple-600
                  hover:bg-purple-50 hover:border-purple-200 transition"
           title="Preview">
            <i class="fas fa-external-link-alt text-[14px]"></i>
        </a>

        <button type="button"
            class="delete-btn inv-delete-btn w-9 h-9 inline-flex items-center justify-center rounded-xl
                   bg-gray-50 border border-gray-200/70 text-red-600
                   hover:bg-red-50 hover:border-red-200 transition"
            title="Hapus"
            data-id="{{ $invitation->id }}">
            <i class="fas fa-trash-alt text-[14px]"></i>
        </button>
    </div>
</div>
