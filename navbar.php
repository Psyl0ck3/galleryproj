<div class="navbar" style="background-color: #001F3F; padding: 20px; text-align: center; margin-bottom: 50px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); display: flex; justify-content: space-between; align-items: center;">
    <h1 style="color: #FFFFFF; font-size: 2rem; margin: 0;">
        Welcome to UCOSnaps, 
        <span style="color: #3A6D8C;"><?php echo $_SESSION['username']; ?></span>
    </h1>
    <div style="display: flex; gap: 15px;">
        <a href="index.php" style="color: #FFFFFF; text-decoration: none; font-size: 1.2rem; transition: color 0.3s;">
            Home
        </a>
        <a href="yourProfile.php?username=<?php echo $_SESSION['username']; ?>" style="color: #FFFFFF; text-decoration: none; font-size: 1.2rem; transition: color 0.3s;">
            Your Profile
        </a>
        <a href="core/handleForms.php?logoutUserBtn=1" style="color: #FFFFFF; text-decoration: none; font-size: 1.2rem; transition: color 0.3s;">
            Logout
        </a>
    </div>
</div>
