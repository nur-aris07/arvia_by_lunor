@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')
@section('header', 'Manajemen Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Terbayar</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($paidTotal ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $paidCount ?? 0 }} transaksi</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Belum Terbayar</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($unpaidTotal ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $unpaidCount ?? 0 }} transaksi</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Keseluruhan</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-indigo-500 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="flex items-center space-x-4">
            <div class="relative flex-1">
                <input type="text" placeholder="Cari nama user atau template..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="paid">Sudah Bayar</option>
                <option value="unpaid">Belum Bayar</option>
            </select>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Template</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Undangan</th>
                        <th class="text-right py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($invitations ?? [] as $invitation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono text-sm text-gray-600">#{{ $invitation->id }}</span>
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
                            <p class="text-sm font-medium text-gray-900">{{ $invitation->template->name }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-gray-900">{{ $invitation->title }}</p>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($invitation->template->price, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($invitation->payment_status === 'paid') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                @if($invitation->payment_status === 'paid')
                                    <i class="fas fa-check-circle mr-1"></i>Lunas
                                @else
                                    <i class="fas fa-clock mr-1"></i>Pending
                                @endif
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-gray-900">{{ $invitation->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $invitation->created_at->format('H:i') }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="/payments/datail/{{ $invitation->id }}" 
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($invitation->payment_status === 'unpaid')
                                    <form action="/payments/update/{{ $invitation->id }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="payment_status" value="paid">
                                        <button type="submit" 
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Konfirmasi Pembayaran">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="/payments/update/{{ $invitation->id }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="payment_status" value="unpaid">
                                        <button type="submit" 
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Batalkan Pembayaran">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                                <button onclick="printInvoice({{ $invitation->id }})"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-purple-100 text-purple-600 hover:bg-purple-200 transition" title="Print Invoice">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-500">
                            <i class="fas fa-money-bill-wave text-4xl mb-3 text-gray-300"></i>
                            <p>Belum ada data pembayaran</p>
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

    <!-- Payment Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Revenue -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Pendapatan Bulanan</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($monthlyRevenue ?? [] as $month)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $month->month_name }}</p>
                            <p class="text-xs text-gray-500">{{ $month->count }} transaksi</p>
                        </div>
                        <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($month->total, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Template Revenue -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Pendapatan per Template</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($templateRevenue ?? [] as $template)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $template->preview_image }}" alt="{{ $template->name }}" class="w-12 h-12 rounded object-cover">
                            <div>
                                <p class="font-medium text-gray-900">{{ $template->name }}</p>
                                <p class="text-xs text-gray-500">{{ $template->sales_count }} terjual</p>
                            </div>
                        </div>
                        <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($template->revenue, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printInvoice(invitationId) {
    window.open(`/admin/invitations/${invitationId}/invoice`, '_blank');
}
</script>
@endsection