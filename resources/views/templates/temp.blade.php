@extends('layouts.app')

@section('title', 'Daftar Template')
@section('header', 'Manajemen Template')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Cari template..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Nonaktif</option>
            </select>
        </div>
        <a href="/templates/add" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Template</span>
        </a>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates ?? [] as $template)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition group">
            <!-- Preview Image -->
            <div class="relative h-48 bg-gray-200 overflow-hidden">
                @if($template->preview_image)
                    <img src="{{ $template->preview_image }}" alt="{{ $template->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                @endif
                
                <!-- Status Badge -->
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 rounded-full text-xs font-medium backdrop-blur-sm
                        @if($template->is_active) bg-green-100/90 text-green-700
                        @else bg-gray-100/90 text-gray-700
                        @endif">
                        {{ $template->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <!-- Usage Count -->
                <div class="absolute bottom-3 left-3">
                    <span class="px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-medium text-gray-700">
                        <i class="fas fa-users mr-1"></i>{{ $template->invitations_count ?? 0 }} digunakan
                    </span>
                </div>
            </div>

            <!-- Template Info -->
            <div class="p-5">
                <div class="mb-3">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $template->name }}</h3>
                    <p class="text-sm text-gray-500 line-clamp-2">{{ $template->description }}</p>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Harga</p>
                        <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($template->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Fields</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $template->fields_count ?? 0 }} field</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.templates.show', $template->id) }}" 
                        class="flex-1 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-center text-sm font-medium text-gray-700">
                        <i class="fas fa-eye mr-1"></i>Detail
                    </a>
                    <a href="{{ route('admin.templates.edit', $template->id) }}" 
                        class="w-10 h-10 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    @if($template->invitations_count == 0)
                        <button onclick="confirmDelete({{ $template->id }})" 
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    @else
                        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" title="Tidak bisa dihapus (sedang digunakan)">
                            <i class="fas fa-lock"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 py-16 text-center">
            <i class="fas fa-palette text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada template</p>
            <a href="/templates/add" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Buat Template Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($templates) && $templates->hasPages())
    <div class="flex justify-center">
        {{ $templates->links() }}
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Hapus Template</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus template ini? Semua field yang terkait akan ikut terhapus.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(templateId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/admin/templates/${templateId}`;
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection