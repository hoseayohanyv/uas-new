# UAS Keamanan Komputer

## Identitas
- Nama:Hosea Yohan Yehuda vicharist
- NIM:221080200075
- Kelas:6B4
- Repo GitHub: [https://github.com/hoseayohanyv/uas-new.git]

---

## Bagian A – Bug Fixing JWT REST API

### Bug 1: Token tetap aktif setelah logout
**Penjelasan:**  
...JWT merupakan server yang hanya menyimpan status login.Ketika user logout,token yang sudah diberikan tetap bisa digunakan untuk mengakses endpoint jika tidak ada mekanisme invalidasi.
Kode AuthFilter awal saya belum mengecek token yang sudah di-logout (tidak ada blacklist), sehingga token tetap aktif. Setelah memahami konsep ini, saya menyadari pentingnya sistem token invalidation, dan menambahkan solusi menggunakan blacklist atau waktu kadaluarsa (exp).

**Solusi:**  
...Implementasi token blacklist. Buatlah tabel atau cache (misalnya Redis) yang menyimpan token yang sudah di-logout, dan tambahkan pengecekan di AuthFilter

---

## Bagian B – Simulasi Serangan dan Solusi

### Jenis Serangan: Broken Access Control  
**Simulasi Postman:**  
...Login sebagai user biasa → dapat token

Coba akses endpoint: DELETE /users/1 (admin-only)

Request berhasil karena filter tidak mengecek role

**Solusi Implementasi:**  
...Tambahkan payload role di JWT saat login 
$payload = [
    'uid' => $user['id'],
    'role' => $user['role'],
    'exp'  => time() + 3600
];
Lalu di AuthFilter
if ($decoded->role !== 'admin') {
    return Services::response()->setStatusCode(403)->setJSON(['error' => 'Access forbidden']);
}
Kode AuthFilter awal saya juga belum memeriksa peran (role) pengguna. Akibatnya, user biasa bisa mengakses endpoint milik admin. Maka saya menambahkan role ke dalam payload JWT, serta melakukan pengecekan role di AuthFilter sebelum melanjutkan ke controller.
---

## Bagian C – Refleksi Teori & Etika

### 1. CIA Triad dalam Keamanan Informasi  
...Confidentiality: JWT harus dienkripsi dengan aman agar data tidak bocor.

Integrity: JWT menggunakan tanda tangan digital (HS256) agar token tidak dimodifikasi sembarangan.

Availability: API harus tetap dapat diakses user yang sah selama token valid.

### 2. UU ITE yang relevan  
...UU ITE Pasal 30 Ayat 1-3 melarang akses ilegal terhadap sistem elektronik, termasuk memanipulasi token atau mengakses data tanpa otorisasi. Pelanggar dapat dikenai pidana.

### 3. Pandangan Al-Qur'an  
- Surah Al-Baqarah: 205  
..."Dan apabila ia berpaling (dari kamu), ia berusaha membuat kerusakan di muka bumi dan merusak tanam-tanaman dan binatang ternak. Dan Allah tidak menyukai kerusakan."
Aksi penyalahgunaan sistem (seperti mengakses data tanpa izin) termasuk bentuk kerusakan yang dilarang dalam Islam.

### 4. Etika Cyber dan Kejujuran  
...Etika cyber menekankan:

Tidak menyalahgunakan celah keamanan sebaiknya memberitahukan celah tersebut kepada yg membuatnya

Tidak mengakses data user lain dan menggunakan secara ilegal

Bertanggung jawab atas hak akses yang diberikan

Sebagai pengembang, harus menjunjung kejujuran dan integritas dalam merancang sistem yang aman dan adil.

