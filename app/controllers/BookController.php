<?php

/**
 * Book Controller
 *
 * This class handles all book-related operations.
 */
class BookController extends Controller
{
    /**
     * Display the book index page
     *
     * @param int $currentPage The current page number for pagination
     * @return void
     */
    public function index($currentPage = 1)
    {
        $limit = 10;
        $offset = ($currentPage - 1) * $limit;

        $bookModel = $this->model('Book');


        $books = $this->sanitizeArrayForOutput($bookModel->getBooksWithPagination($limit, $offset));

        $totalBooks = $bookModel->getTotalBooks();
        $totalPages = ceil($totalBooks / $limit);

        $this->view('books/index', [
            'books' => $books,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    /**
     * Display book details
     *
     * @param int $id The ID of the book
     * @return void
     */
    public function details($id)
    {
        $bookModel = $this->model('Book');
        $reviewModel = $this->model('Review');
        $book = $this->sanitizeArrayForOutput($bookModel->getBookById($id));
        $reviews = $this->sanitizeArrayForOutput($reviewModel->getReviewsByBookId($id));
        $this->view('books/details', ['book' => $book, 'reviews' => $reviews]);
    }
}
