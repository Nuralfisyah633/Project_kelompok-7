/**
 * Proyek Akhir Semester (PAS) - Sistem Pakar Diagnosa Kerusakan Laptop
 * File: js/script.js (Pengatur Transisi Splash Screen, Jam Real-Time & Interaktivitas UI)
 */

document.addEventListener("DOMContentLoaded", function () {
    // ==========================================
    // 1. FITUR JAM DIGITAL REAL-TIME
    // ==========================================
    function updateClock() {
        const clockElement = document.getElementById("live-clock");
        if (clockElement) {
            const now = new Date();
            let hours = now.getHours().toString().padStart(2, '0');
            let minutes = now.getMinutes().toString().padStart(2, '0');
            clockElement.textContent = `${hours}:${minutes}`;
        }
    }

    // Jalankan jam pertama kali saat halaman dimuat
    updateClock();
    // Perbarui jam setiap 1 detik agar terus berdetak
    setInterval(updateClock, 1000);


    // ==========================================
    // 2. TRANSISI SPLASH SCREEN TO HOME
    // ==========================================
    const splashScreen = document.getElementById("splash-screen");
    const homeScreen = document.getElementById("home-screen");

    /**
     * Mengatur transisi otomatis dari Splash Screen ke Beranda
     * Durasi diatur selama 2500 milidetik (2,5 detik) agar sinkron dengan
     * animasi kemajuan bar loading (.loading-bar) yang ada di CSS.
     */
    setTimeout(function () {
        // Menghilangkan kelas 'active' dari Splash Screen untuk menyembunyikannya
        if (splashScreen) {
            splashScreen.classList.remove("active");
        }
        
        // Menambahkan kelas 'active' pada Home Screen untuk menampilkannya ke pengguna
        if (homeScreen) {
            homeScreen.classList.add("active");
        }
    }, 2500);


    // ==========================================
    // 3. INTERAKTIVITAS NAVIGASI BAWAH (TAB BAR)
    // ==========================================
    const navItems = document.querySelectorAll(".nav-item");
    navItems.forEach(item => {
        item.addEventListener("click", function () {
            // Menghapus status aktif dari semua item navigasi
            navItems.forEach(nav => nav.classList.remove("active"));
            // Menambahkan status aktif pada item yang baru saja diklik
            this.classList.add("active");
        });
    });
});