# JWT CRUD API UAS Starter

Silakan lanjutkan pengembangan API dan perbaiki bug yang ditemukan.
1.Temuan:UserController.php – Bug & Perbaikan

Tidak ada validasi input pada saat update
Tidak ada pengecekan apakah user dengan ID tertentu ada sebelum update()
Tidak ada pengecekan apakah update() berhasil atau gagal
Sudah menggunakan ResourceController dengan modelName yang tepat

Perbaikan:

Tambahkan validasi username dan email agar tidak kosong
Tambahkan if (!$user) sebelum update
Tambahkan pengecekan hasil update()
Tambahkan response error jika gagal

2.Status:

Kamu belum menyalin kode UserModel.php ke sini.
Tapi diasumsikan UserModel sudah ada dan digunakan di UserController.
Saran :
Pastikan UserModel meng-extend CodeIgniter\Model
Properti table, allowedFields, dan primaryKey diset dengan benar
Jika kamu kirim UserModel.php, aku bisa bantu periksa detailnya juga.

3.AuthFilter.php – Bug & Perbaikan
Temuan:
Tidak ada import use Config\Services;, padahal digunakan
Menggunakan getenv('JWT_SECRET') yang kurang aman, sebaiknya pakai config('JWT')->secretKey
Tidak ada validasi struktur header Bearer
Tidak ada pengecekan role atau level akses di token
Tidak menyimpan decoded token ke request (jika ingin pakai di controller)
Sudah bisa decode token pakai JWT

Perbaikan:

Tambahkan import use Config\Services;
Tambahkan validasi Bearer di header
Gunakan Firebase\JWT\Key dan config JWT versi aman
Tambahkan validasi role untuk mencegah Broken Access Control
Tambahkan mekanisme blacklist (opsional)

