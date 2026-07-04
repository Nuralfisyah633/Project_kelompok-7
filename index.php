<?php
/**
 * Proyek Akhir Semester (PAS) - Sistem Pakar Diagnosa Kerusakan Laptop
 * File: index.php (Halaman Splash Screen & Home terintegrasi)
 * Karakteristik: Desain fluid mobile-first, dominan biru, responsif sesuai prototype.
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Diagnosa Kerusakan Laptop</title>
    
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; overflow: hidden; }
        
        /* Frame Container utama berbentuk handphone sesuai mockup prototype */
        .app-container { 
            width: 100%; 
            max-width: 412px; 
            height: 100vh; 
            max-height: 840px; 
            background: #ffffff; 
            position: relative; 
            overflow: hidden; 
            box-shadow: 0 12px 40px rgba(0,0,0,0.12); 
            border-radius: 24px; 
            display: flex;
            flex-direction: column;
            border: 4px solid #ffffff;
        }

        /* State management untuk perpindahan halaman */
        .page { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none; flex-direction: column; z-index: 1; }
        .page.active { display: flex; }

        /* --- STYLING SPLASH SCREEN (HALAMAN 1) --- */
        #splash-screen { background: linear-gradient(180deg, #1565c0 0%, #1976d2 100%); color: #ffffff; padding: 30px; text-align: center; }
        .splash-body { flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .logo-circle { width: 130px; height: 130px; background: rgba(255,255,255,0.15); border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-bottom: 30px; border: 2px solid rgba(255,255,255,0.25); }
        .logo-circle svg { fill: none; stroke: #ffffff; stroke-width: 1.5; width: 70px; height: 70px; }
        #splash-screen h1 { font-size: 1.8rem; font-weight: 700; letter-spacing: 1.5px; margin-bottom: 4px; }
        #splash-screen h2 { font-size: 1.05rem; font-weight: 400; opacity: 0.9; margin-bottom: 24px; }
        .method-badge { background: #ffffff; color: #1976d2; padding: 6px 18px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .splash-footer { width: 100%; margin-top: auto; padding-bottom: 20px; }
        .splash-footer p { font-size: 0.85rem; opacity: 0.8; margin-bottom: 15px; }
        .progress-box { width: 65%; height: 5px; background: rgba(255,255,255,0.2); border-radius: 10px; margin: 0 auto 8px auto; overflow: hidden; }
        .progress-line { width: 0%; height: 100%; background: #ffffff; border-radius: 10px; animation: loadSmooth 2.2s ease-in-out forwards; }
        @keyframes loadSmooth { 0% { width: 0%; } 100% { width: 100%; } }

        /* --- STYLING HOME SCREEN (HALAMAN 2) --- */
        .app-header { background: linear-gradient(135deg, #1565c0 0%, #1976d2 100%); color: #ffffff; padding: 45px 24px 30px 24px; border-bottom-left-radius: 28px; border-bottom-right-radius: 28px; position: relative; }
        .header-content { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
        .header-text h3 { font-size: 1.35rem; font-weight: 600; margin-bottom: 4px; }
        .header-text p { font-size: 0.8rem; opacity: 0.85; line-height: 1.4; max-width: 220px; }
        .header-img svg { width: 75px; height: 75px; opacity: 0.9; }
        
        .app-body { flex: 1; padding: 24px; overflow-y: auto; background-color: #f4f7fe; }
        .menu-card { background: #ffffff; border-radius: 16px; padding: 20px; margin-bottom: 16px; border: 1px solid #eef2f8; box-shadow: 0 6px 16px rgba(25,118,210,0.04); text-align: center; display: flex; flex-direction: column; align-items: center; }
        .menu-card .icon-box { width: 60px; height: 60px; background: #e8f0fe; color: #1976d2; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.6rem; margin-bottom: 12px; }
        .menu-card h4 { font-size: 1rem; font-weight: 600; margin-bottom: 6px; color: #333; }
        .menu-card p { font-size: 0.8rem; color: #666; line-height: 1.4; margin-bottom: 18px; }
        
        .btn-primary { background: #1976d2; color: #ffffff; text-decoration: none; padding: 12px 24px; font-size: 0.9rem; font-weight: 600; border-radius: 12px; width: 100%; display: block; box-shadow: 0 4px 14px rgba(25,118,210,0.25); transition: background 0.2s; text-align: center; }
        
        /* Menu Navigasi List Bawah */
        .list-link { text-decoration: none; display: block; margin-bottom: 12px; }
        .list-card { display: flex; align-items: center; background: #ffffff; border: 1px solid #eef2f8; padding: 14px 16px; border-radius: 14px; box-shadow: 0 4px 10px rgba(0,0,0,0.01); transition: background 0.2s; }
        .list-card:hover { background: #fafbfc; }
        .list-icon { width: 36px; height: 36px; background: #e8f0fe; border-radius: 8px; display: flex; justify-content: center; align-items: center; font-size: 1.1rem; color: #1976d2; margin-right: 14px; }
        .list-info { flex: 1; text-align: left; }
        .list-info h5 { font-size: 0.88rem; font-weight: 600; color: #333; margin: 0; }
        .list-info p { font-size: 0.75rem; color: #777; margin: 2px 0 0 0; }
        .list-arrow { color: #b0bec5; font-size: 1.2rem; }

        /* Bottom Tab Navigator */
        .bottom-nav { height: 68px; border-top: 1px solid #edf2f7; background: #ffffff; display: flex; justify-content: space-around; align-items: center; padding-bottom: 4px; }
        .nav-link { display: flex; flex-direction: column; align-items: center; color: #90a4ae; font-size: 0.7rem; font-weight: 500; cursor: pointer; text-decoration: none; width: 100%; height: 100%; justify-content: center; }
        .nav-link.active { color: #1976d2; font-weight: 600; }
        .nav-link span { font-size: 1.2rem; margin-bottom: 2px; }

        /* Status bar jam universal */
        .mock-status-bar { position: absolute; top: 0; left: 0; width: 100%; display: flex; justify-content: space-between; padding: 12px 24px; font-size: 0.75rem; font-weight: 600; z-index: 10; opacity: 0.85; }
    </style>
</head>
<body>

    <div class="app-container">

        <div id="splash-screen" class="page active">
            <div class="mock-status-bar" style="color: #ffffff;">
                <span id="clock-splash">00:00</span>
                <span>📶 🔋</span>
            </div>
            
            <div class="splash-body">
                <div class="logo-circle">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="11" rx="1.5" />
                        <path d="M1 19h22v1a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-1z" />
                        <circle cx="12" cy="9" r="2.5" />
                        <path d="M12 11.5v3.5m0 0a2 2 0 1 0 2 2" />
                    </svg>
                </div>
                <h1>SISTEM PAKAR</h1>
                <h2>DIAGNOSA KERUSAKAN LAPTOP</h2>
                <div style="margin-top: 10px;"><span class="method-badge">Metode Forward Chaining</span></div>
            </div>

            <div class="splash-footer">
                <p>Solusi tepat untuk masalah laptop Anda</p>
                <div class="progress-box">
                    <div class="progress-line"></div>
                </div>
                <div style="font-size: 0.75rem; opacity: 0.6;">Memuat...</div>
            </div>
        </div>


        <div id="home-screen" class="page">
            <div class="mock-status-bar" style="color: #ffffff;">
                <span id="clock-home">00:00</span>
                <span>📶 🔋</span>
            </div>

            <div class="app-header">
                <div class="header-content">
                    <div class="header-text">
                        <h3>Selamat Datang</h3>
                        <p>Sistem Pakar Diagnosa Kerusakan Laptop</p>
                    </div>
                    <div class="header-img">
                        <svg viewBox="0 0 64 64" fill="none">
                            <rect x="10" y="14" width="44" height="28" rx="3" fill="rgba(255,255,255,0.2)" stroke="#ffffff" stroke-width="2"/>
                            <path d="M4 48h56v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3z" fill="rgba(255,255,255,0.3)" stroke="#ffffff" stroke-width="2"/>
                            <line x1="28" y1="42" x2="36" y2="42" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="app-body">
                
                <div class="menu-card">
                    <div class="icon-box">📋</div>
                    <h4>Diagnosa Kerusakan Laptop</h4>
                    <p>Dapatkan hasil diagnosa dan solusi kerusakan laptop Anda dengan metode Forward Chaining.</p>
                    <a href="diagnosa.php" class="btn-primary">🔍 Mulai Diagnosa</a>
                </div>

                <a href="tentang.php" class="list-link">
                    <div class="list-card">
                        <div class="list-icon">🛡️</div>
                        <div class="list-info">
                            <h5>Tentang Aplikasi</h5>
                            <p>Informasi dasar sistem pakar laptop</p>
                        </div>
                        <div class="list-arrow">&rsaquo;</div>
                    </div>
                </a>

                <a href="bantuan.php" class="list-link">
                    <div class="list-card">
                        <div class="list-icon">❓</div>
                        <div class="list-info">
                            <h5>Bantuan</h5>
                            <p>Panduan pengoperasian sistem</p>
                        </div>
                        <div class="list-arrow">&rsaquo;</div>
                    </div>
                </a>

            </div>

            <div class="bottom-nav">
                <a href="index.php" class="nav-link active">
                    <span>🏠</span>
                    <div>Beranda</div>
                </a>
                <a href="riwayat.php" class="nav-link">
                    <span>🕒</span>
                    <div>Riwayat</div>
                </a>
                <a href="tentang.php" class="nav-link">
                    <span>👤</span>
                    <div>Tentang</div>
                </a>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 1. Fungsi Jam Digital (Mendukung kedua status bar secara simultan)
            function updateClock() {
                const now = new Date();
                const hh = String(now.getHours()).padStart(2, '0');
                const mm = String(now.getMinutes()).padStart(2, '0');
                const timeString = `${hh}:${mm}`;
                
                const splashClock = document.getElementById('clock-splash');
                const homeClock = document.getElementById('clock-home');
                
                if (splashClock) splashClock.textContent = timeString;
                if (homeClock) homeClock.textContent = timeString;
            }
            setInterval(updateClock, 1000);
            updateClock();

            // 2. Transisi Otomatis Splash Screen ke Home Screen (2.2 detik)
            setTimeout(function () {
                const splash = document.getElementById("splash-screen");
                const home = document.getElementById("home-screen");
                if (splash) splash.classList.remove("active");
                if (home) home.classList.add("active");
            }, 2200);
        });
    </script>
</body>
</html>