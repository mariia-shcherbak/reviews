<?php

/**
 * User Profile Page
 *
 * This file displays the user's profile information, a form to change password,
 * and a list of the user's reviews.
 *
 * @package BookReviews
 * @subpackage Users
 */
?>
<main class="container">
    <h2 style="color: var(--primary-color);">User Profile</h2>
    <!-- User information section -->
    <div>
        <?php if (!empty($user)): ?>
            <?php if (!empty($user['profile_photo'])): ?>
                <img src="<?php echo htmlspecialchars($user['profile_photo'], ENT_QUOTES, 'UTF-8'); ?>" class="profile-photo" alt="Profile Photo">
            <?php else: ?>
                <p>No profile photo available.</p>
            <?php endif; ?>

            <div class="profile-details">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php else: ?>
            <p>User not found. Please <a href="index.php?page=login">log in</a>.</p>
        <?php endif; ?>
    </div>

    <!-- Error and success messages -->
    <div>
        <?php if (!empty($_SESSION['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>

    <h3>Change Password</h3>
    <!-- Change password form -->
    <form method="POST" action="index.php?page=change-password" id="change-password">
        <div class="form-group">
            <label for="current-password">Current Password:</label>
            <input type="password" id="current-password" name="current_password" required>
            <div id="current-password-error" class="error-message"></div>
        </div>
        <div class="form-group">
            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new_password" required>
            <div id="new-password-error" class="error-message"></div>
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm New Password:</label>
            <input type="password" id="confirm-password" name="confirm_password" required>
            <div id="confirm-password-error" class="error-message"></div>
        </div>
        <div class="error-messages"></div>
        <button type="submit" class="form-submit">Update Password</button>
    </form>

    <!-- User's reviews list -->
    <div id="reviews-list" class="review-section">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <div class="review-header">
                        <span class="review-rating">
                            <?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?>
                        </span>
                        <form method="POST" action="index.php?page=profile/delete-review">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" name="delete_review" class="delete-btn">Delete</button>
                        </form>
                    </div>
                    <p class="review-text"><?php echo htmlspecialchars($review['text']); ?></p>
                    <p><a href="index.php?page=book&id=<?php echo $review['book_id']; ?>">View the book</a></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to review this book!</p>
        <?php endif; ?>
    </div>
</main>