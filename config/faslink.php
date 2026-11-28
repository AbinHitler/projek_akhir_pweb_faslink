
<?php

return [

    'user' => [
        'id' => 'MHS001',
        'nama' => 'Mahasiswa FASLINK',
        'nim' => '20240001',
        'prodi' => 'Sistem Informasi',
        'email' => 'mahasiswa@example.com',
    ],

    'admin' => [
        'id' => 'ADM001',
        'nama' => 'Admin FASLINK',
        'prodi' => 'Administrator',
        'email' => 'admin@example.com',
    ],

    'ringkasan' => [
        'gedung' => 3,
        'ruangan' => 2,
        'barang' => 3,
    ],

    'facilities' => [
        [
            'slug' => 'gedung-rektorat',
            'nama' => 'Gedung Rektorat',
            'jenis' => 'gedung',
            'status' => 'Aktif',
        ],
        [
            'slug' => 'aula-serbaguna',
            'nama' => 'Aula Serbaguna',
            'jenis' => 'ruangan',
            'status' => 'Aktif',
        ],
        [
            'slug' => 'ruang-seminar',
            'nama' => 'Ruang Seminar',
            'jenis' => 'ruangan',
            'status' => 'Aktif',
        ],
        [
            'slug' => 'proyektor',
            'nama' => 'Proyektor',
            'jenis' => 'barang',
            'status' => 'Aktif',
        ],
        [
            'slug' => 'sound-system',
            'nama' => 'Sound System',
            'jenis' => 'barang',
            'status' => 'Aktif',
        ],
        [
            'slug' => 'meja-lipat',
            'nama' => 'Meja Lipat',
            'jenis' => 'barang',
            'status' => 'Aktif',
        ],
    ],

    'loans' => [],

    'status' => [
        'pending' => 'Menunggu',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        'in-use' => 'Sedang Dipinjam',
        'returned' => 'Dikembalikan',
    ],

    'history' => [],

    'tren' => [
        'labels' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
        'data' => [0, 0, 0, 0, 0, 0],
    ],

    'users' => [],

    'waktu' => [
        '08.00 - 10.00',
        '10.00 - 12.00',
        '13.00 - 15.00',
        '15.00 - 17.00',
    ],

];
