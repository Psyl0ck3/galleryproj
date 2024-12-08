<?php
require_once 'core/dbConfig.php';  

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  
    exit();
}

$getAlbums = $pdo->prepare("SELECT AlbumID, AlbumName, Description, DateCreated FROM Albums WHERE user_id = ? ORDER BY DateCreated DESC");
$getAlbums->execute([$_SESSION['user_id']]);
$albums = $getAlbums->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - Albums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Blue Color */
        :root {
            --custom-blue: #3A6D8C; /* Replace this with your specific blue hex code */
        }

        body {
            background-color: #f4f7fa;
        }

        .btn-custom {
            background-color: var(--custom-blue);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #001f3f; /* Darker shade of blue for hover effect */
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
<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header text-center py-4">
                <h1>Your Albums</h1>
            </div>

            <div class="card-body">
                <?php if (count($albums) > 0): ?>
                    <div class="row">
                        <?php foreach ($albums as $album): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($album['AlbumName']); ?></h5>
                                        <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($album['Description'] ?? 'No description available'); ?></p>
                                        <p class="card-text"><strong>Created on:</strong> <?php echo htmlspecialchars($album['DateCreated']); ?></p>

                                        <?php
                                        $getFirstPhoto = $pdo->prepare("SELECT PhotoURL FROM Photos WHERE AlbumID = ? LIMIT 1");
                                        $getFirstPhoto->execute([$album['AlbumID']]);
                                        $firstPhoto = $getFirstPhoto->fetch();
                                        ?>

                                        <?php if ($firstPhoto): ?>
                                            <div class="album-photo" style="margin-top: 10px;">
                                                <img src="images/<?php echo htmlspecialchars($firstPhoto['PhotoURL']); ?>" alt="Album Photo" class="img-fluid rounded">
                                            </div>
                                        <?php else: ?>
                                            <p>No photos in this album yet.</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-footer text-center">
                                        <a href="viewAlbum.php?albumID=<?php echo $album['AlbumID']; ?>" class="btn-custom btn-sm">View Album</a> | 
                                        <a href="editAlbum.php?albumID=<?php echo $album['AlbumID']; ?>" class="btn-custom btn-sm">Edit Album</a> | 
                                        <a href="deleteAlbum.php?albumID=<?php echo $album['AlbumID']; ?>" class="btn-custom btn-sm">Delete Album</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">You have not created any albums yet.</p>
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
