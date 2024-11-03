<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'acara_9'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengambil data dari tabel acara9
    $query = $pdo->query("SELECT id, name, latitude, longitude FROM locations");
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place to go DKI Jakarta</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        body {
            font-family: monospace, monospace;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
            background-color: #FFCCFF;
            /* Contoh warna latar belakang */
        }

        h1,
        h2 { text-align: center;
        }

        /* Navbar */
        .navbar {
            width: 100%;
            background-color: #ed0575;
            /* Warna latar belakang navbar */
            overflow: hidden;
        }

        .navbar a {
            float: right;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 90%;
            max-width: 1000px;
            margin-top: 20px;
        }

        #table-container {
            width: 100%;
            /* Full width for table */
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #ed0575;
            color: white;
            padding: 10px;
        }

        #map {
            width: 100%;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            height: 500px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="#info">Informasi</a>
    </div>

    <h1>DKI JAKARTA</h1>

    <div class="container">
        <!-- Tabel Data -->
        <div id="table-container">
            <table>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>latitude</th>
                    <th>longitude</th>
                    <th>Actions</th> <!-- Kolom baru untuk aksi -->
                </tr>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['latitude'] ?></td>
                        <td><?= $row['longitude'] ?></td>
                        <td>
                            <!-- Tombol Edit dan Delete -->
                            <button onclick="editLocation(<?= $row['id'] ?>)">Edit</button>
                            <button onclick="deleteLocation(<?= $row['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Peta -->
        <div id="map"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Inisialisasi peta
        var map = L.map("map").setView([-6.1751, 106.8650], 12);

        // Tile Layer
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        // Menambahkan marker berdasarkan data dari PHP
        <?php foreach ($data as $row): ?>
            L.marker([<?= $row['latitude'] ?>, <?= $row['longitude'] ?>]).addTo(map)
                .bindPopup("<b><?= $row['name'] ?></b>");
        <?php endforeach; ?>

        // Fungsi Delete
        function deleteLocation(id) {
            if (confirm("Lokasi ini akan dihapus?")) {
                fetch(`delete.php?id=${id}`, {
                        method: 'GET'
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "success") {
                            alert("Lokasi berhasil dihapus");
                            location.reload(); // Refresh halaman setelah melakukan delete
                        } else {
                            alert("Gagal menghapus lokasi.");
                        }
                    });
            }
        }

        // Fungsi Edit
        function editLocation(id) {
            const newName = prompt("Isikan nama lokasi:");
            if (newName) {
                fetch(`edit.php?id=${id}&name=${encodeURIComponent(newName)}`, {
                        method: 'GET'
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "success") {
                            alert("Berhasil merubah lokasi");
                            location.reload(); // Refresh halaman melakukan edit
                        } else {
                            alert("Gagal merubah lokasi.");
                        }
                    });
            }
        }
    </script>
</body>

</html>