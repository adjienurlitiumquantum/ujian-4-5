<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'ujian4';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id > 0) {
    // Ambil artikel berdasarkan ID
    $query = "SELECT * FROM articles WHERE id = $article_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc(); // Menyimpan data artikel
    } else {
        die("Artikel tidak ditemukan.");
    }
} else {
    die("ID artikel tidak valid.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']); ?> - Blog</title>
    <link rel="stylesheet" href="portfolio.css">
</head>
<body>
<header class="navbar">
    <div class="logo">Blog Jasa CS</div>
    <nav>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Me</a></li>
            <li><a href="portfolio.php">Portfolio</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <!-- Judul Artikel -->
    <h1><?= htmlspecialchars($article['title']); ?></h1>

    <br>

    <!-- Gambar Artikel -->
    <div class="image-container">
        <img src="<?= htmlspecialchars($article['image_url']); ?>" alt="<?= htmlspecialchars($article['title']); ?>" class="blog-image-detail">
    </div>

    <br>

    <!-- Kategori Artikel -->
    <p><strong>Kategori:</strong> <?= htmlspecialchars($article['category']); ?></p>

    <!-- Tanggal Publikasi -->
    <p><strong>Dipublikasikan pada:</strong> <?= date('d M Y', strtotime($article['publish_date'])); ?></p>

    <br>

    <!-- Konten Artikel -->
    <div class="article-content">
        <p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
    </div>

    <!-- Nama Penulis -->
    <p><strong>Penulis: Adjie Nur</strong> <?= htmlspecialchars($article['author']); ?></p>

    <!-- Tautan Kembali ke Portfolio -->
    <a href="portfolio.php" class="btn-back">Kembali ke Portfolio</a>
</div>

<footer class="footer">
    <p>© 2024 Jasa Customer Service</p>
</footer>
</body>
</html>

<?php
$conn->close();
?>
