<div class="py-4 px-6">
    <p class="text-sm text-gray-500">Harga</p>
    <p class="text-base font-semibold text-indigo-600">
        Rp {{ number_format($template->price ?? 0, 0, ',', '.') }}
    </p>
</div>
