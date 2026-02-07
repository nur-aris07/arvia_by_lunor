@extends('layouts.app')

@section('title', 'Daftar Template')
@section('header', 'Manajemen Template')
@section('context', 'Template')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input id="search" type="text" placeholder="Cari template..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select id="filter-status" class="px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>
        <a href="javascript:void(0)" id="btnAdd" class="px-3 py-2 bg-neutral-900 text-white rounded-xl hover:bg-neutral-800 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus"></i>
            <span>Template</span>
        </a>
    </div>

    <!-- Templates Grid -->
    <div class="bg-white rounded-2xl border border-gray-200/70 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="table" class="w-full">
                <thead class="bg-gray-50/70 border-b border-gray-200/70">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Template</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                        {{-- <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Digunakan</th> --}}
                        {{-- <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Fields</th> --}}
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/70"></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalAdd" class="hidden fixed inset-0 z-[9998]">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl border border-gray-200/70 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200/70 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Tambah @yield('context')</h3>
                    <p id="modalSub" class="text-sm text-gray-500">Isi data dengan benar.</p>
                </div>
                <button type="button" id="modalCloseAdd" class="h-9 w-9 rounded-xl inline-flex items-center justify-center text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <form id="modalFormAdd" class="px-5 pb-3" action="/users/add" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="body-modal max-h-[60vh] overflow-y-auto pr-1 scroll-nice space-y-1.5">
                    <input type="hidden" id="idAdd" name="id" value="" />
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input id="nameAdd" name="name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none" placeholder="Nama template" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input id="slugAdd" name="slug" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" placeholder="otomatis dari nama" disabled required>
                        <p class="ml-3 mt-1 text-xs text-gray-500">Slug dibuat otomatis dari nama template.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500">Rp</span>
                            <input id="priceAdd" name="price" type="number" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none" placeholder="123456" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preview Image</label>
                        <input id="imageAdd" name="image" type="file" accept="image/*" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200 transition" placeholder="123456">
                        <p class="ml-3 mt-1 text-xs text-gray-500">Format: JPG/PNG/WebP. Disarankan rasio 16:9.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="descriptionAdd" name="description" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none min-h-[100px] resize-y" placeholder="Deskripsi singkat template..."></textarea>
                    </div>
                </div>
                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" id="modalCancelAdd" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="formSubmitAdd" class="px-3 py-2 rounded-xl bg-neutral-900 text-white hover:bg-neutral-800 transition inline-flex items-center gap-2">
                        <span id="formSubmitTextAdd">Simpan</span>
                        <i id="formSpinnerAdd" class="fas fa-circle-notch fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalEdit" class="hidden fixed inset-0 z-[9998]">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl border border-gray-200/70 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200/70 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Tambah @yield('context')</h3>
                    <p id="modalSub" class="text-sm text-gray-500">Isi data dengan benar.</p>
                </div>
                <button type="button" id="modalCloseEdit" class="h-9 w-9 rounded-xl inline-flex items-center justify-center text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <form id="modalFormEdit" class="px-5 pb-3" action="/users/add" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="body-modal max-h-[60vh] overflow-y-auto pr-1 scroll-nice space-y-1.5">
                    <input type="hidden" id="idEdit" name="id" value="" />
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input id="nameEdit" name="name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none" placeholder="Nama template" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input id="slugEdit" name="slug" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" placeholder="otomatis dari nama" disabled required>
                        <p class="ml-3 mt-1 text-xs text-gray-500">Slug dibuat otomatis dari nama template.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500">Rp</span>
                            <input id="priceEdit" name="price" type="number" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none" placeholder="123456" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preview Image</label>
                        <input id="imageEdit" name="image" type="file" accept="image/*" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200 transition" placeholder="123456">
                        <small id="imageEditCurrent" class="mt-2 text-sm font-semibold text-indigo-600 px-2 py-1"></small>
                        <p class="ml-3 mt-1 text-xs text-gray-500">Format: JPG/PNG/WebP. Disarankan rasio 16:9.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="descriptionEdit" name="description" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none min-h-[100px] resize-y" placeholder="Deskripsi singkat template..."></textarea>
                    </div>
                </div>
                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" id="modalCancelEdit" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="formSubmitEdit" class="px-3 py-2 rounded-xl bg-neutral-900 text-white hover:bg-neutral-800 transition inline-flex items-center gap-2">
                        <span id="formSubmitTextEdit">Simpan</span>
                        <i id="formSpinnerEdit" class="fas fa-circle-notch fa-spin hidden"></i>
                    </button>
                </div>
            </form>
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
                <h3 class="text-lg font-semibold text-gray-900">Hapus @yield('context')</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus data ini? Semua data terkait akan ikut terhapus.</p>
        <div class="flex justify-end space-x-3">
            <button type="button" id="deleteModalBatalBtn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
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
                    url: "{{ route('templates.index') }}",
                    data: function (d) {
                        d.search = $('#search').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [
                    { data: 'template', name: 'template', orderable: true },
                    { data: 'status', name: 'status', orderable: true },
                    { data: 'harga', name: 'role', orderable: true, searchable: false },
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

            $('#filter-role').on('change', function () {
                table.draw();
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const batalBtn = document.getElementById('deleteModalBatalBtn');

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.delete-btn');
                if (!btn) return;

                const userId = btn.dataset.id;

                form.action = `/users/${userId}/delete`;
                modal.classList.remove('hidden');
            });

            batalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                form.action = '';
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    form.action = '';
                }
            });
            
            const btnAdd = document.getElementById('btnAdd');
            const modalAdd = document.getElementById('modalAdd');
            const btnCloseModalAdd = document.getElementById('modalCloseAdd');
            const btnCancelModalAdd = document.getElementById('modalCancelAdd');
            const modalEdit = document.getElementById('modalEdit');
            const btnCloseModalEdit = document.getElementById('modalCloseEdit');
            const btnCancelModalEdit = document.getElementById('modalCancelEdit');

            function openModal(m) {
                m.classList.remove('hidden');
            }
            function closeModal(m) {
                m.classList.add('hidden');
                // setLoading(false);
            }

            btnCloseModalAdd.addEventListener('click', () => closeModal(modalAdd));
            btnCancelModalAdd.addEventListener('click', () => closeModal(modalAdd));
            btnCloseModalEdit.addEventListener('click', () => closeModal(modalEdit));
            btnCancelModalEdit.addEventListener('click', () => closeModal(modalEdit));
            if (btnAdd) {
                btnAdd.addEventListener('click', () => {
                    openModal(modalAdd);
                });
            }
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.edit-btn');
                if (!btn) return;
                const data = btn.closest('[data-id]');
                if (!data) return;
                const dataset = data.dataset;
                Object.keys(dataset).forEach((key) => {
                    let value = dataset[key];
                    
                    try {
                        value = JSON.parse(value);
                    } catch(error) {}

                    const input = document.querySelector(`#${key}Edit`);
                    if (!input) return;

                    if (input.type === 'file') {
                        input.value = '';
                        const previewText = document.querySelector(`#${key}EditCurrent`);

                        if (!value || value === 'null') {
                            if (previewText) previewText.textContent = '';
                            if (previewImg) {
                                previewImg.src = '';
                                previewImg.classList.add('hidden');
                            }
                            return;
                        }

                        if (previewText) {
                            previewText.innerHTML = `
                            File saat ini: <a href="/uploads/${value}" target="_blank" rel="noopener noreferrer"
                                class="underline underline-offset-2 hover:opacity-80">
                                ${value}
                            </a>
                            `;
                        }

                        return;
                    }
                    if (input) {
                        input.value = typeof value === 'object' && value !== null
                            ? JSON.stringify(value, null, 2)
                            : value;
                    }
                });
                openModal(modalEdit);
            });
        });
    </script>
@endpush
@endsection