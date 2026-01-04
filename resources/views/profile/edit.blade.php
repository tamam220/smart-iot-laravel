<x-app-layout>

    @section('title', 'Profil')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    @push('styles')
    <style>
        /* === TEMA PUTIH BERSIH (CLEAN WHITE) === */
        :root {
            --bg-main: #f3f4f6;       /* Background Abu Muda */
            --bg-card: #ffffff;       /* Kartu Putih */
            --text-main: #1f2937;     /* Teks Gelap (Hitam Abu) */
            --text-muted: #6b7280;    /* Teks Abu Sedang */
            --border-color: #e5e7eb;  /* Garis Batas Tipis */
            --primary-color: #0f172a; /* Tombol Hitam Elegan */
        }

        /* 1. RESET BACKGROUND JADI PUTIH/ABU MUDA */
        body, html, .min-h-screen, .bg-gray-100 { 
            background-color: var(--bg-main) !important;
            color: var(--text-main) !important;
        }

        /* 2. UBAH KARTU FORM JADI PUTIH */
        .bg-white, .sm\:rounded-lg {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
            color: var(--text-main) !important;
            border-radius: 16px !important;
        }

        /* 3. INPUT FIELD BERSIH */
        input[type="text"], input[type="email"], input[type="password"] {
            background-color: #fff !important;
            border: 1px solid #d1d5db !important;
            color: #111827 !important;
            border-radius: 8px !important;
            padding: 10px 15px !important;
            font-size: 14px !important;
        }
        input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            outline: none !important;
        }

        /* 4. TOMBOL SIMPAN (HITAM ELEGAN) */
        button.bg-gray-800, button.inline-flex {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            padding: 10px 20px !important;
            border: none !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
            transition: 0.2s !important;
        }
        button.bg-gray-800:hover {
            background-color: #000 !important;
            transform: translateY(-1px);
        }

        /* 5. TOMBOL DELETE (MERAH SOFT) */
        button.bg-red-600 {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
            border: 1px solid #fecaca !important;
            box-shadow: none !important;
        }
        button.bg-red-600:hover {
            background-color: #fecaca !important;
        }

        /* 6. TYPOGRAPHY & TEXT */
        label, .text-gray-600, .text-gray-900, header p {
            color: var(--text-muted) !important;
        }
        header h2 {
            color: var(--text-main) !important;
            font-weight: 700 !important;
            font-size: 18px !important;
        }
        
        nav.bg-white { background-color: #fff !important; border-bottom: 1px solid #eee !important; }
    </style>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>