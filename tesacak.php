<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelompokan Mahasiswa</title>
    <!-- Tailwind CSS CDN -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fixed-top-right {
            position: fixed;
            top: 1rem;
            right: 1rem;
        }
        .group-row {
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
        }
        .group-row:first-of-type {
            border-top: none;
        }
        .group-row:last-of-type {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 px-4">
        <!-- Formulir untuk Generate -->
        <form method="GET" class="fixed-top-right">
            <button type="submit" name="generate" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                Generate Pengacakan Kelompok
            </button>
        </form>

        <h1 class="text-4xl font-bold text-center mb-10 text-blue-600">Pengelompokan Mahasiswa</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-600">
                        <th class="py-3 px-4 border-b">Nama Grup</th>
                        <th class="py-3 px-4 border-b">Nomor</th>
                        <th class="py-3 px-4 border-b">Nama Mahasiswa</th>
                        <th class="py-3 px-4 border-b">Jurusan</th>
                        <th class="py-3 px-4 border-b">Kelas</th>
                        <th class="py-3 px-4 border-b">Status MBKM</th>
                        <th class="py-3 px-4 border-b">Gender</th>
                    </tr>
                </thead>
                <tbody>
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

                    // Mengambil data mahasiswa dari database
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

                    // Kelompokkan berdasarkan jurusan, kelas, dan partisipasi MBKM
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

                    // Acak setiap kelompok
                    function acak_kelompok(&$kelompok) {
                        foreach ($kelompok as &$subgroup) {
                            shuffle($subgroup);
                        }
                    }

                    // Membuat grup dari mahasiswa yang satu jurusan, kelas, dan memiliki status MBKM yang sama
                    function buat_grup($kelompok, $ukuran_grup = 4) {
                        $grup = [];
                        $sisa = [];
                        $nomor_grup = 1;

                        // Buat grup dari setiap kelompok sesuai jurusan, kelas, dan status MBKM
                        foreach ($kelompok as $key => $subgroup) {
                            while (count($subgroup) >= $ukuran_grup) {
                                $grup[] = [
                                    'nama_grup' => 'Grup ' . $nomor_grup++,
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
                            while (count($mahasiswa_sisa) >= $ukuran_grup) {
                                $grup[] = [
                                    'nama_grup' => 'Grup ' . $nomor_grup++,
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

                    // Menampilkan data dalam tabel
                    foreach ($grup_mahasiswa as $grup) {
                        $nomor = 1;
                        echo '<tr class="group-row">';
                        echo '<td class="py-2 px-4 border-b" rowspan="' . count($grup['anggota']) . '">' . htmlspecialchars($grup['nama_grup']) . '</td>';
                        foreach ($grup['anggota'] as $mhs) {
                            echo '<td class="py-2 px-4 border-b">' . $nomor++ . '</td>';
                            echo '<td class="py-2 px-4 border-b">' . htmlspecialchars($mhs['nama']) . '</td>';
                            echo '<td class="py-2 px-4 border-b">' . htmlspecialchars($mhs['jurusan']) . '</td>';
                            echo '<td class="py-2 px-4 border-b">' . htmlspecialchars($mhs['kelas']) . '</td>';
                            echo '<td class="py-2 px-4 border-b">' . ($mhs['ikut_mbkm'] ? 'Ya' : 'Tidak') . '</td>';
                            echo '<td class="py-2 px-4 border-b">' . htmlspecialchars($mhs['gender']) . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
