<?php
/**
 * File: riwayat.php (Menu Riwayat Diagnosis)
 */
session_start();
require_once 'data/kerusakan.php';
require_once 'data/gejala.php';

$daftar_riwayat = isset($_SESSION['riwayat_diagnosa']) ? $_SESSION['riwayat_diagnosa'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Diagnosa</title>
    <style>
        :root { --primary-blue: #1976d2; --bg-light: #f4f7fe; }
        body { font-family: 'Poppins', sans-serif; background-color: #e2e8f0; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .app-container { width: 100%; max-width: 412px; height: 844px; background: var(--bg-light); border-radius: 30px; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12); overflow: hidden; display: flex; flex-direction: column; position: relative; border: 4px solid #ffffff; }
        
        /* Status Bar */
        .mock-status-bar { background: var(--primary-blue); padding: 12px 24px; color: #fff; display: flex; justify-content: space-between; font-size: 0.85rem; }
        
        /* Header dengan Tombol Kembali */
        .app-header { background: var(--primary-blue); color: white; padding: 20px; display: flex; align-items: center; gap: 15px; }
        .back-btn { text-decoration: none; color: white; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; width: 30px; }
        
        /* Body & Content */
        .app-body { flex: 1; padding: 20px; overflow-y: auto; padding-bottom: 80px; }
        .history-card { background: white; padding: 16px; border-radius: 16px; margin-bottom: 12px; border-left: 5px solid var(--primary-blue); box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .history-time { font-size: 0.75rem; color: #718096; font-weight: 600; }
        .history-title { font-size: 0.95rem; font-weight: 700; color: #1a202c; margin: 5px 0; }
        
        /* Bottom Navigation */
        .bottom-nav { position: absolute; bottom: 0; left: 0; width: 100%; height: 65px; background: #ffffff; display: flex; justify-content: space-around; align-items: center; border-top: 1px solid #e2e8f0; z-index: 10; }
        .nav-item { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: #90a4ae; font-size: 0.75rem; transition: 0.3s; }
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
            <h2 style="margin:0; font-size:1.2rem; font-weight:600; flex-grow: 1;">Riwayat Diagnosis</h2>
        </div>

        <div class="app-body">
            <?php if (empty($daftar_riwayat)): ?>
                <p style="text-align:center; color:#718096; margin-top: 50px;">📭 Belum ada riwayat pemeriksaan.</p>
            <?php else: ?>
                <?php 
                $daftar_riwayat_reversed = array_reverse($daftar_riwayat);
                foreach ($daftar_riwayat_reversed as $item): 
                    $id_k = $item['kerusakan_id'];
                    $nama_k = isset($data_kerusakan[$id_k]['nama']) ? $data_kerusakan[$id_k]['nama'] : $data_kerusakan[$id_k];
                ?>
                    <div class="history-card">
                        <div class="history-time">⏱️ <?php echo htmlspecialchars($item['waktu']); ?></div>
                        <h4 class="history-title"><?php echo htmlspecialchars($nama_k); ?></h4>
                        <div style="font-size: 0.8rem; color: #4a5568;">Gejala terdeteksi: <?php echo count($item['gejala_terpilih']); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="bottom-nav">
            <a href="index.php" class="nav-item"><span>🏠</span> Beranda</a>
            <a href="riwayat.php" class="nav-item active"><span>⏱️</span> Riwayat</a>
            <a href="tentang.php" class="nav-item"><span>👤</span> Tentang</a>
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