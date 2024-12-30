<?php

/**
 * Review Controller
 *
 * This class handles all review-related operations.
 */
class ReviewController extends Controller
{

    /**
     * Get reviews for a specific book
     *
     * @param int $book_id The ID of the book
     * @return void Outputs JSON-encoded reviews
     */
    public function getReviews($book_id)
    {
        $reviewModel = $this->model('Review');
        $reviews = $reviewModel->getReviewsByBookId($book_id);
        header('Content-Type: application/json');
        echo json_encode($reviews);
    }

    /**
     * Add a new review
     *
     * @return void Outputs JSON response
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && isset($_POST['review_text']) && isset($_POST['rating'])) {
            $reviewModel = $this->model('Review');
            $bookModel = $this->model('Book');
            $book_id = filter_input(INPUT_POST, 'book_id', FILTER_SANITIZE_NUMBER_INT);
            $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
            $text = $_POST['review_text'];

            if ($rating > 0 && $rating < 6 && !empty($text)) {
                $result = $reviewModel->addReview($_SESSION['user_id'], $book_id, $rating, $text);
                if ($result) {
                    $newRating = $bookModel->getBookRating($book_id);
                    echo json_encode(['success' => true, 'newRating' => $newRating]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to add review']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid rating or empty review']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request']);
        }
        exit;
    }

    /**
     * Delete a review
     *
     * @return void Redirects to profile page
     */
    public function delete()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && isset($_POST['review_id'])) {
            $reviewModel = $this->model('Review');
            $review_id = $_POST['review_id'];

            $review = $reviewModel->getReviewById($review_id);

            if ($review) {
                if ($review['user_id'] == $_SESSION['user_id']) {
                    $reviewModel->deleteReview($review_id);
                }
            }

            $this->redirect('index.php?page=profile');
        } else {
            $this->redirect('index.php?page=home');
        }
    }
}
