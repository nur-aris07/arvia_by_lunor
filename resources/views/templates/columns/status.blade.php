<div class="py-4 px-6 flex justify-center">
    @if($template->is_active)
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                     bg-emerald-50 text-emerald-700 border border-emerald-200">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
            Aktif
        </span>
    @else
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                     bg-gray-50 text-gray-700 border border-gray-200">
            <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
            Nonaktif
        </span>
    @endif
</div>
