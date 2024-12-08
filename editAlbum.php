<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_GET['albumID'])) {
    header("Location: index.php");
    exit;
}

$albumID = $_GET['albumID'];
$getAlbumDetails = $pdo->prepare("SELECT Albums.AlbumID, Albums.AlbumName, Albums.Description, Albums.DateCreated, 
                                      user_accounts.username, Albums.user_id as album_user_id
                                   FROM Albums
                                   LEFT JOIN user_accounts ON Albums.user_id = user_accounts.user_id
                                   WHERE Albums.AlbumID = ?");
$getAlbumDetails->execute([$albumID]);
$album = $getAlbumDetails->fetch();

$getAlbumPhotos = $pdo->prepare("SELECT PhotoID, PhotoURL, Caption FROM Photos WHERE AlbumID = ?");
$getAlbumPhotos->execute([$albumID]);
$photos = $getAlbumPhotos->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-sm p-4">

            <div class="card-header">
                <h1>Edit Album</h1>
            </div>

            <div class="card-body">
                <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="albumID" value="<?php echo htmlspecialchars($album['AlbumID']); ?>">

                    <div class="mb-3">
                        <label for="albumName" class="form-label">Album Name</label>
                        <input type="text" name="albumName" class="form-control" value="<?php echo htmlspecialchars($album['AlbumName']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="albumDescription" class="form-label">Album Description</label>
                        <textarea name="albumDescription" class="form-control" required><?php echo htmlspecialchars($album['Description']); ?></textarea>
                    </div>

                    <button type="submit" name="updateAlbumBtn" class="btn btn-primary">Update Album</button>
                </form>
            </div>

            <div class="card-footer">
                <h3>Upload New Photos</h3>
                <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="albumID" value="<?php echo htmlspecialchars($album['AlbumID']); ?>">
                    <div class="mb-3">
                        <label for="images" class="form-label">Upload Photos</label>
                        <input type="file" name="images[]" class="form-control" multiple required>
                    </div>
                    <button type="submit" name="insertPhotoBtn" class="btn btn-success">Upload Photos</button>
                </form>
            </div>
        </div>

        <div class="mt-4">
            <h3>Existing Photos</h3>
            <?php if (count($photos) > 0): ?>
                <div class="row">
                    <?php foreach ($photos as $photo): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="images/<?php echo htmlspecialchars($photo['PhotoURL']); ?>" class="card-img-top" alt="Album Photo">
                                <div class="card-body">
                                    <p class="card-text"><?php echo htmlspecialchars($photo['Caption'] ?? ''); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No photos uploaded yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
