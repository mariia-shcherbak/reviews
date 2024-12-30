<?php
/**
 * User Model
 *
 * This class handles all database operations related to users.
 */
class User {
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
     * Get a user by email
     *
     * @param string $email The email of the user
     * @return array|null The user data, or null if not found
     */
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get a user by ID
     *
     * @param int $id The ID of the user
     * @return array|null The user data, or null if not found
     */
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Create a new user
     *
     * @param string $username The username of the new user
     * @param string $email The email of the new user
     * @param string $password The hashed password of the new user
     * @param string $profile_photo The path to the user's profile photo
     * @return bool True if the user was created successfully, false otherwise
     */
    public function createUser($username, $email, $password, $profile_photo) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password,  profile_photo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password,  $profile_photo);
        if (!$stmt->execute()) {
            error_log("MySQL Error: " . $stmt->error);
            return false;
        }
        return true;
    }

    /**
     * Get all users
     *
     * @return array An array of all users
     */
    public function getAllUsers() {
        $result = $this->db->query("SELECT * FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Make a user an admin
     *
     * @param int $user_id The ID of the user to be made an admin
     * @return bool True if the user was made an admin successfully, false otherwise
     */
    public function makeAdmin($user_id) {
        $stmt = $this->db->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    /**
     * Remove admin status from a user
     *
     * @param int $user_id The ID of the user to have admin status removed
     * @return bool True if the admin status was removed successfully, false otherwise
     */
    public function unmakeAdmin($user_id) {
        $stmt = $this->db->prepare("UPDATE users SET is_admin = 0 WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    /**
     * Get a user by username
     *
     * @param string $username The username of the user
     * @return array|null The user data, or null if not found
     */
    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Update a user's password
     *
     * @param int $userId The ID of the user
     * @param string $hashedPassword The new hashed password
     * @return bool True if the password was updated successfully, false otherwise
     */
    public function updatePassword($userId, $hashedPassword) {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param('si', $hashedPassword, $userId);
        return $stmt->execute();
    }
    
    
}