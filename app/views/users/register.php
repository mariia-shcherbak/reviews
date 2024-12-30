<?php

/**
 * Registration Page
 *
 * This file contains the registration form for new users to create an account.
 *
 * @package BookReviews
 * @subpackage Users
 */
?>
<main class="container">
    <div class="form-container">
        <h2>Register</h2>
        <div>
            <!-- Display error messages -->
            <?php if (!empty($_SESSION['error'])): ?>
                <p class="error"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>
        <!-- Registration form -->
        <form id="register-form" method="POST" action="index.php?page=register" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <p class="error-message" id="username-error"></p>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <p class="error-message" id="email-error"></p>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <p class="error-message" id="password-error"></p>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <p class="error-message" id="confirm-password-error"></p>
            </div>
            <div class="form-group">
                <label for="profile-photo">Profile Photo:</label>
                <input type="file" id="profile-photo" name="profile-photo" accept="image/*" required>
                <p class="error-message" id="profile-photo-error"></p>
            </div>
            <button type="submit" class="form-submit">Register</button>
        </form>
    </div>
</main>