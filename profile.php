<?php 
require_once 'core/dbConfig.php';  

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

$userID = isset($_GET['userID']) ? $_GET['userID'] : null;
if (!$userID) {
    header("Location: index.php");  
    exit();
}

$getUserProfile = $pdo->prepare("SELECT username FROM user_accounts WHERE user_id = ?");
$getUserProfile->execute([$userID]);
$userProfile = $getUserProfile->fetch();

$getUserAlbums = $pdo->prepare("SELECT AlbumID, AlbumName, Description, DateCreated FROM Albums WHERE user_id = ? ORDER BY DateCreated DESC");
$getUserAlbums->execute([$userID]);
$userAlbums = $getUserAlbums->fetchAll();

$photosByAlbum = [];
foreach ($userAlbums as $album) {
    $albumID = $album['AlbumID'];
    $getPhotos = $pdo->prepare("SELECT PhotoURL, Caption FROM Photos WHERE AlbumID = ?");
    $getPhotos->execute([$albumID]);
    $photosByAlbum[$albumID] = $getPhotos->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($userProfile['username']); ?>'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        :root {
            --custom-blue: #3A6D8C; 
        }

        body {
            background-color: #f4f7fa;
        }

        .btn-custom {
            background-color: var(--custom-blue);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 6px 12px;  
            font-size: 14px; 
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #001f3f;
        }

        .card-header {
            background-color: var(--custom-blue);
            color: white;
        }

        .card-footer {
            background-color: #f9f9f9;
        }

        .album-photo img {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .albums-list .card {
            border: 1px solid #ddd;
        }

        .albums-list .card-body {
            padding: 20px;
        }

        .album .card-title {
            font-weight: bold;
            color: var(--custom-blue);
        }

        .album .card-text {
            color: #555;
        }

        .album .card-footer a {
            color: var(--custom-blue);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .album .card-footer a:hover {
            color: #001f3f;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header text-center py-4">
                <h1 class="text-white"><?php echo htmlspecialchars($userProfile['username']); ?>'s Profile</h1>
            </div>

            <div class="card-body">
                <h2 class="my-4">Albums</h2>
                <?php if (count($userAlbums) > 0): ?>
                    <div class="row">
                        <?php foreach ($userAlbums as $album): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($album['AlbumName']); ?></h5>
                                        <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($album['Description'] ?? 'No description available'); ?></p>
                                        <p class="card-text"><strong>Created on:</strong> <?php echo htmlspecialchars($album['DateCreated']); ?></p>

                                        <?php
                                        $photoCount = count($photosByAlbum[$album['AlbumID']]);
                                        $photosToShow = array_slice($photosByAlbum[$album['AlbumID']], 0, 3);
                                        ?>
                                        <div class="row">
                                            <?php foreach ($photosToShow as $photo): ?>
                                                <div class="col-4">
                                                    <img src="images/<?php echo htmlspecialchars($photo['PhotoURL']); ?>" alt="Album Photo" class="img-fluid rounded mb-2">
                                                    <p class="text-center"><?php echo htmlspecialchars($photo['Caption'] ?? 'No caption available'); ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <?php if ($photoCount > 3): ?>
                                            <a href="viewAlbum.php?albumID=<?php echo $album['AlbumID']; ?>" class="btn-custom btn-sm">See more photos</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">This user has not created any albums yet.</p>
                <?php endif; ?>
            </div>

            <div class="card-footer text-center">
                <a href="index.php" class="btn-custom">Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
