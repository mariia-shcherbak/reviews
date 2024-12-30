<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookReviews</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/styles.css">

</head>

<body>
    <header>
        <div class="container">
            <h1><a href="index.php">BookReviews</a></h1>
            <nav id="user-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=profile"><?php echo $_SESSION['username']; ?></a>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['is_admin']): ?>
                        <a href="index.php?page=admin">Admin Panel</a>
                    <?php endif; ?>
                    <a href="index.php?page=logout">Logout</a>
                <?php else: ?>
                    <a href="index.php?page=login">Login</a>
                    <a href="index.php?page=register">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
</body>