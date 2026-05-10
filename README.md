# Sistem Peminjaman Ruangan (Room Booking System)

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Framework: CodeIgniter 3](https://img.shields.io/badge/Framework-CodeIgniter%203-red.svg)](https://codeigniter.com/)

Sistem informasi berbasis web yang dirancang untuk mengotomatisasi proses reservasi ruangan dan fasilitas kelas di lingkungan universitas. Proyek ini dikembangkan untuk meminimalisir kesalahan jadwal (*double booking*) dan mempermudah pemantauan ketersediaan ruangan secara real-time.

## 🚀 Fitur Utama

- **Visual Scheduler:** Bagan kalender interaktif untuk melihat okupansi ruangan secara real-time.
- **Collision Detection:** Logika validasi otomatis untuk mencegah bentrok jadwal pada slot waktu yang sama.
- **Multi-Level Access:** Hak akses terpisah untuk Admin (Approval), Staf (Manajemen), dan Mahasiswa (Request).
- **AJAX Filter:** Pencarian data dinamis berdasarkan unit kerja atau nomor pengajuan tanpa reload halaman.
- **SSO Integration Ready:** Struktur yang siap diintegrasikan dengan sistem Single Sign-On.

## 🛠️ Tech Stack

- **Backend:** PHP 5.6+ / 7.x (Framework CodeIgniter 3)
- **Database:** MariaDB / MySQL
- **Frontend:** Bootstrap 3, jQuery, FontAwesome
- **Server (Dev/Test):** Lighttpd

