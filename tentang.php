<?php
/**
 * File: tentang.php (Menu Tentang Aplikasi)
 */
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Aplikasi - Sistem Pakar</title>
    <style>
        :root { --primary-blue: #1976d2; --bg-light: #f4f7fe; }
        body { font-family: 'Poppins', sans-serif; background-color: #e2e8f0; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .app-container { width: 100%; max-width: 412px; height: 844px; background: var(--bg-light); border-radius: 30px; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12); overflow: hidden; display: flex; flex-direction: column; position: relative; border: 4px solid #ffffff; }
        
        /* Status Bar */
        .mock-status-bar { background: var(--primary-blue); padding: 12px 24px; color: #fff; display: flex; justify-content: space-between; font-size: 0.85rem; }
        
        /* Header dengan Tombol Kembali */
        .app-header { background: var(--primary-blue); color: white; padding: 20px; display: flex; align-items: center; gap: 15px; }
        .back-btn { text-decoration: none; color: white; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; width: 30px; }
        
        /* Body */
        .app-body { flex: 1; padding: 20px; overflow-y: auto; padding-bottom: 80px; }
        .card { background: white; padding: 20px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); margin-bottom: 16px; }
        .card h3 { margin-top: 0; color: #1a202c; font-size: 1rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 12px; }
        .card p { font-size: 0.85rem; color: #4a5568; line-height: 1.6; margin: 0 0 10px 0; }
        .profile-group { display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #4a5568; }
        .profile-item { display: flex; justify-content: space-between; border-bottom: 1px dashed #e2e8f0; padding-bottom: 4px; }
        
        /* Bottom Navigation */
        .bottom-nav { position: absolute; bottom: 0; left: 0; width: 100%; height: 65px; background: #ffffff; display: flex; justify-content: space-around; align-items: center; border-top: 1px solid #e2e8f0; z-index: 10; }
        .nav-item { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: #90a4ae; font-size: 0.75rem; }
        .nav-item.active { color: var(--primary-blue); font-weight: 600; }
    </style>
</head>
<body>

    <div class="app-container">
        <div class="mock-status-bar">
            <span id="live-clock">00:00</span>
            <span>📶 🔋</span>
        </div>

        <div class="app-header">
            <a href="javascript:history.back()" class="back-btn">&larr;</a>
            <h2 style="margin:0; font-size:1.2rem; font-weight:600; flex-grow: 1;">Tentang Aplikasi</h2>
        </div>

        <div class="app-body">
            <div class="card">
                <h3>💻 Tujuan Aplikasi</h3>
                <p>Aplikasi Sistem Pakar Diagnosa Kerusakan Laptop ini dirancang untuk membantu pengguna mengidentifikasi jenis kerusakan pada perangkat keras maupun perangkat lunak laptop secara cepat dan mandiri berdasarkan gejala-gejala fisik yang dialami.</p>
            </div>

            <div class="card">
                <h3>🧠 Metode Forward Chaining</h3>
                <p>Aplikasi ini mengadopsi metode penalaran maju (<b>Forward Chaining</b>). Alur pelacakan dimulai dari pengumpulan fakta-fakta lapangan berupa gejala yang dipilih oleh pengguna, kemudian sistem akan mencocokkannya dengan basis aturan hingga ditarik kesimpulan akhir.</p>
            </div>

            <div class="card">
                <h3>👤 Identitas Pembuat</h3>
                <div class="profile-group">
                    <div class="profile-item"><span>Nama Pembuat</span><span>Kelompok 7</span></div>
                    <div class="profile-item"><span>Jurusan</span><span>Informatics & Computer Science</span></div>
                    <div class="profile-item"><span>Tugas Akhir</span><span>Proyek Akhir Semester</span></div>
                    <div class="profile-item"><span>Tahun Rilis</span><span>2026</span></div>
                </div>
            </div>
        </div>

        <div class="bottom-nav">
            <a href="index.php" class="nav-item"><span>🏠</span> Beranda</a>
            <a href="riwayat.php" class="nav-item"><span>⏱️</span> Riwayat</a>
            <a href="tentang.php" class="nav-item active"><span>👤</span> Tentang</a>
        </div>
    </div>

    <script>
        function updateClock() { 
            const now = new Date(); 
            const el = document.getElementById('live-clock');
            if (el) el.textContent = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`; 
        }
        setInterval(updateClock, 1000); 
        updateClock();
    </script>
</body>
</html>