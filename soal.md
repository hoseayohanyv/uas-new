🔧 Bagian A – Pemecahan Bug \& Error JWT REST API (40%)

Studi Kasus:

Diberikan project API sederhana berbasis CodeIgniter 4 atau Node.js (silakan pilih salah satu), dengan fitur CRUD menggunakan JWT untuk autentikasi. Namun, API ini memiliki beberapa bug dan kelemahan keamanan seperti:

* Token tidak valid saat login ulang
* Tidak ada pembatasan akses endpoint
* User lain bisa mengakses data user lain
* Logout tidak menghapus token aktif


Instruksi:

* Fork repositori berikut: https://github.com/f4uz4n/project-uas-pengamanan.git
* Temukan dan perbaiki minimal 3 bug/error terkait autentikasi dan otorisasi JWT.
* Tulis penjelasan bug dan solusinya di dalam file README.md.
* Lakukan commit terpisah untuk tiap bug fix dengan penjelasan jelas.



🛡️ Bagian B – Analisis Serangan dan Solusi (30%)

Kasus:

Server Anda menerima laporan bahwa endpoint /api/users/update bisa digunakan oleh user biasa untuk mengubah data admin lain, hanya dengan mengubah user\_id di JSON body request.



Tugas:

* Jelaskan jenis serangan yang terjadi.
* Simulasikan bagaimana serangan dilakukan (gunakan Postman/curl).
* Tunjukkan implementasi middleware atau filter yang tepat untuk mencegah serangan ini.
* Berikan potongan kode asli Anda dan commit hasil perbaikannya.
User biasa bisa mengubah data admin hanya dengan mengubah user_id di body JSON saat update.
Simulasi Serangan (dengan Postman):
http
Salin
Edit
POST /api/users/update HTTP/1.1
Authorization: Bearer <user-token>
Content-Type: application/json

{
    "id": 1,
    "username": "admin-hacked",
    "email": "admin@malicious.com"
}
User biasa berhasil mengubah data user ID 1 (admin).

Solusi Implementasi:
Tambahkan pengecekan agar hanya bisa update dirinya sendiri, kecuali jika role == admin.
 Contoh Filter di AuthFilter.php:
 if ($decoded->role !== 'admin' && $decoded->uid != $id) {
    return Services::response()->setStatusCode(403)->setJSON(['error' => 'Access denied']);
}

Hasil commit:
fix(auth): tambah validasi UID agar user hanya bisa update dirinya sendiri
git commit -m "fix(jwt): tambah exp saat generate token"
git commit -m "fix(auth): validasi role untuk akses endpoint admin"
git commit -m "fix(security): tambahkan validasi user ID saat update"


📚 Bagian C – Refleksi Teori dan Pandangan Etis (30%)

* Apa prinsip dasar keamanan informasi menurut cybersecurity framework (CIA Triad)?
* Jelaskan 2 pasal dalam UU ITE Indonesia yang berkaitan dengan pelanggaran keamanan data atau akses ilegal.
* Uraikan pandangan Al-Qur’an tentang larangan merusak sistem (cyber ethics), sertakan minimal 1 ayat dan penafsirannya.
* Menurut Anda, bagaimana penerapan nilai kejujuran dan amanah dalam dunia cybersecurity modern?
Prinsip CIA Triad
Confidentiality – menjaga kerahasiaan data dengan token JWT dan HTTPS.
Integrity – JWT memiliki tanda tangan digital (signature) agar tidak bisa dimodifikasi.
Availability – API tetap bisa diakses oleh user yang sah selama token valid.
UU ITE yang Relevan
Pasal 31 ayat 1: Setiap orang dilarang mengakses komputer/sistem tanpa izin

Pasal 32 ayat 1: Larangan mengubah, merusak, atau mentransmisikan data milik orang lain

tdk seberapa paham Al-Qur'an pak tapi saya bisa menjawab menurut kitab yang saya ketahui yaitu
Amsal 10:9 (TB)
"Orang yang bersih kelakuannya, hidup aman, tetapi siapa yang berliku-liku jalannya, akan diketahui."
 Makna dalam konteks cybersecurity:
Ayat ini mengajarkan bahwa seseorang yang jujur dan lurus dalam perilakunya akan hidup dengan aman, sedangkan yang melakukan kejahatan dalam sembunyi-sembunyi, akan terbongkar. Dalam dunia teknologi, ini berarti:

Jangan menyusup ke sistem yang bukan milik kita

Jangan memodifikasi data pengguna lain

Jangan menyalahgunakan akses (contoh: token JWT orang lain)

Etika Cyber dan Nilai Kejujuran
Kejujuran: Tidak menggunakan akses untuk hal yang merugikan

Amanah: Menjaga data dan sistem tetap aman, tidak menyebarkan data sensitif

Sebagai pengembang, kita punya tanggung jawab moral dan profesional dalam menjaga sistem yang kita buat agar tidak disalahgunakan.

💯 Kriteria Penilaian

&nbsp;	Kriteria			Bobot

* Bug Fixing dan Dokumentasi		40%
* Analisis dan Solusi Serangan		30%
* Jawaban Teori dan Etika		20%
* Struktur Git, Commit Message, README	10%
