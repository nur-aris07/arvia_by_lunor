@extends('layouts.app')

@section('title', 'Daftar User')
@section('header', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Cari user..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">Semua Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <a href="/users/add" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Tambah User</span>
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                        {{-- <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Undangan</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Terdaftar</th> --}}
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users ?? [] as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="text-sm text-gray-900">{{ $user->email }}</p>
                                <p class="text-sm text-gray-500">{{ $user->phone ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($user->role === 'admin') bg-purple-100 text-purple-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        {{-- <td class="py-4 px-6 text-center">
                            @if($user->invitation)
                                <a href="" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-check-circle"></i> Ada
                                </a>
                            @else
                                <span class="text-gray-400">
                                    <i class="fas fa-minus-circle"></i> Belum
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                        </td> --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="" class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @if(!$user->invitation)
                                    <a href="" class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Buat Undangan">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                @endif
                                @if($user->role !== 'admin')
                                    <button onclick="confirmDelete({{ $user->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                            <p>Belum ada user terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($users) && $users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Hapus User</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus user ini? Semua data terkait akan ikut terhapus.</p>
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
function confirmDelete(userId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/admin/users/${userId}`;
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection