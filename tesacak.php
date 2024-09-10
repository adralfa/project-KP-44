<?php
// Koneksi ke database MySQL
$host = "localhost";
$user = "root";
$password = "";
$database = "mahasiswa"; // Nama database

$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Langkah 1: Mengambil data mahasiswa dari database
function ambil_data_mahasiswa($conn) {
    $sql = "SELECT id, nama, kelas, jurusan, ikut_mbkm, gender FROM mahasiswa";
    $result = $conn->query($sql);
    
    $mahasiswa = [];
    
    if ($result->num_rows > 0) {
        // Ambil data setiap baris
        while ($row = $result->fetch_assoc()) {
            $mahasiswa[] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'kelas' => $row['kelas'],
                'jurusan' => $row['jurusan'],
                'ikut_mbkm' => (bool)$row['ikut_mbkm'],
                'gender' => $row['gender']
            ];
        }
    } else {
        echo "Tidak ada data mahasiswa.";
    }
    
    return $mahasiswa;
}

// Langkah 2: Kelompokkan berdasarkan jurusan, kelas, dan partisipasi MBKM
function kelompokkan_mahasiswa($mahasiswa) {
    $kelompok = [];
    
    foreach ($mahasiswa as $mhs) {
        // Kunci pengelompokan: jurusan + kelas + status MBKM
        $key = $mhs['jurusan'] . '_' . $mhs['kelas'] . '_' . ($mhs['ikut_mbkm'] ? 'mbkm' : 'nonmbkm');
        if (!isset($kelompok[$key])) {
            $kelompok[$key] = [];
        }
        $kelompok[$key][] = $mhs;
    }
    
    return $kelompok;
}

// Langkah 3: Acak setiap kelompok
function acak_kelompok(&$kelompok) {
    foreach ($kelompok as &$subgroup) {
        shuffle($subgroup);
    }
}

// Langkah 4: Membuat grup dari mahasiswa yang satu jurusan, kelas, dan memiliki status MBKM yang sama
function buat_grup($kelompok, $ukuran_grup = 4) {
    $grup = [];
    $sisa = [];

    // Buat grup dari setiap kelompok sesuai jurusan, kelas, dan status MBKM
    foreach ($kelompok as $key => $subgroup) {
        echo "Kelompok: $key - Total Mahasiswa: " . count($subgroup) . "<br>";
        while (count($subgroup) >= $ukuran_grup) {
            $grup[] = [
                'jurusan_kelas_mbkm' => $key,
                'anggota' => array_splice($subgroup, 0, $ukuran_grup)
            ];
        }

        // Simpan sisa jika kurang dari 4
        if (count($subgroup) > 0) {
            $sisa[$key] = $subgroup;
        }
    }

    // Gabungkan sisa mahasiswa ke grup baru dengan jurusan dan status MBKM yang sama, tanpa memperhatikan kelas
    $sisa_dikelompokkan = [];
    foreach ($sisa as $key => $mahasiswa_sisa) {
        $parts = explode('_', $key);
        $jurusan = $parts[0];
        $status_mbkm = $parts[2];  
        $jurusan_mbkm_key = $jurusan . '_' . $status_mbkm; 

        if (!isset($sisa_dikelompokkan[$jurusan_mbkm_key])) {
            $sisa_dikelompokkan[$jurusan_mbkm_key] = [];
        }
        $sisa_dikelompokkan[$jurusan_mbkm_key] = array_merge($sisa_dikelompokkan[$jurusan_mbkm_key], $mahasiswa_sisa);
    }

    // Buat grup baru dari sisa mahasiswa dengan jurusan dan status MBKM yang sama (tanpa kelas)
    foreach ($sisa_dikelompokkan as $jurusan_mbkm_key => $mahasiswa_sisa) {
        echo "Sisa Kelompok: $jurusan_mbkm_key - Total Mahasiswa: " . count($mahasiswa_sisa) . "<br>";
        while (count($mahasiswa_sisa) >= $ukuran_grup) {
            $grup[] = [
                'jurusan_kelas_mbkm' => 'mixed_' . $jurusan_mbkm_key,
                'anggota' => array_splice($mahasiswa_sisa, 0, $ukuran_grup)
            ];
        }
    }

    // Tangani sisa mahasiswa yang kurang dari 4
    $sisa_total = array_merge(...array_values($sisa_dikelompokkan));
    if (count($sisa_total) > 0) {
        // Tambahkan sisa mahasiswa ke grup yang sudah ada
        foreach ($sisa_total as $mhs) {
            $added = false;

            // Coba tambahkan ke grup yang sesuai dengan jurusan, kelas, dan status MBKM
            foreach ($grup as &$g) {
                $grup_jurusan_mbkm = explode('_', $g['jurusan_kelas_mbkm']);
                $grup_jurusan = $grup_jurusan_mbkm[0];
                $grup_status_mbkm = $grup_jurusan_mbkm[2];
                $grup_kelas = $grup_jurusan_mbkm[1] ?? '';

                if (count($g['anggota']) < 5 && $grup_jurusan === $mhs['jurusan'] && $grup_status_mbkm === ($mhs['ikut_mbkm'] ? 'mbkm' : 'nonmbkm') && $grup_kelas === $mhs['kelas']) {
                    $g['anggota'][] = $mhs;
                    $added = true;
                    break;
                }
            }

            // Jika tidak ada grup yang sesuai, tambahkan ke grup dengan jurusan dan status MBKM yang sama (kelas diabaikan)
            if (!$added) {
                foreach ($grup as &$g) {
                    $grup_jurusan_mbkm = explode('_', $g['jurusan_kelas_mbkm']);
                    $grup_jurusan = $grup_jurusan_mbkm[0];
                    $grup_status_mbkm = $grup_jurusan_mbkm[2];

                    if (count($g['anggota']) < 5 && $grup_jurusan === $mhs['jurusan'] && $grup_status_mbkm === ($mhs['ikut_mbkm'] ? 'mbkm' : 'nonmbkm')) {
                        $g['anggota'][] = $mhs;
                        $added = true;
                        break;
                    }
                }
            }

            // Jika masih ada yang belum ditambahkan, tampilkan pesan debug
            if (!$added) {
                echo "Tidak dapat menambahkan mahasiswa: " . $mhs['nama'] . " (Jurusan: " . $mhs['jurusan'] . ", Kelas: " . $mhs['kelas'] . ", MBKM: " . ($mhs['ikut_mbkm'] ? 'Ya' : 'Tidak') . ")<br>";
            }
        }
    }

    return $grup;
}

// Ambil data mahasiswa dari database
$mahasiswa = ambil_data_mahasiswa($conn);

// Kelompokkan mahasiswa berdasarkan jurusan, kelas, dan partisipasi MBKM
$kelompok_mahasiswa = kelompokkan_mahasiswa($mahasiswa);

// Acak setiap kelompok
acak_kelompok($kelompok_mahasiswa);

// Buat grup dengan memperhatikan jurusan, kelas, dan status MBKM
$grup_mahasiswa = buat_grup($kelompok_mahasiswa);

// Tampilkan grup yang sudah dibuat
foreach ($grup_mahasiswa as $index => $grup) {
    echo "Grup " . ($index + 1) . ":<br>";
    foreach ($grup['anggota'] as $mhs) {
        echo "- " . $mhs['nama'] . " (Jurusan: " . $mhs['jurusan'] . ", Kelas: " . $mhs['kelas'] . ", MBKM: " . ($mhs['ikut_mbkm'] ? 'Ya' : 'Tidak') . ", Gender: " . $mhs['gender'] . ")<br>";
    }
    echo "<br>";
}

// Tutup koneksi database
$conn->close();
?>
