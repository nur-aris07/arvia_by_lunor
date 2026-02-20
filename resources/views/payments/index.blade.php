@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')
@section('header', 'Manajemen Pembayaran')
@section('context', 'Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Terbayar</p>
                    <p class="text-2xl font-bold text-gray-800">Rp <span id="paidTotal">-</span></p>
                    <p class="text-xs text-gray-500 mt-1"><span id="paidCount">-</span> transaksi</p>
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
                    <p class="text-2xl font-bold text-gray-800">Rp <span id="unpaidTotal">-</span></p>
                    <p class="text-xs text-gray-500 mt-1"><span id="unpaidCount">-</span> transaksi</p>
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
                    <p class="text-2xl font-bold text-gray-800">Rp <span id="totalRevenue">-</span></p>
                    <p class="text-xs text-gray-500 mt-1">Keseluruhan</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-indigo-500 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="relative flex-1">
                <input id="search" type="text" placeholder="Cari pembayaran..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select id="filter-method" class="px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                <option value="">Semua Method</option>
                <option value="transfer">Transfer</option>
                <option value="cash">Cash</option>
                <option value="qris">QRIS</option>
            </select>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-2xl border border-gray-200/70 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="table" class="w-full">
                <thead class="bg-gray-50/70 border-b border-gray-200/70">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Invoice</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Undangan</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Metode</th>
                        <th class="text-right py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Nominal</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/70"></tbody>
            </table>
        </div>
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
@push('scripts')
    <script>
        $(function () {
            let table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paging: true,
                info: true,
                lengthChange: false,
                autoWidth: false,
                pageLength: 5,
                dom: 'rt<"dt-footer flex w-full items-center justify-between px-6 py-4 border-t border-gray-200"ip>',
                ajax: {
                    url: "{{ route('payments.index') }}",
                    data: function (d) {
                        d.search = $('#search').val();
                        d.method = $('#filter-method').val();
                        // d.payment = $('#filter-payment').val();
                    }
                },
                columns: [
                    { data: 'invoice', name: 'invoice', orderable: true },
                    { data: 'undangan', name: 'undangan', orderable: true },
                    { data: 'method', name: 'method', orderable: true },
                    { data: 'amount', name: 'amount', orderable: true },
                    { data: 'status', name: 'status', orderable: true },
                    { data: 'waktu', name: 'waktu', orderable: true },
                    { data: 'action', orderable: false, searchable: false },
                ],
                language: {
                    info: "Showing _START_ to _END_ of _TOTAL_ results",
                    infoEmpty: "Showing 0 to 0 of 0 results",
                    emptyTable: `
                        <div class="py-12 text-center text-gray-500">
                            <p>Tidak Ada Data Ditemukan</p>
                        </div>
                    `,
                    paginate: {
                        previous: '<i class="fas fa-chevron-left"></i>',
                        next: '<i class="fas fa-chevron-right"></i>',
                    }
                }
            });

            function debounce(fn, delay = 350) {
                let t;
                return function (...args) {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, args), delay);
                };
            }

            $('#search').on('input', debounce(function () {
                table.draw();
            }, 350));

            $('#filter-method').on('change', function () {
                table.draw();
            });

            // $('#filter-payment').on('change', function () {
            //     table.draw();
            // });
        });
        
        document.addEventListener('DOMContentLoaded', () => {
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }
    
            function loadStats() {
                $.ajax({
                    url: "{{ route('payments.stats') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(res) {
    
                        $('#paidTotal').text(formatRupiah(res.paidTotal ?? 0));
                        $('#unpaidTotal').text(formatRupiah(res.unpaidTotal ?? 0));
                        $('#totalRevenue').text(formatRupiah(res.totalRevenue ?? 0));
    
                        $('#paidCount').text(res.paidCount ?? 0);
                        $('#unpaidCount').text(res.unpaidCount ?? 0);
                    },
                    error: function (xhr) {
                        console.error('Gagal mengambil stats:', xhr.responseText);
                    }
                });
            }

            loadStats();
        });
    </script>
@endpush
<script>
function printInvoice(invitationId) {
    window.open(`/admin/invitations/${invitationId}/invoice`, '_blank');
}
</script>
@endsection