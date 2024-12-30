<?php
/**
 * Main Routing File
 *
 * This file handles the routing for the BookReviews application.
 * It determines which controller and method to call based on the 'page' GET parameter.
 *
 * @package BookReviews
 * @subpackage Routing
 */
require_once '../config/config.php';

// Get the requested page or set the default to 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

/**
 * Includes the header layout for the application.
 *
 * @return void
 */
function include_header()
{
    include '../app/views/layouts/header.php';
}

/**
 * Includes the footer layout for the application.
 *
 * @return void
 */
function include_footer()
{
    require_once '../app/views/layouts/footer.php';
}

// Route handling based on the requested page
switch ($page) {
    case 'home':
        /**
         * Home page: Displays a list of books with pagination.
         * Controller: BookController
         * Method: index
         */
        include_header();
        include '../app/controllers/BookController.php';
        $controller = new BookController();
        $currentPage = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
        $controller->index($currentPage);
        include_footer();
        break;

    case 'book':
        /**
         * Book details page: Shows detailed information about a specific book.
         * Controller: BookController
         * Method: details
         * Parameter: Book ID (via $_GET['id'])
         */
        include_header();
        include '../app/controllers/BookController.php';
        $controller = new BookController();
        $controller->details($_GET['id'] ?? null);
        include_footer();
        break;

    case 'login':
        /**
         * Login page: Handles user authentication.
         * Controller: UserController
         * Method: login
         */
        include_header();
        include '../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->login();
        include_footer();
        break;

    case 'register':
        /**
         * Registration page: Handles new user registration.
         * Controller: UserController
         * Method: register
         */
        include_header();
        include '../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->register();
        include_footer();
        break;

    case 'profile':
        /**
         * User profile page: Displays user details and reviews.
         * Controller: UserController
         * Method: profile
         */
        include_header();
        include '../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->profile();
        include_footer();
        break;

    case 'change-password':
        /**
         * Change password functionality for users.
         * Controller: UserController
         * Method: changePassword
         */
        include '../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->changePassword();
        break;

    case 'admin':
        /**
         * Admin dashboard: Displays administrative controls and statistics.
         * Controller: AdminController
         * Method: dashboard
         */
        include_header();
        include '../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        include_footer();
        break;

    case 'admin/add-book':
        /**
         * Add book functionality for admins.
         * Controller: AdminController
         * Method: addBook
         */
        include '../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->addBook();
        break;

    case 'admin/edit-book':
        /**
         * Edit book functionality for admins.
         * Controller: AdminController
         * Method: editBook
         */
        include_header();
        include '../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->editBook();
        include_footer();
        break;

    case 'admin/update-book':
        /**
         * Update book details in the database.
         * Controller: AdminController
         * Method: updateBook
         */
        include '../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->updateBook();
        break;

    case 'review/add':
        /**
         * Add a review for a book.
         * Controller: ReviewController
         * Method: add
         */
        include '../app/controllers/ReviewController.php';
        $controller = new ReviewController();
        $controller->add();
        break;

    case 'profile/delete-review':
        /**
         * Delete a user's review.
         * Controller: ReviewController
         * Method: delete
         */
        include '../app/controllers/ReviewController.php';
        $controller = new ReviewController();
        $controller->delete();
        break;

    case 'admin/make-admin':
        /**
         * Promote a user to admin role.
         * Controller: AdminController
         * Method: makeAdmin
         */
        include '../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->makeAdmin();
        break;

    case 'admin/remove-admin':
        /**
         * Remove admin privileges from a user.
         * Controller: AdminController
         * Method: unmakeAdmin
         */
        include '../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->unmakeAdmin();
        break;

    case 'admin/delete-book':
        /**
         * Delete a book from the system.
         * Controller: AdminController
         * Method: delete
         */
        include '../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->delete();
        break;

    case 'logout':
        /**
         * Logout functionality for users.
         * Controller: UserController
         * Method: logout
         */
        include '../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->logout();
        break;

    default:
        /**
         * Default case: Displays a 404 error page if the route is not recognized.
         */
        include_header();
        echo "<h1>404 - Страница не найдена</h1>";
        include_footer();
        break;
}
