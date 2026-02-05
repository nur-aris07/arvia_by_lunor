<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* wrapper paginate */
        .dataTables_paginate{
            display:flex !important;
            justify-content:flex-end;
            gap:.5rem;
            align-items:center;
        }

        .dataTables_paginate span{
            display:flex;
            gap:.25rem;
            align-items:center;
        }

        /* tombol */
        .dataTables_paginate .paginate_button{
            display:inline-flex !important;
            align-items:center;
            justify-content:center;
            width:40px;
            height:40px;
            padding:0 !important;
            margin:0 !important;
            border-radius:.75rem;
            border:1px solid #e5e7eb !important;
            background:#fff !important;
            color:#111827 !important;
            line-height:1 !important;
        }

        /* ikon prev/next */
        .dataTables_paginate .paginate_button i{
            font-size:14px;
            line-height:1;
        }

        /* active */
        .dataTables_paginate .paginate_button.current{
            background:#4f46e5 !important;
            border-color:#4f46e5 !important;
            color:#fff !important;
        }

        /* hover */
        .dataTables_paginate .paginate_button:not(.disabled):not(.current):hover{
            background:#f3f4f6 !important;
        }

        /* disabled */
        .dataTables_paginate .paginate_button.disabled{
            opacity:.5;
            cursor:not-allowed !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white flex-shrink-0" x-data="{ open: null }">
            <div class="p-6 border-b border-indigo-700">
                <h1 class="text-2xl font-bold">Invitato</h1>
                <p class="text-xs text-indigo-300 mt-1">Admin Panel</p>
            </div>
            
            <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-180px)]">
                <!-- Dashboard -->
                <a href="/dashboard" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <!-- User Management -->
                <div>
                    <button @click="open = open === 'users' ? null : 'users'" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <div class="flex items-center">
                            <i class="fas fa-users w-5"></i>
                            <span class="ml-3">Users</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm transition-transform" :class="open === 'users' ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open === 'users'" x-collapse class="ml-8 mt-2 space-y-1">
                        <a href="/users" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm {{ request()->routeIs('admin.users.*') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-list w-4 text-xs"></i>
                            <span class="ml-3">Daftar User</span>
                        </a>
                        <a href="users/add" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                            <i class="fas fa-plus w-4 text-xs"></i>
                            <span class="ml-3">Tambah User</span>
                        </a>
                    </div>
                </div>

                <!-- Template Management -->
                <div>
                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <div class="flex items-center">
                            <i class="fas fa-palette w-5"></i>
                            <span class="ml-3">Templates</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm transition-transform" :class="open === 'templates' ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open === 'templates'" x-collapse class="ml-8 mt-2 space-y-1">
                        <a href="/templates" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm {{ request()->routeIs('admin.templates.index') || request()->routeIs('admin.templates.edit') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-list w-4 text-xs"></i>
                            <span class="ml-3">Daftar Template</span>
                        </a>
                        <a href="/templates/add" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                            <i class="fas fa-plus w-4 text-xs"></i>
                            <span class="ml-3">Tambah Template</span>
                        </a>
                    </div>
                </div>

                <!-- Invitation Management -->
                <div>
                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <div class="flex items-center">
                            <i class="fas fa-envelope-open-text w-5"></i>
                            <span class="ml-3">Undangan</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm transition-transform" :class="open === 'invitations' ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open === 'invitations'" x-collapse class="ml-8 mt-2 space-y-1">
                        <a href="/invitations" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm {{ request()->routeIs('admin.invitations.*') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-list w-4 text-xs"></i>
                            <span class="ml-3">Daftar Undangan</span>
                        </a>
                        <a href="invitations/add" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                            <i class="fas fa-plus w-4 text-xs"></i>
                            <span class="ml-3">Buat Undangan</span>
                        </a>
                    </div>
                </div>

                <!-- Payment Management -->
                <a href="/payments" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition {{ request()->routeIs('admin.payments.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-money-bill-wave w-5"></i>
                    <span class="ml-3">Payments</span>
                </a>

                <!-- Reports -->
                <a href="/reports" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition {{ request()->routeIs('admin.reports.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="ml-3">Laporan</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-indigo-700 bg-indigo-900">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold">Superadmin</p>
                            <p class="text-xs text-indigo-300">Admin</p>
                        </div>
                    </div>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="text-indigo-300 hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                    <div class="flex items-center space-x-4">
                        <button class="relative text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>