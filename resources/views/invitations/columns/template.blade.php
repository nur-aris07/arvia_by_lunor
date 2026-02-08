<div class="py-4 px-6">
    <div class="min-w-0">
        <p class="text-sm font-semibold text-gray-900 truncate">
            {{ $invitation->template->name ?? '-' }}
        </p>
        <p class="text-xs text-gray-500">
            Rp {{ number_format($invitation->template->price ?? 0, 0, ',', '.') }}
        </p>
    </div>
</div>
