<?php

/**
 * Edit Book Page
 *
 * This file contains the form for editing an existing book's details.
 *
 * @package BookReviews
 * @subpackage Admin
 */

require_once '../app/views/layouts/header.php';
?>

<!-- Page heading -->
<h2>Edit Book</h2>

<!-- Display error message if any -->
<?php if (!empty($_SESSION['error'])): ?>
    <p class="error"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Form for editing book details -->
<form action="index.php?page=admin/update-book" method="post" class="form-container" enctype="multipart/form-data" id="edit-book-form">
    <!-- Hidden input to store book ID -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']); ?>">

    <!-- Book title input -->
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        <div id="title-error" class="error-message"></div>
    </div>

    <!-- Book author input -->
    <div class="form-group">
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
        <div id="author-error" class="error-message"></div>
    </div>

    <!-- Book description input -->
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($book['description']); ?></textarea>
        <div id="description-error" class="error-message"></div>
    </div>

    <!-- Number of pages input -->
    <div class="form-group">
        <label for="pages">Pages:</label>
        <input type="number" id="pages" name="pages" value="<?php echo htmlspecialchars($book['pages']); ?>" required>
        <div id="pages-error" class="error-message"></div>
    </div>

    <!-- Publisher input -->
    <div class="form-group">
        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>" required>
        <div id="publisher-error" class="error-message"></div>
    </div>

    <!-- Publication year input -->
    <div class="form-group">
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($book['year']); ?>" required>
        <div id="year-error" class="error-message"></div>
    </div>

    <!-- Country input -->
    <div class="form-group">
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($book['country']); ?>" required>
        <div id="country-error" class="error-message"></div>
    </div>

    <!-- Book cover input -->
    <div class="form-group">
        <label for="image">Book Cover:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <p>Current cover: <?php echo htmlspecialchars($book['image']); ?></p>
        <div id="image-error" class="error-message"></div>
    </div>

    <!-- Submit button for updating the book -->
    <button type="submit" class="form-submit">Update Book</button>
</form>

<?php
require_once '../app/views/layouts/footer.php';
?>