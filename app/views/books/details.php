<?php

/**
 * Book Details Page
 *
 * This file displays detailed information about a specific book,
 * including its reviews and a form for adding new reviews.
 *
 * @package BookReviews
 * @subpackage Books
 */
?>
<main class="container">
    <div id="book-details" class="book-details">
        <!-- Book details section -->
        <div class="book-details-content">
            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="book-details-image">
            <div class="book-details-info">
                <h2><?php echo $book['title']; ?></h2>
                <p class="book-author">by <?php echo htmlspecialchars($book['author']); ?></p>
                <div class="book-rating">
                    <?php $rating = $book['rating'] === null ? 0.0 : $book['rating']; ?>
                    <span class="stars"><?php echo str_repeat('★', round($rating)) . str_repeat('☆', 5 - round($rating)); ?></span>
                    <span class="rating-value"><?php echo number_format($rating, 1); ?></span>
                </div>
                <p class="book-description"><?php echo htmlspecialchars($book['description']); ?></p>
                <div class="book-metadata">
                    <p><strong>Pages:</strong> <?php echo htmlspecialchars($book['pages']); ?></p>
                    <p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher']); ?></p>
                    <p><strong>Year:</strong> <?php echo htmlspecialchars($book['year']); ?></p>
                    <p><strong>Country:</strong> <?php echo htmlspecialchars($book['country']); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Reviews section -->
    <div id="review-section" class="review-section">
        <h3>Reviews</h3>
        <!-- Review form (if user is logged in) -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div id="review-message"></div>
            <form id="review-form" class="review-form" method="POST" action="index.php?page=review/add">
                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                    <input type="radio" id="star1" name="rating" value="1" required><label for="star1"></label>
                </div>
                <textarea id="review-text" name="review_text" placeholder="Write your review here" required></textarea>

                <button type="submit">Submit Review</button>
            </form>
        <?php endif; ?>
        <!-- List of reviews -->
        <div id="reviews-list" class="reviews-list">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <div class="review-header">
                            <span class="review-author"><?php echo htmlspecialchars($review['username']); ?></span>
                            <span class="review-rating">
                                <?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?>
                            </span>
                        </div>
                        <p class="review-text"><?php echo htmlspecialchars($review['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to review this book!</p>
            <?php endif; ?>
        </div>
    </div>
</main>