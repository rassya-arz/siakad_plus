<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KRS - SiAkad Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <!-- Tambahan Logo + Teks -->
                <a href="{{ route('krs.index') }}" class="flex items-center gap-3 text-xl font-extrabold">
                    <img src="{{ asset('images/Politeknik Negeri Indramayu.png') }}" 
                    alt="Logo SiAkad" 
                    class="h-9 w-auto">
                    <span>SiAkad <span class="text-blue-600">Plus</span></span>
                </a>
                <ul class="hidden sm:flex items-center gap-6 text-sm">
                    <li><a href="#" class="text-slate-500 hover:text-slate-800">Dashboard</a></li>
                    <li><a href="{{ route('krs.index') }}" class="font-bold text-slate-900">KRS</a></li>
                    <li><a href="#" class="text-slate-500 hover:text-slate-800">Keluar</a></li>
                </ul>
            </div>
            <div class="text-sm text-slate-600">
                {{ $mahasiswa['nama'] }} ({{ $mahasiswa['nim'] }})
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-6">

        {{-- BREADCRUMB --}}
        <p class="text-xs text-slate-500 mb-4">
            Home <span class="mx-1">&gt;</span> KRS
        </p>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- CARD KRS --}}
        <div class="bg-white rounded-xl shadow-md">

            {{-- Header card --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                <h1 class="text-lg font-bold">Kartu Rencana Studi (KRS)</h1>
                <span class="text-sm font-semibold text-slate-600">Total SKS: {{ $totalSks }}</span>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-700 border-b border-slate-200">
                            <th class="px-6 py-3 font-bold">Kode</th>
                            <th class="px-6 py-3 font-bold">Mata Kuliah</th>
                            <th class="px-6 py-3 font-bold">SKS</th>
                            <th class="px-6 py-3 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($matakuliah as $mk)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">{{ $mk['kode'] }}</td>
                                <td class="px-6 py-4">{{ $mk['nama'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $mk['badge'] }}">
                                        {{ $mk['sks'] }} SKS
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('krs.destroy', $mk['kode']) }}" method="POST"
                                          onsubmit="return confirm('Batalkan mata kuliah {{ $mk['nama'] }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-1.5 rounded-md transition">
                                            Batal
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                    Belum ada mata kuliah yang diambil.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer card --}}
            <div class="flex justify-end px-6 py-4 border-t border-slate-200">
                <form action="{{ route('krs.store') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded-md shadow-sm transition">
                        Simpan KRS
                    </button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>