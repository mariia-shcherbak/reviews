<?php

/**
 * Books Index Page
 *
 * This file displays a grid of featured books with pagination.
 *
 * @package BookReviews
 * @subpackage Books
 */
?>
<main class="container">
    <div class="books-header">
        <h2>Featured Books</h2>
    </div>
    <!-- Pagination controls -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=home&page_number=<?php echo $currentPage - 1; ?>">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=home&page_number=<?php echo $i; ?>"
                class="<?php echo $i == $currentPage ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=home&page_number=<?php echo $currentPage + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
    <!-- Grid of book cards -->
    <div id="books-grid" class="books-grid">
        <?php foreach ($books as $book): ?>
            <?php $rating = $book['rating'] === null ? 0.0 : $book['rating']; ?>
            <!-- Individual book card -->
            <div class="book-card">
                <img src="<?php echo BASE_URL . '/' . htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                <div class="book-info">
                    <h3 class="book-title" title="<?php echo htmlspecialchars($book['title']); ?>">
                        <?php echo strlen($book['title']) > 20 ? substr($book['title'], 0, 20) . '...' : htmlspecialchars($book['title']); ?>
                    </h3>
                    <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>
                    <div class="book-rating">
                        <span class="stars"><?php echo str_repeat('★', round($rating)) . str_repeat('☆', 5 - round($rating)); ?></span>
                        <span class="rating-value"><?php echo number_format($rating, 1); ?></span>
                    </div>
                    <a href="index.php?page=book&id=<?php echo $book['id']; ?>" class="read-review">Read Review</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>