<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KrsController extends Controller
{
    private const MAHASISWA = [
        'nama' => 'Rassya Arzusanie Anandhya',
        'nim'  => '2503022',
    ];

    /** Data dummy awal */
    private function dataAwal(): array
    {
        return [
            ['kode' => 'MK101', 'nama' => 'Pemrograman Web Lanjut', 'sks' => 3],
            ['kode' => 'MK102', 'nama' => 'Struktur Data',          'sks' => 4],
            ['kode' => 'MK103', 'nama' => 'Basis Data',             'sks' => 4],
        ];
    }

    /** Ambil data KRS dari session (atau data awal bila belum ada) */
    private function ambilKrs(): array
    {
        return session('krs', $this->dataAwal());
    }

    public function index(): View
    {
        $matakuliah = array_map(function ($mk) {
            // 3 SKS = hijau, 4 SKS ke atas = oranye
            $mk['badge'] = $mk['sks'] >= 4
                ? 'bg-amber-100 text-amber-700'
                : 'bg-green-100 text-green-700';
            return $mk;
        }, $this->ambilKrs());

        $totalSks = array_sum(array_column($matakuliah, 'sks'));

        return view('krs', [
            'mahasiswa'  => self::MAHASISWA,
            'matakuliah' => $matakuliah,
            'totalSks'   => $totalSks,
        ]);
    }

    public function destroy(string $kode): RedirectResponse
    {
        $sisa = array_values(array_filter(
            $this->ambilKrs(),
            fn ($mk) => $mk['kode'] !== $kode
        ));

        session(['krs' => $sisa]);

        return redirect()->route('krs.index')
            ->with('success', "Mata kuliah {$kode} berhasil dibatalkan.");
    }

    public function store(Request $request): RedirectResponse
    {
        // Simulasi saja: di aplikasi nyata data disimpan ke database
        return redirect()->route('krs.index')
            ->with('success', 'KRS berhasil disimpan.');
    }

    public function reset(): RedirectResponse
    {
        session()->forget('krs');

        return redirect()->route('krs.index');
    }
}