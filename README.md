# Janji
Saya Klara Ollivviera Augustine Gunawan dengan NIM 2306205 mengerjakan soal Tugas Praktikum 2 dalam mata kuliah DPBO untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

# Desain Program 
<img width="556" alt="Screenshot 2025-04-20 at 16 31 47" src="https://github.com/user-attachments/assets/3749ee77-8618-428f-b442-9e2fcb29e6df" />

Program ini mengelola data distribusi donasi dan informasi terkait donatur dan donasi. Program ini memiliki beberapa komponen yang saling terhubung untuk mencatat, mengelola, dan menampilkan informasi donasi serta distribusinya.

Terdapat 3 Tabel Utama:
1. Distribusi
2. Donasi
3. Donatur

## 1. Tabel Distribusi
Tabel ini menyimpan informasi distribusi donasi yang telah dilakukan.
### Atribut:
- id: ID unik untuk setiap distribusi.
- tujuan: Lokasi atau penerima distribusi.
- tanggal_distribusi: Tanggal distribusi dilakukan.
- status: Status distribusi yang bisa berupa 'proses' atau 'selesai'.
- id_donasi: ID donasi yang terkait dengan distribusi ini.

### Fungsi:
- getAllDistribusi(): Mengambil semua data distribusi dari database dengan informasi terkait donasi dan donatur.
- getDistribusiById($id): Mengambil data distribusi berdasarkan ID tertentu, termasuk informasi donasi dan donatur terkait.
- getDonasiList(): Mengambil semua data donasi yang ada, digunakan untuk mengisi dropdown di form distribusi.
- createDistribusi($tujuan, $tanggal_distribusi, $status, $id_donasi): Menambahkan data distribusi baru ke dalam database.
- updateDistribusi($id, $tujuan, $tanggal_distribusi, $status, $id_donasi): Memperbarui data distribusi yang sudah ada berdasarkan ID.
- deleteDistribusi($id): Menghapus data distribusi berdasarkan ID.
- searchDistribusi($tujuan): Mencari distribusi berdasarkan tujuan yang diinputkan oleh pengguna.

## 2. Tabel Donasi
Tabel ini menyimpan informasi tentang donasi yang dilakukan oleh donatur.
### Atribut:
- id: ID unik untuk setiap donasi.
- jumlah_donasi: Jumlah uang atau barang yang didonasikan.
- tanggal_donasi: Tanggal donasi diterima.
- jenis_donasi: Jenis donasi, bisa berupa uang atau barang.
- id_donatur: ID donatur yang melakukan donasi.

### Fungsi:
- getAllDonasi(): Mengambil semua data donasi dari database.
- createDonasi($jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur): Menambahkan data donasi baru.
- updateDonasi($id, $jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur): Memperbarui data donasi yang sudah ada.
- deleteDonasi($id): Menghapus data donasi berdasarkan ID.
- searchDonasi($name): Mencari donasi berdasarkan nama donatur.

## 3. Tabel Donatur
Tabel ini menyimpan data pribadi dari donatur yang memberikan donasi.
### Atribut:
- id: ID unik untuk setiap donatur.
- name: Nama donatur.
- email: Email donatur.
- nomor_telepon: Nomor telepon donatur.

### Fungsi:
- getAllDonatur(): Mengambil semua data donatur dari database.
- createDonatur($name, $email, $nomor_telepon): Menambahkan data donatur baru.
- updateDonatur($name, $email, $nomor_telepon): Memperbarui data donatur yang sudah ada.
- deleteDonatur($id): Menghapus data donatur berdasarkan ID.

searchDonatur($name)
Mencari donatur berdasarkan nama.
# Alur Program
1. Manajemen Donasi:
- Sistem memungkinkan untuk menambahkan, mengedit, dan menghapus data donasi.
- Setiap donasi terkait dengan seorang donatur dan memiliki jumlah, jenis, dan tanggal.
2. Manajemen Distribusi:
- Sistem mencatat distribusi dari donasi ke lokasi yang ditentukan.
- Status distribusi dapat ditandai sebagai 'proses' atau 'selesai'.
3. Manajemen Donatur:
- Sistem memungkinkan untuk menambah, mengedit, dan menghapus data donatur.

# Dokumentasi
di file (sizenya kebesaran maaf)
