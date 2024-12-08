<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['albumID'])) {
    die("Album ID is required.");
}

$albumID = $_GET['albumID'];

$getAlbum = $pdo->prepare("SELECT AlbumName, Description, DateCreated, user_id FROM Albums WHERE AlbumID = ?");
$getAlbum->execute([$albumID]);
$album = $getAlbum->fetch();

if (!$album) {
    die("Album not found.");
}

$getPhotos = $pdo->prepare("SELECT PhotoURL, Caption FROM Photos WHERE AlbumID = ?");
$getPhotos->execute([$albumID]);
$photos = $getPhotos->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($album['AlbumName']); ?></title>
    <style>
        :root {
            --custom-blue: #3A6D8C;
        }

        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }

        .albumPostWrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .albumPost {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .albumPost h2 {
            color: var(--custom-blue);
            font-size: 2em;
        }

        .albumPost p {
            font-size: 1.1em;
            color: #555;
        }

        .albumPost i {
            font-style: italic;
            color: #777;
        }

        .photo img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
        }

        .btn-back {
            background-color: var(--custom-blue);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #335c71;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="albumPostWrapper">
        <div class="albumPost">
            <h2><?php echo htmlspecialchars($album['AlbumName']); ?></h2>
            <p><i>Created on <?php echo htmlspecialchars($album['DateCreated']); ?></i></p>
            <p><?php echo htmlspecialchars($album['Description']); ?></p>

            <?php foreach ($photos as $photo): ?>
                <div class="photo" style="margin-top: 10px;">
                    <img src="images/<?php echo htmlspecialchars($photo['PhotoURL']); ?>" alt="Album Photo" style="width: 100%;">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <a href="index.php" class="btn-back">Back to Home</a>
</body>
</html>
