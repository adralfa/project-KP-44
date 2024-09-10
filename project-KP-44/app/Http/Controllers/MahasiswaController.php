<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    // Fungsi untuk menampilkan data mahasiswa dan pengelompokan
    public function index(Request $request)
    {
        // Mengambil semua data mahasiswa dari database
        $mahasiswa = Mahasiswa::all();

        // Kelompokkan mahasiswa berdasarkan jurusan, kelas, dan partisipasi MBKM
        $kelompok_mahasiswa = $this->kelompokkan_mahasiswa($mahasiswa);

        // Acak setiap kelompok
        $this->acak_kelompok($kelompok_mahasiswa);

        // Buat grup berdasarkan hasil pengelompokan
        $grup_mahasiswa = $this->buat_grup($kelompok_mahasiswa);

        return view('mahasiswa.index', compact('grup_mahasiswa'));
    }

    // Fungsi untuk mengelompokkan mahasiswa
    private function kelompokkan_mahasiswa($mahasiswa)
    {
        $kelompok = [];

        foreach ($mahasiswa as $mhs) {
            $key = $mhs->jurusan . '_' . $mhs->kelas . '_' . ($mhs->ikut_mbkm ? 'mbkm' : 'nonmbkm');
            if (!isset($kelompok[$key])) {
                $kelompok[$key] = [];
            }
            $kelompok[$key][] = $mhs;
        }

        return $kelompok;
    }

    // Fungsi untuk mengacak kelompok
    private function acak_kelompok(&$kelompok)
    {
        foreach ($kelompok as &$subgroup) {
            shuffle($subgroup);
        }
    }

    // Fungsi untuk membuat grup dari mahasiswa
    private function buat_grup($kelompok, $ukuran_grup = 4)
    {
        $grup = [];
        $nomor_grup = 1;

        foreach ($kelompok as $subgroup) {
            while (count($subgroup) >= $ukuran_grup) {
                $grup[] = [
                    'nama_grup' => 'Grup ' . $nomor_grup++,
                    'anggota' => array_splice($subgroup, 0, $ukuran_grup),
                ];
            }
        }

        return $grup;
    }
}
