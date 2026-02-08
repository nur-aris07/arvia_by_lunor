<div class="py-4 px-6">
    <p class="text-sm font-medium text-gray-900">
        {{ optional($invitation->created_at)->format('d M Y') }}
    </p>
    <p class="text-xs text-gray-500">
        {{ optional($invitation->created_at)->diffForHumans() }}
    </p>
</div>
