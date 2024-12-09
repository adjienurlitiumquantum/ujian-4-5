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

// Konfigurasi pagination
$articles_per_page = 3; // Jumlah artikel per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $articles_per_page;

// Query data artikel dengan pagination
$query = "SELECT * FROM articles ORDER BY publish_date DESC LIMIT $articles_per_page OFFSET $offset";
$result = $conn->query($query);

// Hitung total artikel untuk pagination
$total_query = "SELECT COUNT(*) AS total FROM articles";
$total_result = $conn->query($total_query);
$total_articles = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_articles / $articles_per_page);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Blog Jasa CS</title>
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
    <h1>Artikel Terbaru</h1>
    <div class="blog-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="blog-card">
                <img src="<?= $row['image_url']; ?>" alt="<?= $row['title']; ?>" class="blog-image">
                <div class="blog-content">
                    <div class="blog-date">
                        <span><?= date('d', strtotime($row['publish_date'])); ?></span>
                        <p><?= date('M Y', strtotime($row['publish_date'])); ?></p>
                    </div>
                    <p class="blog-category"><?= $row['category']; ?></p>
                    <h3><?= $row['title']; ?></h3>
                    <a href="detail.php?id=<?= $row['id']; ?>" class="read-more">Read More →</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <nav class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i; ?>" class="<?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </nav>
</div>

<footer class="footer">
    <p>© 2024 Jasa Customer Service</p>
</footer>
</body>
</html>

<?php
$conn->close();
?>
