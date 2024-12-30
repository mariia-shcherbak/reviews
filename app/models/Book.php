<?php
/**
 * Book Model
 *
 * This class handles all database operations related to books.
 */
class Book {
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
     * Get books with pagination
     *
     * @param int $limit Number of books per page
     * @param int $offset Starting position for fetching books
     * @return array An array of books
     */
    public function getBooksWithPagination($limit, $offset) {
        $query = "SELECT b.*, AVG(r.rating) as rating FROM books b 
                  LEFT JOIN reviews r ON b.id = r.book_id 
                  GROUP BY b.id 
                  ORDER BY b.title ASC 
                  LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            error_log("Prepare statement failed: " . $this->db->error);
            return [];
        }
        $stmt->bind_param("ii", $limit, $offset);  
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            error_log("Execution failed: " . $stmt->error);
            return [];
        }
    }

    /**
     * Get total number of books
     *
     * @return int Total number of books
     */
    public function getTotalBooks() {
        $query = "SELECT COUNT(*) as total FROM books";
        $result = $this->db->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        } else {
            error_log("Error counting books: " . $this->db->error);
            return 0;
        }
    }
    

    /**
     * Get all books
     *
     * @return array An array of all books
     */
    public function getAllBooks() {
        $query = "SELECT b.*, AVG(r.rating) as rating FROM books b 
                  LEFT JOIN reviews r ON b.id = r.book_id 
                  GROUP BY b.id 
                  ORDER BY b.title ASC";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            error_log("Error fetching books: " . $this->db->error);
            return [];
        }
    }
    
    /**
     * Get average rating for a book
     *
     * @param int $book_id The ID of the book
     * @return float The average rating of the book
     */
    public function getBookRating($book_id) {
        $stmt = $this->db->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE book_id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['avg_rating'] ? number_format($row['avg_rating'], 1) : 0;
    }


    /**
     * Get a specific book by its ID
     *
     * @param int $id The ID of the book
     * @return array|null The book data, or null if not found
     */
    public function getBookById($id) {
        $query = "SELECT b.*, AVG(r.rating) as rating FROM books b 
                  LEFT JOIN reviews r ON b.id = r.book_id 
                  WHERE b.id = ? 
                  GROUP BY b.id";
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            error_log("Prepare statement failed: " . $this->db->error);
            return null;
        }
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {
            error_log("Execution failed: " . $stmt->error);
            return null;
        }
    }


    /**
     * Add a new book
     *
     * @param string $title The title of the book
     * @param string $author The author of the book
     * @param string $description The description of the book
     * @param int $pages The number of pages in the book
     * @param string $publisher The publisher of the book
     * @param int $year The publication year of the book
     * @param string $country The country of publication
     * @param string $image The path to the book's cover image
     * @return bool True if the book was added successfully, false otherwise
     */
    public function addBook($title, $author, $description, $pages, $publisher, $year, $country, $image) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, description, pages, publisher, year, country, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Prepare statement failed: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("sssisiss", $title, $author, $description, $pages, $publisher, $year, $country, $image);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Execution failed: " . $stmt->error);
            return false;
        }
    }

    /**
     * Delete a book
     *
     * @param int $bookId The ID of the book to be deleted
     * @return bool True if the book was deleted successfully, false otherwise
     */
    public function deleteBook($bookId) {
        $query = "DELETE FROM books WHERE id = ?";
        $stmt = $this->db->prepare($query);
    
        if ($stmt === false) {
            error_log("Prepare statement failed: " . $this->db->error);
            return false;
        }
    
        $stmt->bind_param("i", $bookId);
    
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Execution failed: " . $stmt->error);
            return false;
        }

    }

    /**
     * Update a book
     *
     * @param int $id The ID of the book to be updated
     * @param string $title The new title of the book
     * @param string $author The new author of the book
     * @param string $description The new description of the book
     * @param int $pages The new number of pages in the book
     * @param string $publisher The new publisher of the book
     * @param int $year The new publication year of the book
     * @param string $country The new country of publication
     * @param string|null $image_path The new path to the book's cover image (optional)
     * @return bool True if the book was updated successfully, false otherwise
     */
    public function updateBook($id, $title, $author, $description, $pages, $publisher, $year, $country, $image_path) {
        $sql = "UPDATE books SET title = ?, author = ?, description = ?, pages = ?, publisher = ?, year = ?, country = ?";
        $params = [$title, $author, $description, $pages, $publisher, $year, $country];
        
        if ($image_path !== null) {
            $sql .= ", image = ?";
            $params[] = $image_path;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;
    
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
}