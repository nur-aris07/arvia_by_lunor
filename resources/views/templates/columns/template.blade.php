<div class="py-4 px-6">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200/70 overflow-hidden flex-shrink-0">
            @if($template->preview_image)
                <img src="{{ asset('uploads/' . $template->preview_image) }}"
                     alt="{{ $template->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-image text-lg"></i>
                </div>
            @endif
        </div>

        <div class="min-w-0">
            <p class="font-semibold text-gray-900 leading-tight truncate">
                {{ $template->name }}
            </p>
            <p class="text-sm text-gray-500 leading-snug line-clamp-2">
                {{ $template->description }}
            </p>
        </div>
    </div>
</div>
