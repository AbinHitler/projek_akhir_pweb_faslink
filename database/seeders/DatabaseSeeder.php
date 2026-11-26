<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\FacilityCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun admin untuk login ke dashboard admin.
        User::updateOrCreate(
            ['email' => 'admin@faslink.test'],
            [
                'name' => 'Admin Sarpras',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Data contoh fasilitas agar katalog dan form peminjaman bisa dipakai.
        $elektronik = FacilityCategory::updateOrCreate(['name' => 'Elektronik']);
        $ruangan = FacilityCategory::updateOrCreate(['name' => 'Ruangan']);

        $rektorat = Facility::updateOrCreate(
            ['name' => 'Gedung Rektorat', 'type' => 'gedung'],
            [
                'location' => 'Pusat Kampus',
                'condition' => 'baik',
                'status' => 'aktif',
                'description' => 'Gedung utama kampus.',
            ]
        );

        Facility::updateOrCreate(
            ['name' => 'Aula Serbaguna', 'type' => 'ruangan'],
            [
                'parent_id' => $rektorat->id,
                'category_id' => $ruangan->id,
                'capacity' => 200,
                'condition' => 'baik',
                'status' => 'aktif',
                'description' => 'Aula untuk seminar, rapat, dan kegiatan organisasi mahasiswa.',
            ]
        );

        Facility::updateOrCreate(
            ['name' => 'Ruang Seminar', 'type' => 'ruangan'],
            [
                'parent_id' => $rektorat->id,
                'category_id' => $ruangan->id,
                'capacity' => 50,
                'condition' => 'baik',
                'status' => 'aktif',
                'description' => 'Ruangan untuk seminar dan diskusi.',
            ]
        );

        Facility::updateOrCreate(
            ['name' => 'Proyektor', 'type' => 'barang'],
            [
                'category_id' => $elektronik->id,
                'location' => 'Inventaris',
                'stock_total' => 16,
                'stock_damaged' => 0,
                'condition' => 'baik',
                'status' => 'aktif',
                'description' => 'Proyektor untuk presentasi kegiatan.',
            ]
        );

        Facility::updateOrCreate(
            ['name' => 'Sound System', 'type' => 'barang'],
            [
                'category_id' => $elektronik->id,
                'location' => 'Inventaris',
                'stock_total' => 8,
                'stock_damaged' => 0,
                'condition' => 'baik',
                'status' => 'aktif',
                'description' => 'Perangkat sound system portabel.',
            ]
        );

        Facility::updateOrCreate(
            ['name' => 'Meja Lipat', 'type' => 'barang'],
            [
                'location' => 'Inventaris',
                'stock_total' => 20,
                'stock_damaged' => 0,
                'condition' => 'baik',
                'status' => 'aktif',
                'description' => 'Meja lipat untuk kegiatan kampus.',
            ]
        );
    }
}
