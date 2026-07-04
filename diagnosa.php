<?php
/**
 * Proyek Akhir Semester (PAS) - Sistem Pakar Diagnosa Kerusakan Laptop
 * File: diagnosa.php (Halaman Pemilihan Gejala - Halaman 3)
 * Jalur Penyimpanan: project/diagnosa.php
 */

// Memuat data gejala secara aman dari folder data
require_once 'data/gejala.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Gejala - Sistem Pakar</title>
    
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="app-container">
        
        <div class="mock-status-bar" style="color: #ffffff; display: flex; justify-content: space-between; align-items: center; padding: 12px 24px; font-size: 0.85rem; font-weight: 500;">
            <span id="live-clock">00:00</span>
            <span>📶 🔋</span>
        </div>

        <div class="page-header">
            <a href="index.php" class="btn-back">&larr;</a>
            <span>Pilih Gejala</span>
        </div>

        <div class="app-body">
            <div class="instruction-box">
                <span class="instruction-text">Pilih gejala yang dialami laptop Anda</span>
                <span class="sub-instruction">(boleh memilih lebih dari satu)</span>
            </div>

            <form action="proses.php" method="POST" id="form-diagnosa">
                
                <div class="symptom-list">
                    <?php 
                    // Melakukan perulangan untuk menampilkan semua data gejala dari array data/gejala.php
                    foreach ($data_gejala as $kode => $nama_gejala) { 
                    ?>
                        <label class="symptom-item">
                            <input type="checkbox" name="gejala[]" value="<?php echo $kode; ?>">
                            <span class="symptom-label"><?php echo $kode . ' - ' . $nama_gejala; ?></span>
                        </label>
                    <?php 
                    } 
                    ?>
                </div>

                <div class="sticky-footer">
                    <button type="submit" class="btn-primary">
                        Proses Diagnosa
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script src="js/script.js"></script>

    <script>
        // 1. Eksekusi Jam Bergerak
        function updateClock() { 
            const now = new Date(); 
            const clock = document.getElementById('live-clock');
            if (clock) {
                clock.textContent = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`; 
            }
        }
        setInterval(updateClock, 1000); 
        updateClock();

        // 2. Mencegah Form Dikirim jika Pengguna Belum Memilih Gejala
        document.getElementById('form-diagnosa').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="gejala[]"]:checked');
            if (checkboxes.length === 0) {
                e.preventDefault(); // Batalkan pengiriman form
                alert('Silakan pilih minimal satu gejala laptop Anda terlebih dahulu sebelum memproses!');
            }
        });
    </script>
</body>
</html>