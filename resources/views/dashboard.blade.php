@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total User</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-3">
                <span class="text-green-600"><i class="fas fa-arrow-up"></i> 12%</span> dari bulan lalu
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Undangan Aktif</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $activeInvitations ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope-open-text text-green-500 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-3">
                <span class="text-green-600"><i class="fas fa-arrow-up"></i> 8%</span> dari bulan lalu
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pembayaran Pending</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pendingPayments ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-3">Perlu ditindaklanjuti</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-purple-500 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-3">Bulan ini</p>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Invitations -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Undangan Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentInvitations ?? [] as $invitation)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $invitation->title }}</p>
                                <p class="text-xs text-gray-500">{{ $invitation->user->name }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs rounded-full 
                            @if($invitation->status === 'active') bg-green-100 text-green-700
                            @elseif($invitation->status === 'draft') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($invitation->status) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">Belum ada undangan</p>
                    @endforelse
                </div>
                <a href="" class="block text-center mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Pembayaran Menunggu</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($pendingPaymentsList ?? [] as $payment)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $payment->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->template->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">Rp {{ number_format($payment->template->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">Tidak ada pembayaran pending</p>
                    @endforelse
                </div>
                <a href="" class="block text-center mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Template Performance -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Performa Template</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Template</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Harga</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Digunakan</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templateStats ?? [] as $template)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $template->preview_image }}" alt="{{ $template->name }}" class="w-10 h-10 rounded object-cover">
                                    <span class="font-medium text-gray-800">{{ $template->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-700">Rp {{ number_format($template->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                                    {{ $template->invitations_count }} kali
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($template->is_active) bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ $template->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">Belum ada data template</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection