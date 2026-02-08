@extends('layouts.app')

@section('title', 'Daftar Undangan')
@section('header', 'Manajemen Undangan')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Cari undangan..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="active">Aktif</option>
                <option value="archived">Arsip</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">Semua Pembayaran</option>
                <option value="unpaid">Belum Bayar</option>
                <option value="paid">Sudah Bayar</option>
            </select>
        </div>
        <a href="/invitations/add" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Buat Undangan</span>
        </a>
    </div>

    <!-- Invitations Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Undangan</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Template</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Pembayaran</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Dibuat</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($invitations ?? [] as $invitation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <div>
                                <p class="font-medium text-gray-900">{{ $invitation->title }}</p>
                                <p class="text-sm text-gray-500">{{ $invitation->slug }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-semibold">
                                    {{ strtoupper(substr($invitation->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $invitation->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $invitation->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $invitation->template->name }}</p>
                                <p class="text-xs text-gray-500">Rp {{ number_format($invitation->template->price, 0, ',', '.') }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($invitation->status === 'active') bg-green-100 text-green-700
                                @elseif($invitation->status === 'draft') bg-yellow-100 text-yellow-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($invitation->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($invitation->payment_status === 'paid') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                @if($invitation->payment_status === 'paid')
                                    <i class="fas fa-check-circle mr-1"></i>Lunas
                                @else
                                    <i class="fas fa-exclamation-circle mr-1"></i>Belum Bayar
                                @endif
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-gray-900">{{ $invitation->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $invitation->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.invitations.show', $invitation->id) }}" 
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.invitations.edit', $invitation->id) }}" 
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @if($invitation->payment_status === 'unpaid')
                                    <button onclick="updatePayment({{ $invitation->id }}, 'paid')" 
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Tandai Lunas">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                                <a href="{{ url($invitation->slug) }}" target="_blank"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-purple-100 text-purple-600 hover:bg-purple-200 transition" title="Preview">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <button onclick="confirmDelete({{ $invitation->id }})" 
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-500">
                            <i class="fas fa-envelope-open-text text-4xl mb-3 text-gray-300"></i>
                            <p>Belum ada undangan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($invitations) && $invitations->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $invitations->links() }}
        </div>
        @endif
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Undangan Aktif</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Draft</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['draft'] ?? 0 }}</p>
                </div>
                <i class="fas fa-edit text-yellow-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Belum Bayar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['unpaid'] ?? 0 }}</p>
                </div>
                <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Arsip</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['archived'] ?? 0 }}</p>
                </div>
                <i class="fas fa-archive text-gray-500 text-2xl"></i>
            </div>
        </div>
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
                <h3 class="text-lg font-semibold text-gray-900">Hapus Undangan</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus undangan ini? Semua data terkait akan ikut terhapus.</p>
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
function confirmDelete(invitationId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/admin/invitations/${invitationId}`;
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function updatePayment(invitationId, status) {
    if (confirm('Tandai pembayaran sebagai lunas?')) {
        fetch(`/admin/invitations/${invitationId}/payment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ payment_status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection