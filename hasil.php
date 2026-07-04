<?php
/**
 * Proyek Akhir Semester (PAS) - Sistem Pakar Diagnosa Kerusakan Laptop
 * File: hasil.php (Halaman Hasil Diagnosa - Halaman 5)
 * Jalur Penyimpanan: project/hasil.php
 */

session_start();
require_once 'data/gejala.php';
require_once 'data/kerusakan.php';
require_once 'data/solusi.php';

// Memastikan data sesi tersedia. Jika tidak, kembalikan pengguna ke halaman utama
if (!isset($_SESSION['hasil_diagnosa'])) {
    header("Location: index.php");
    exit();
}

// Mengekstrak informasi dari data sesi
$hasil = $_SESSION['hasil_diagnosa'];
$gejala_input = $hasil['gejala_input'];
$kerusakan_id = $hasil['kerusakan_id'];
$rule_id = $hasil['rule_id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa - Sistem Pakar</title>
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        .result-wrapper {
            text-align: center;
            padding: 10px 0;
        }
        .result-card {
            background: #ffffff;
            border: 1px solid var(--border-soft);
            border-radius: 20px;
            padding: 30px 20px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .result-icon-box {
            width: 80px;
            height: 80px;
            background: #f4f7fe;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 16px;
        }
        .result-icon-box svg {
            width: 40px;
            height: 40px;
        }
        .identity-text {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 6px;
        }
        .diagnosed-name {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 20px;
        }
        .diagnosed-name.not-found {
            color: var(--text-muted);
        }
        
        /* Komponen Persentase / Tingkat Keyakinan Bulat Sesuai Prototype */
        .confidence-container {
            margin: 10px 0;
            position: relative;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
        .circle-svg {
            transform: rotate(-90deg);
        }
        .circle-bg {
            fill: none;
            stroke: #f0f4f8;
            stroke-width: 8;
        }
        .circle-progress {
            fill: none;
            stroke: var(--primary-blue);
            stroke-width: 8;
            stroke-dasharray: 251.2;
            stroke-dashoffset: 25.12; 
            stroke-linecap: round;
        }
        .confidence-text {
            position: absolute;
            font-size: 1.4rem;
            font-weight: 700;
            color: #222222;
        }
        .confidence-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 6px;
        }

        /* Area Daftar Gejala Terpilih */
        .selected-box {
            text-align: left;
            background: #f8faff;
            border-radius: 16px;
            padding: 18px;
            border: 1px solid #eef2f8;
            margin-bottom: 24px;
        }
        .selected-title {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .badge-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .badge-item {
            font-size: 0.82rem;
            color: #444444;
            display: flex;
            align-items: center;
            background: #ffffff;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #edf2f7;
        }
        .check-icon {
            color: var(--primary-blue);
            font-weight: bold;
            margin-right: 10px;
        }
        .action-button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }
        .btn-secondary {
            background: #e8f0fe;
            color: var(--primary-blue);
            text-decoration: none;
            padding: 14px 24px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 14px;
            width: 100%;
            display: block;
            border: none;
            text-align: center;
            transition: background 0.2s;
        }

        /* Bottom Tab Navigator Style */
        .bottom-nav { position: absolute; bottom: 0; left: 0; width: 100%; height: 65px; background: #ffffff; display: flex; justify-content: space-around; align-items: center; border-top: 1px solid #edf2f7; box-sizing: border-box; z-index: 10; }
        .nav-link { display: flex; flex-direction: column; align-items: center; color: #90a4ae; font-size: 0.75rem; font-weight: 500; cursor: pointer; text-decoration: none; width: 100%; height: 100%; justify-content: center; gap: 4px; }
        .nav-link span { font-size: 1.2rem; }
    </style>
</head>
<body>

    <div class="app-container" style="position: relative; height: 844px; display: flex; flex-direction: column; overflow: hidden; border: 4px solid #ffffff; box-shadow: 0 12px 40px rgba(0,0,0,0.12); border-radius: 24px;">
        
        <div class="mock-status-bar" style="color: #ffffff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 500; z-index: 10;">
            <span id="live-clock">00:00</span>
            <span>📶 🔋</span>
        </div>

        <div class="page-header">
            <a href="diagnosa.php" class="btn-back">&larr;</a>
            <span>Hasil Diagnosa</span>
        </div>

        <div class="app-body" style="flex: 1; padding: 24px; overflow-y: auto; background-color: #ffffff; padding-bottom: 85px;">
            <div class="result-wrapper">
                
                <div class="result-card">
                    <?php if ($kerusakan_id !== null && isset($data_kerusakan[$kerusakan_id])): ?>
                        <div class="result-icon-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1976d2" stroke-width="2">
                                <rect x="3" y="4" width="18" height="12" rx="2" />
                                <path d="M2 20h20" />
                                <circle cx="12" cy="10" r="1" fill="#1976d2" />
                                <path d="M12 7v2" />
                            </svg>
                        </div>
                        <p class="identity-text">Kerusakan Teridentifikasi</p>
                        <h4 class="diagnosed-name">
                            <?php 
                            if (is_array($data_kerusakan[$kerusakan_id])) {
                                echo $data_kerusakan[$kerusakan_id]['nama'];
                            } else {
                                echo $data_kerusakan[$kerusakan_id];
                            }
                            ?>
                        </h4>
                        
                        <span class="confidence-label">Tingkat Keyakinan</span>
                        <div class="confidence-container">
                            <svg class="circle-svg" width="100" height="100">
                                <circle class="circle-bg" cx="50" cy="50" r="40"></circle>
                                <circle class="circle-progress" cx="50" cy="50" r="40"></circle>
                            </svg>
                            <div class="confidence-text">90%</div>
                        </div>
                    <?php else: ?>
                        <div class="result-icon-box" style="background: #ffebee;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#c62828" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                        </div>
                        <p class="identity-text">Hasil Analisis</p>
                        <h4 class="diagnosed-name not-found">Data Tidak Ditemukan</h4>
                        <p style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.5; text-align: center; margin-top: 4px;">
                            Kombinasi gejala yang Anda masukkan tidak cocok dengan database aturan pengetahuan sistem kami.
                        </p>
                    <?php endif; ?>
                </div>

                <div class="selected-box">
                    <div class="selected-title">
                        <span>📋</span> Gejala yang Dipilih
                    </div>
                    <div class="badge-list">
                        <?php 
                        if (!empty($gejala_input)) {
                            foreach ($gejala_input as $k_gejala) {
                                if (isset($data_gejala[$k_gejala])) {
                                    $nama_gejala = is_array($data_gejala[$k_gejala]) ? $data_gejala[$k_gejala]['nama'] : $data_gejala[$k_gejala];
                                    echo '<div class="badge-item"><span class="check-icon">✓</span>' . $nama_gejala . '</div>';
                                }
                            }
                        } else {
                            echo '<div class="badge-item" style="color: var(--text-muted); font-style: italic;">Tidak ada gejala terpilih</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="action-button-group">
                    <?php if ($kerusakan_id !== null): ?>
                        <a href="solusi.php" class="btn-primary">Lihat Solusi</a>
                    <?php endif; ?>
                    
                    <a href="diagnosa.php" class="btn-secondary">
                        🔄 Diagnosa Lagi
                    </a>
                </div>

            </div>
        </div>

        <div class="bottom-nav">
            <a href="index.php" class="nav-link">
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

    <script>
        function updateClock() { 
            const now = new Date(); 
            const clock = document.getElementById('live-clock');
            if (clock) {
                clock.textContent = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`; 
            }
        }
        setInterval(updateClock, 1000); 
        updateClock();
    </script>
</body>
</html>