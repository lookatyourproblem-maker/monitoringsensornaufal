<?php
require("koneksi.php");

// Baca status dari file
$status_file = "status.txt";
if (!file_exists($status_file)) {
    file_put_contents($status_file, "OFF");
}
$status = trim(file_get_contents($status_file));

// Auto refresh hanya jika status = ON
if ($status === "ON") {
    echo '<meta http-equiv="refresh" content="5">';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Sensor</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #00A8A9, #007B7F);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .card {
            width: 80%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 0.8s ease-in-out;
        }

        .card-header {
            background: rgba(0, 168, 169, 0.85);
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            text-align: center;
            letter-spacing: 1px;
            position: relative;
        }

        .status {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            margin-top: 15px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* 🔁 Indikator Refresh */
        .refresh-indicator {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            color: #fff;
            opacity: 0;
            animation: fadeRefresh 5s ease-in-out infinite;
        }

        .refresh-indicator i {
            margin-right: 6px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeRefresh {
            0% {
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <form action="update_status.php" method="post" style="display:inline;">
                    <input type="hidden" name="status" value="ON">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-play-circle"></i> Start Read
                    </button>
                </form>
                <form action="update_status.php" method="post" style="display:inline;">
                    <input type="hidden" name="status" value="OFF">
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-stop-circle"></i> Stop Read
                    </button>
                </form>
                <button onclick="hapusData()" class="btn btn-warning btn-sm">
                    <i class="bi bi-trash3"></i> Hapus Data
                </button>
            </div>

            <?php if ($status === "ON"): ?>
                <div class="refresh-indicator">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
            <?php endif; ?>
        </div>

        <div class="status">
            <?php if ($status === "ON"): ?>
                <span class="text-success">🔄 Sedang Membaca Data...</span>
            <?php else: ?>
                <span class="text-danger">⛔ Pembacaan Dihentikan.</span>
            <?php endif; ?>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-info text-center">
                    <tr>
                        <th>No</th>
                        <th>Data</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = mysqli_query($koneksi, "SELECT * FROM datasensor ORDER BY id DESC");
                    if (mysqli_num_rows($sql) == 0) {
                        echo '<tr><td colspan="3" class="text-center">Data Tidak Ada.</td></tr>';
                    } else {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($sql)) {
                            echo "
                            <tr>
                                <td>{$no}</td>
                                <td>{$row['data']}</td>
                                <td>{$row['tanggal']}</td>
                            </tr>";
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <footer>
            <p>🌿 Sistem Monitoring Sensor | Made By Naufal Muttaqin Amri × ChatGPT</p>
        </footer>
    </div>

    <script>
        function hapusData() {
            if (confirm("⚠️ Yakin ingin menghapus semua data sensor?")) {
                window.location.href = "hapus_data.php";
            }
        }
    </script>
</body>

</html>