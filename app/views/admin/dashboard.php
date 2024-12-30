<?php

/**
 * Admin Dashboard
 *
 * This file contains the HTML structure for the admin dashboard.
 * It displays forms for adding new books and tables for managing users and books.
 *
 * @package BookReviews
 * @subpackage Admin
 */
?>
<!-- Display error message if exists -->
<div>
    <?php if (!empty($_SESSION['error'])): ?>
        <!-- Error message output -->
        <p class="error"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
</div>

<!-- Form for adding a new book -->
<form method="POST" action="index.php?page=admin/add-book" class="form-container" enctype="multipart/form-data" id="add-book-form">
    <div class="form-group">
        <!-- Book title input -->
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <div id="title-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <!-- Book author input -->
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>
        <div id="author-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <!-- Book description input -->
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <div id="description-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <!-- Number of pages input -->
        <label for="pages">Pages:</label>
        <input type="number" id="pages" name="pages" required>
        <div id="pages-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <!-- Publisher input -->
        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" name="publisher" required>
        <div id="publisher-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <!-- Publication year input -->
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required>
        <div id="year-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <!-- Country input -->
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required>
        <div id="country-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <!-- Book cover image upload -->
        <label for="image">Book Cover:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <div id="book-cover-error" class="error-message"></div>
    </div>
    <!-- Submit button for adding a book -->
    <button type="submit" name="add_book" class="form-submit">Add Book</button>
</form>

<!-- Section for managing users -->
<div class="admin-table-container">
    <h2>Manage Users</h2>
    <table>
        <!-- Table header -->
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Admin Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <!-- User details -->
                    <td data-label="User ID"><?php echo $user['id']; ?></td>
                    <td data-label="Username"><?php echo htmlspecialchars($user['username']); ?></td>
                    <td data-label="Email"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td data-label="Admin Status"><?php echo $user['is_admin'] ? 'Admin' : 'User'; ?></td>
                    <td data-label="Actions">
                        <?php if ($user['is_admin']): ?>
                            <!-- Form to remove admin rights -->
                            <form method="post" action="index.php?page=admin/remove-admin">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="delete-btn">Remove Admin</button>
                            </form>
                        <?php else: ?>
                            <!-- Form to grant admin rights -->
                            <form method="post" action="index.php?page=admin/make-admin">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="make-admin">Make Admin</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Section for managing books -->
<div class="admin-table-container">
    <h2>Manage Books</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <!-- Book details -->
                    <td data-label="ID"><?php echo $book['id']; ?></td>
                    <td data-label="Title"><?php echo htmlspecialchars($book['title']); ?></td>
                    <td data-label="Author"><?php echo htmlspecialchars($book['author']); ?></td>
                    <td data-label="Actions">
                        <!-- Form to edit the book -->
                        <form method="get" action="index.php" style="display: inline;">
                            <input type="hidden" name="page" value="admin/edit-book">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" class="edit-book">Edit</button>
                        </form>
                        <!-- Form to delete the book -->
                        <form method="post" action="index.php?page=admin/delete-book" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" class="delete-btn">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>