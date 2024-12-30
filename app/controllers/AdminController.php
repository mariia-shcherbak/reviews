<?php
/**
 * Admin Controller
 *
 * This class handles all admin-related operations.
 */
class AdminController extends Controller
{

    /**
     * Constructor
     * 
     * Checks if the user is an admin, redirects to home if not.
     */
    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
            $this->redirect('index.php?page=home');
        }
    }

    /**
     * Get data for the admin dashboard
     *
     * @return array Data for the admin dashboard
     */
    private function getDashboardData()
    {
        $bookModel = $this->model('Book');
        $userModel = $this->model('User');
        $books = $bookModel->getAllBooks();
        $users = $userModel->getAllUsers();

        return [
            'books' => $books,
            'users' => $users,
        ];
    }

    /**
     * Display the admin dashboard
     *
     * @return void
     */
    public function dashboard()
    {
        $this->view('admin/dashboard', $this->getDashboardData());
    }

    /**
     * Make a user an admin
     *
     * @return void Redirects to admin dashboard
     */
    public function makeAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

            $userModel->makeAdmin($user_id);
            $this->redirect('index.php?page=admin');
        }
    }

    /**
     * Remove admin status from a user
     *
     * @return void Redirects to admin dashboard
     */
    public function unmakeAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

            $userModel->unmakeAdmin($user_id);
            $this->redirect('index.php?page=admin');
        }
    }

    /**
     * Upload a book cover image
     *
     * @param array $file The uploaded file data
     * @return string|false The path to the uploaded file, or false on failure
     */
    private function uploadBookCover($file)
    {
        $target_dir = "uploads/books/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));


        $uniqueName = uniqid('profile_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueName;


        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return false;
        }


        if ($file["size"] > 1000000) {
            return false;
        }


        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            return false;
        }

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            return false;
        }
    }

    /**
     * Delete a book
     *
     * @return void Redirects to admin dashboard
     */
    public function delete()
    {
        if (!isset($_POST['book_id'])) {
            return;
        }

        $bookId = filter_input(INPUT_POST, 'book_id', FILTER_SANITIZE_NUMBER_INT);
        $bookModel = $this->model('Book');
        $bookModel->deleteBook($bookId);

        $this->redirect('index.php?page=admin');
    }

    /**
     * Validate book data
     *
     * @param string $title The book title
     * @param string $author The book author
     * @param string $description The book description
     * @param int $pages The number of pages
     * @param string $publisher The book publisher
     * @param int $year The publication year
     * @param string $country The country of publication
     * @return array An array of validation errors
     */
    private function validateBookData($title, $author, $description, $pages, $publisher, $year, $country)
    {
        $errors = [];

        if (strlen($title) < 3) {
            $errors['title'] = 'Title must be at least 3 characters long.';
        }

        if (strlen($author) < 3) {
            $errors['author'] = 'Author name must be at least 3 characters long.';
        }

        if (strlen($description) < 10) {
            $errors['description'] = 'Description must be at least 10 characters long.';
        }

        if (!is_numeric($pages) || $pages <= 0) {
            $errors['pages'] = 'Please enter a valid number of pages.';
        }

        if (strlen($publisher) < 3) {
            $errors['publisher'] = 'Publisher name must be at least 3 characters long.';
        }

        if (!is_numeric($year) || $year <= 0 || $year > date('Y')) {
            $errors['year'] = 'Please enter a valid publication year.';
        }

        if (strlen($country) < 3) {
            $errors['country'] = 'Country name must be at least 3 characters long.';
        }

        return $errors;
    }

    /**
     * Add a new book
     *
     * @return void Redirects to admin dashboard
     */
    public function addBook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bookModel = $this->model('Book');

            $title = $_POST['title'] ?? null;
            $author = $_POST['author'] ?? null;
            $description = $_POST['description'] ?? null;
            $pages = $_POST['pages'] ?? null;
            $publisher = $_POST['publisher'] ?? null;
            $year = $_POST['year'] ?? null;
            $country = $_POST['country'] ?? null;


            $errors = $this->validateBookData($title, $author, $description, $pages, $publisher, $year, $country);

            if (empty($errors)) {
                if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $errors['image'] = "Book cover image is required.";
                } else {
                    $image_path = $this->uploadBookCover($_FILES['image']);
                    if (!$image_path) {
                        $errors['image'] = "Failed to upload book cover image.";
                    }
                }
            }


            if (!$bookModel->addBook($title, $author, $description, $pages, $publisher, $year, $country, $image_path)) {
                $_SESSION['error'] = "Failed to add book. Please try again.";
            }

            if (!empty($errors)) {
                $_SESSION['error'] = implode(' ', $errors);
                $this->redirect('index.php?page=admin/add-book');
                exit;
            }
        }
        $this->redirect('index.php?page=admin');
    }


    /**
     * Display the edit book form
     *
     * @return void
     */
    public function editBook()
    {
        if (!isset($_GET['book_id'])) {
            header('Location: index.php?page=admin');
            exit();
        }

        $bookModel = $this->model('Book');
        $book = $bookModel->getBookById($_GET['book_id']);

        if (!$book) {
            $this->redirect('index.php?page=admin');
        }

        $this->view('admin/edit-book', ['book' => $book]);
    }

    /**
     * Update a book
     *
     * @return void Redirects to admin dashboard
     */
    public function updateBook()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->redirect('index.php?page=admin');
        }

        $bookModel = $this->model('Book');
        $bookId = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? null;
        $author = $_POST['author'] ?? null;
        $description = $_POST['description'] ?? null;
        $pages = $_POST['pages'] ?? null;
        $publisher = $_POST['publisher'] ?? null;
        $year = $_POST['year'] ?? null;
        $country = $_POST['country'] ?? null;


        $errors = $this->validateBookData($title, $author, $description, $pages, $publisher, $year, $country);

        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_path = $this->uploadBookCover($_FILES['image']);
            if (!$image_path) {
                $errors['image'] = "Failed to upload book cover image.";
            }
        }

        if (empty($errors)) {
            if ($bookModel->updateBook($bookId, $title, $author, $description, $pages, $publisher, $year, $country, $image_path)) {
                $this->redirect('/index.php?page=admin');
            } else {
                $errors['general'] = "Failed to update book. Please try again.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
            $this->redirect("index.php?page=admin%2Fedit-book&book_id={$bookId}");
            exit;
        }
    }
}
