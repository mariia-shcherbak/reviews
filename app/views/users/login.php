<?php

/**
 * Login Page
 *
 * This file contains the login form for users to authenticate.
 *
 * @package BookReviews
 * @subpackage Users
 */
?>
<main class="container">
    <div class="form-container">
        <h2>Login</h2>
        <!-- Display error messages -->
        <?php if (!empty($_SESSION['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <!-- Login form -->
        <form id="login-form" method="POST" action="index.php?page=login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="form-submit">Login</button>
        </form>
    </div>
</main>