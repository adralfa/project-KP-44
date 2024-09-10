<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelompokan Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fixed-top-right {
            position: fixed;
            top: 1rem;
            right: 1rem;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 px-4">
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
                    @foreach($grup_mahasiswa as $grup)
                    @php $nomor = 1; @endphp
                    <tr>
                        <td class="py-2 px-4 border-b" rowspan="{{ count($grup['anggota']) }}">{{ $grup['nama_grup'] }}</td>
                        @foreach($grup['anggota'] as $mhs)
                        @if ($loop->first)
                        <td class="py-2 px-4 border-b">{{ $nomor++ }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->nama }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->jurusan }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->kelas }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->ikut_mbkm ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->gender }}</td>
                        @else
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $nomor++ }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->nama }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->jurusan }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->kelas }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->ikut_mbkm ? 'Ya' : 'Tidak' }}</td>
                        <td class="py-2 px-4 border-b">{{ $mhs->gender }}</td>
                    </tr>
                    @endif
                    @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form method="GET" class="fixed-top-right">
        <button type="submit" name="generate" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
            Generate Pengacakan Kelompok
        </button>
    </form>
</body>

</html>