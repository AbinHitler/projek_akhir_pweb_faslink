IMPLEMENTASI MODUL 1 - MANAJEMEN FASILITAS FASLINK

FITUR YANG TERSEDIA
1. Menambahkan data gedung, ruangan, dan barang.
2. Mengubah informasi fasilitas melalui tombol Edit.
3. Menghapus data fasilitas melalui tombol Hapus (Soft Delete).
4. Melihat daftar fasilitas, termasuk pencarian nama serta filter jenis dan status.
5. Mengatur jumlah stok barang (stok total dan stok rusak), kondisi fasilitas, serta status aktif/tidak aktif.

PENGELOLAAN DATA
- Ruangan wajib dipasangkan dengan gedung induk.
- Barang memiliki stok total dan stok rusak. Stok tersedia dihitung otomatis dari stok total dikurangi stok rusak.
- Kondisi fasilitas: Baik, Rusak, atau Pemeliharaan.
- Gedung yang masih memiliki ruangan tidak dapat dihapus.
- Penghapusan menggunakan Soft Delete agar data historis tidak langsung hilang.

CARA MENJALANKAN
1. Ekstrak ZIP project.
2. Buka folder hasilKerja/faslink_work di VS Code.
3. Pastikan PHP 8.3+, Composer, dan MySQL sudah terpasang.
4. Sesuaikan DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, dan DB_PASSWORD pada .env.
5. Jalankan perintah:
   composer install
   php artisan key:generate   (jika APP_KEY belum terisi)
   php artisan migrate
   php artisan serve
6. Buka halaman admin:
   http://127.0.0.1:8000/admin/facilities
   atau klik Demo Admin pada halaman login jika route login sudah disiapkan.

CATATAN TEKNIS
- Route modul manajemen fasilitas sudah didaftarkan dan nama route disesuaikan dengan Blade view.
- Halaman dashboard admin sementara diarahkan ke Manajemen Fasilitas.
- Menu admin yang belum memiliki implementasi route/controller disembunyikan agar tidak menyebabkan error saat membuka modul ini.
- Middleware autentikasi belum diaktifkan karena project masih berupa prototype/demo. Aktifkan middleware auth dan pembatasan role Admin sebelum deployment.
- Jalankan migrasi database sebelum menggunakan fitur CRUD.
