<?php  
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$getAlbums = $pdo->prepare("
    SELECT Albums.AlbumID, Albums.AlbumName, Albums.Description, Albums.DateCreated, user_accounts.username, Albums.user_id
    FROM Albums
    LEFT JOIN user_accounts ON Albums.user_id = user_accounts.user_id
    ORDER BY Albums.DateCreated DESC
");
$getAlbums->execute();
$albums = $getAlbums->fetchAll();

$photosByAlbum = [];
foreach ($albums as $album) {
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
    <title>Album Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
 
        <div class="card mb-4 shadow">
            <div class="card-body">
                <h5 class="card-title">Create a New Album</h5>
                <form action="core/handleForms.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label for="albumName" class="form-label">Album Name</label>
                        <input type="text" name="albumName" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="albumDescription" class="form-label">Album Description</label>
                        <textarea name="albumDescription" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="insertAlbumBtn" class="btn btn-primary">Create Album</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Album Posts -->
        <?php foreach ($albums as $album): ?>
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-primary">
                            <a href="profile.php?userID=<?php echo $album['user_id']; ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($album['username']); ?>
                            </a>
                        </h5>
                        <small class="text-muted"><?php echo htmlspecialchars($album['DateCreated']); ?></small>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($album['AlbumName']); ?></h6>
                    <p class="card-text"><?php echo htmlspecialchars($album['Description'] ?? 'No description available'); ?></p>

                    <!-- Photo Gallery -->
                    <div class="row">
                        <?php
                        $photoCount = count($photosByAlbum[$album['AlbumID']]);
                        $photosToShow = array_slice($photosByAlbum[$album['AlbumID']], 0, 3);
                        ?>
                        <?php foreach ($photosToShow as $photo): ?>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <img src="images/<?php echo htmlspecialchars($photo['PhotoURL']); ?>" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="<?php echo htmlspecialchars($photo['Caption'] ?? 'No caption available'); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($photoCount > 3): ?>
                        <a href="viewAlbum.php?albumID=<?php echo $album['AlbumID']; ?>" class="btn btn-link">See More</a>
                    <?php endif; ?>

                    <?php if ($album['user_id'] == $_SESSION['user_id']): ?>
                        <div class="mt-3">
                            <a href="editAlbum.php?albumID=<?php echo $album['AlbumID']; ?>" class="btn btn-outline-secondary btn-sm">Edit Album</a>
                            <a href="deleteAlbum.php?albumID=<?php echo $album['AlbumID']; ?>" class="btn btn-outline-danger btn-sm">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
