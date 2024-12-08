<?php
require_once 'core/dbConfig.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['albumID'])) {
    $albumID = $_GET['albumID'];

    $getAlbum = $pdo->prepare("SELECT AlbumID, AlbumName, Description, DateCreated, user_id FROM Albums WHERE AlbumID = ?");
    $getAlbum->execute([$albumID]);
    $album = $getAlbum->fetch();

    if (!$album || $album['user_id'] != $_SESSION['user_id']) {
        echo "You do not have permission to delete this album.";
        exit;
    }

    $getPhotos = $pdo->prepare("SELECT PhotoURL, Caption FROM Photos WHERE AlbumID = ?");
    $getPhotos->execute([$albumID]);
    $photos = $getPhotos->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmDelete'])) {
        try {
            $pdo->beginTransaction();

            $deletePhotos = $pdo->prepare("DELETE FROM Photos WHERE AlbumID = ?");
            $deletePhotos->execute([$albumID]);

            $deleteAlbum = $pdo->prepare("DELETE FROM Albums WHERE AlbumID = ?");
            $deleteAlbum->execute([$albumID]);

            $pdo->commit();

            header("Location: index.php?message=Album deleted successfully");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error deleting album: " . $e->getMessage();
            exit;
        }
    }
} else {
    echo "No album specified to delete.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Deletion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-danger">Confirm Deletion</h2>
                <p>Are you sure you want to delete this album? This action cannot be undone.</p>

                <div class="mb-3">
                    <h5 class="text-primary"><?php echo htmlspecialchars($album['AlbumName']); ?></h5>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($album['Description'] ?? 'No description available'); ?></p>
                    <p><strong>Created on:</strong> <?php echo htmlspecialchars($album['DateCreated']); ?></p>
                </div>

                <div class="row">
                    <h6 class="text-secondary">Photos in this Album:</h6>
                    <?php if ($photos): ?>
                        <div class="d-flex flex-wrap gap-3">
                            <?php foreach ($photos as $photo): ?>
                                <div class="card" style="width: 150px;">
                                    <img src="images/<?php echo htmlspecialchars($photo['PhotoURL']); ?>" class="card-img-top" alt="Photo">
                                    <div class="card-body p-2">
                                        <p class="card-text small"><?php echo htmlspecialchars($photo['Caption']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No photos in this album.</p>
                    <?php endif; ?>
                </div>

                <form action="" method="POST" class="mt-4">
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="confirmDelete" value="yes" class="btn btn-danger">Yes, Delete Album</button>
                        <a href="index.php" class="btn btn-secondary">No, Go Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
