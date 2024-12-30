<?php
/**
 * Review Model
 *
 * This class handles all database operations related to reviews.
 */
class Review {
    /** @var mysqli Database connection */
    private $db;
    
    /**
     * Constructor
     * 
     * Initializes the database connection.
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }


    /**
     * Get reviews for a specific book
     *
     * @param int $book_id The ID of the book
     * @return array An array of reviews for the specified book
     */
    public function getReviewsByBookId($book_id) {
        $stmt = $this->db->prepare("SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.book_id = ? ORDER BY r.created_at DESC");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Add a new review
     *
     * @param int $user_id The ID of the user submitting the review
     * @param int $book_id The ID of the book being reviewed
     * @param int $rating The rating given in the review
     * @param string $text The text content of the review
     * @return bool True if the review was added successfully, false otherwise
     */
    public function addReview($user_id, $book_id, $rating, $text) {
        $stmt = $this->db->prepare("INSERT INTO reviews (user_id, book_id, rating, text) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $user_id, $book_id, $rating, $text);
        return $stmt->execute();
    }
    
    /**
     * Delete a review
     *
     * @param int $review_id The ID of the review to be deleted
     * @return bool True if the review was deleted successfully, false otherwise
     */
    public function deleteReview($review_id) {
        $stmt = $this->db->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $review_id);
        return $stmt->execute();
    }

    /**
     * Get a specific review by its ID
     *
     * @param int $review_id The ID of the review
     * @return array|null The review data, or null if not found
     */
    public function getReviewById($review_id) {
        $stmt = $this->db->prepare("SELECT r.*, b.title FROM reviews r JOIN books b ON r.book_id = b.id WHERE r.id = ?");
        $stmt->bind_param("i", $review_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
  
    /**
     * Get all reviews by a specific user
     *
     * @param int $user_id The ID of the user
     * @return array An array of reviews by the specified user
     */
    public function getReviewsByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT r.*, b.title FROM reviews r JOIN books b ON r.book_id = b.id WHERE r.user_id = ? ORDER BY r.created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

   
   
}