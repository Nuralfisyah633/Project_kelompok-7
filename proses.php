<?php
/**
 * Proyek Akh Semester (PAS) - Sistem Pakar Diagnosa Kerusakan Laptop
 * File: proses.php
 * Jalur Penyimpanan: project/proses.php
 */

session_start();

// Validasi apakah file database di folder data benar-benar ada sebelum dipanggil
if (file_exists('data/gejala.php') && file_exists('data/kerusakan.php') && file_exists('data/rule.php')) {
    require_once 'data/gejala.php';
    require_once 'data/kerusakan.php';
    require_once 'data/rule.php';
} else {
    die("Error: Folder atau file database di dalam 'project/data/' hilang/salah penempatan!");
}

$gejala_input = isset($_POST['gejala']) ? $_POST['gejala'] : [];

$kerusakan_id_terdeteksi = null;
$rule_id_terdeteksi = null;

// Eksekusi Forward Chaining
if (!empty($gejala_input) && isset($data_rule) && is_array($data_rule)) {
    foreach ($data_rule as $id_rule => $rule) {
        // Pastikan key 'gejala' dan 'kerusakan_id' ada di dalam rule sebelum dieksekusi
        if (isset($rule['gejala']) && isset($rule['kerusakan_id'])) {
            $gejala_rule = $rule['gejala'];
            
            $mencari_irisan = array_intersect($gejala_input, $gejala_rule);
            
            if (count($mencari_irisan) === count($gejala_input) && !empty($mencari_irisan)) {
                $kerusakan_id_terdeteksi = $rule['kerusakan_id'];
                $rule_id_terdeteksi = $id_rule;
                break; 
            }
        }
    }
}

// Simpan hasil ke session utama untuk halaman hasil.php
$_SESSION['hasil_diagnosa'] = [
    'gejala_input' => $gejala_input,
    'kerusakan_id' => $kerusakan_id_terdeteksi,
    'rule_id' => $rule_id_terdeteksi
];

// Inisialisasi session riwayat jika belum ada
if (!isset($_SESSION['riwayat_diagnosa'])) {
    $_SESSION['riwayat_diagnosa'] = [];
}

// PERBAIKAN: Format penyimpanan disesuaikan dengan kebutuhan halaman riwayat.php
if ($kerusakan_id_terdeteksi !== null) {
    $_SESSION['riwayat_diagnosa'][] = [
        'waktu' => date('H:i') . " WIB",
        'kerusakan_id' => $kerusakan_id_terdeteksi,
        'gejala_terpilih' => $gejala_input
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menganalisis Gejala - Sistem Pakar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-blue: #1976d2; --bg-light: #f4f7fe; --text-muted: #718096; }
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .app-container { width: 100%; max-width: 412px; height: 844px; background: var(--bg-light); border-radius: 30px; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12); overflow: hidden; display: flex; flex-direction: column; position: relative; border: 4px solid #ffffff; }
        .mock-status-bar { background: var(--primary-blue); padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 500; color: #ffffff; z-index: 10; }
        .app-body { flex: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; position: relative; padding-bottom: 40px; }
        .loading-wrapper { width: 100%; display: flex; flex-direction: column; align-items: center; }
        .loading-card { width: 100%; background: #ffffff; border-radius: 24px; padding: 30px 20px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04); box-sizing: border-box; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .loading-icon-box { width: 100px; height: 100px; margin-bottom: 20px; display: flex; justify-content: center; align-items: center; background: #e8f0fe; border-radius: 50%; padding: 15px; }
        .loading-icon-box svg { width: 100%; height: auto; }
        .loading-title { font-size: 1.3rem; font-weight: 700; color: #1a202c; margin: 0 0 8px 0; }
        .loading-subtitle { font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; margin: 0 0 24px 0; padding: 0 10px; }
        .progress-list { width: 100%; display: flex; flex-direction: column; gap: 12px; box-sizing: border-box; }
        .progress-item { background: #ffffff; border: 1px solid #e2e8f0; padding: 14px 16px; border-radius: 16px; display: flex; align-items: center; gap: 12px; font-size: 0.9rem; font-weight: 600; color: var(--text-muted); transition: all 0.3s ease; box-sizing: border-box; }
        .progress-item.active { border-color: #bfdbfe; background: #eff6ff; color: var(--primary-blue); }
        .progress-item.success { border-color: #bbf7d0; background: #f0fdf4; color: #166534; }
        .status-icon { font-size: 1rem; display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; }
        .bottom-progress-bar { width: 100%; height: 8px; background: #e2e8f0; position: absolute; bottom: 0; left: 0; z-index: 5; }
        .progress-line { height: 100%; width: 0%; background: var(--primary-blue); transition: width 0.1s linear; }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="mock-status-bar"><span id="live-clock">00:00</span><span>📶 🔋</span></div>
        <div class="app-body">
            <div class="loading-wrapper">
                <div class="loading-card">
                    <div class="loading-icon-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#1976d2" stroke-width="1.5">
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                            <line x1="2" y1="20" x2="22" y2="20" stroke-width="2" />
                            <rect x="9" y="7" width="6" height="6" rx="1" fill="#e8f0fe" />
                            <line x1="16" y1="9" x2="19" y2="9" /><line x1="16" y1="11" x2="19" y2="11" />
                        </svg>
                    </div>
                    <h4 class="loading-title">Menganalisis Gejala...</h4>
                    <p class="loading-subtitle">Sistem sedang mencocokkan gejala dengan rule menggunakan metode Forward Chaining.</p>
                    <div class="progress-list">
                        <div class="progress-item success" id="step1"><span class="status-icon">✓</span> Membaca gejala</div>
                        <div class="progress-item" id="step2"><span class="status-icon" id="icon2">⏳</span> Mencocokkan rule</div>
                        <div class="progress-item" id="step3"><span class="status-icon" id="icon3">⏳</span> Forward Chaining</div>
                        <div class="progress-item" id="step4"><span class="status-icon" id="icon4">⏳</span> Menentukan hasil</div>
                    </div>
                </div>
            </div>
            <div class="bottom-progress-bar"><div class="progress-line" id="loadLine"></div></div>
        </div>
    </div>
    <script>
        function updateClock() { const now = new Date(); document.getElementById('live-clock').textContent = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0'); }
        setInterval(updateClock, 1000); updateClock();
        
        document.addEventListener("DOMContentLoaded", function () {
            const loadLine = document.getElementById("loadLine"), step2 = document.getElementById("step2"), step3 = document.getElementById("step3"), step4 = document.getElementById("step4");
            const icon2 = document.getElementById("icon2"), icon3 = document.getElementById("icon3"), icon4 = document.getElementById("icon4");
            let progress = 0; const duration = 2000, intervalTime = 50, steps = duration / intervalTime, increment = 100 / steps;
            const timer = setInterval(function () {
                progress += increment; if (progress > 100) progress = 100; loadLine.style.width = progress + "%";
                if (progress >= 25 && progress < 60) { step2.className = "progress-item success"; icon2.innerText = "✓"; step3.className = "progress-item active"; icon3.innerText = "🔄"; }
                if (progress >= 60 && progress < 90) { step3.className = "progress-item success"; icon3.innerText = "✓"; step4.className = "progress-item active"; icon4.innerText = "🔄"; }
                if (progress >= 90) { step4.className = "progress-item success"; icon4.innerText = "✓"; }
                if (progress >= 100) { clearInterval(timer); window.location.href = "hasil.php"; }
            }, intervalTime);
        });
    </script>
</body>
</html>