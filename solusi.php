<?php
/**
 * Proyek Akhir Semester (PAS) - Sistem Pakar Diagnosa Kerusakan Laptop
 */
session_start();
require_once 'data/kerusakan.php';
require_once 'data/solusi.php';

// Cek sesi dengan aman
if (!isset($_SESSION['hasil_diagnosa'])) {
    header("Location: index.php");
    exit();
}

$hasil = $_SESSION['hasil_diagnosa'];
$kerusakan_id = $hasil['kerusakan_id'] ?? null;

// Mengambil nama kerusakan dengan aman
$nama_kerusakan = "Kerusakan Tidak Dikenal";
if ($kerusakan_id && isset($data_kerusakan[$kerusakan_id])) {
    $nama_kerusakan = is_array($data_kerusakan[$kerusakan_id]) ? $data_kerusakan[$kerusakan_id]['nama'] : $data_kerusakan[$kerusakan_id];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solusi Penanganan</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
        }
        /* Gaya untuk Lingkaran Angka */
        .step-item { display: flex; align-items: flex-start; margin-bottom: 12px; }
        .step-number { 
            background-color: #1a73e8; color: white; width: 25px; height: 25px; 
            border-radius: 50%; display: flex; justify-content: center; align-items: center; 
            font-size: 0.85rem; font-weight: bold; margin-right: 12px; flex-shrink: 0; 
            margin-top: 2px;
        }
        .step-text { font-size: 0.95rem; color: #2d3436; line-height: 1.5; padding-top: 2px; }

        /* Gaya UI Lainnya */
        .mock-status-bar { background: #1a73e8; color: #ffffff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 500; }
        .page-header { padding: 20px; display: flex; align-items: center; background: #fff; }
        .btn-back { text-decoration: none; color: #333; font-size: 1.5rem; margin-right: 15px; }
        .page-content { padding: 24px; }
        .icon-shield {
            display: flex;
            justify-content: center;
            margin-bottom: 14px;
        }
        .icon-shield .shield-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eaf2fe;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-shield .shield-main {
            font-size: 34px;
            line-height: 1;
        }
        .icon-shield .wrench-badge {
            position: absolute;
            bottom: 8px;
            right: 6px;
            font-size: 16px;
            line-height: 1;
        }
        .title-box { text-align: center; margin-bottom: 25px; }
        .title-box .title-main { font-weight: 700; font-size: 1.15rem; color: #1a1a1a; margin-bottom: 4px; }
        .title-box .title-sub { color: #1a73e8; font-weight: 700; }
        .tips-box { background: #f0f7ff; padding: 15px; border-radius: 12px; border-left: 5px solid #1a73e8; font-size: 0.85rem; color: #4a5568; display: flex; gap: 10px; margin-bottom: 20px; }
        .btn-main { display: block; width: 100%; padding: 14px; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 600; margin-bottom: 12px; box-sizing: border-box; }
        .bg-blue { background: #1a73e8; color: #fff; }
        .bg-grey { background: #fff; color: #1a73e8; border: 1.5px solid #1a73e8; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="app-container" style="max-width: 412px; margin: auto; background: #fff; min-height: 844px; display: flex; flex-direction: column; border-radius: 24px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.12);">
        <div class="mock-status-bar">
            <span id="live-clock">00:00</span>
            <span>📶 🔋</span>
        </div>

        <div class="page-header">
            <a href="hasil.php" class="btn-back">&larr;</a>
            <span style="font-weight: 600; font-size: 1.1rem;">Solusi Perbaikan</span>
        </div>

        <div class="page-content">
            <div class="icon-shield">
                <span class="shield-wrap">
                    <span class="shield-main">🛡️</span><span class="wrench-badge">🔧</span>
                </span>
            </div>
            <div class="title-box">
                <p class="title-main">Solusi Perbaikan</p>
                <p class="title-sub"><?php echo htmlspecialchars($nama_kerusakan); ?></p>
            </div>

            <?php if ($kerusakan_id && isset($data_solusi[$kerusakan_id])): ?>
                <div class="steps-box">
                    <strong style="display: block; margin-bottom: 15px;">Langkah-langkah yang dapat dilakukan:</strong>
                    <?php $no = 1; foreach ($data_solusi[$kerusakan_id] as $langkah): ?>
                        <div class="step-item">
                            <div class="step-number"><?php echo $no++; ?></div>
                            <div class="step-text"><?php echo htmlspecialchars($langkah); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="tips-box">
                    <span>💡</span>
                    <div><strong>Tips:</strong> Pastikan laptop dalam keadaan mati dan cabut baterai/charger saat melakukan perbaikan komponen.</div>
                </div>
            <?php else: ?>
                <p style="text-align:center;">Data solusi tidak ditemukan.</p>
            <?php endif; ?>

            <div style="margin-top: 30px;">
                <a href="diagnosa.php" class="btn-main bg-blue">🔄 Diagnosa Lagi</a>
                <a href="index.php" class="btn-main bg-grey">🏠 Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script>
        function updateClock() { 
            const now = new Date(); 
            document.getElementById('live-clock').textContent = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`; 
        }
        setInterval(updateClock, 1000); 
        updateClock();
    </script>
</body>
</html>