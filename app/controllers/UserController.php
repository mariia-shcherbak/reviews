<?php
/**
 * User Controller
 *
 * This class handles all user-related operations.
 */
class UserController extends Controller
{
    /**
     * Handle user login
     *
     * @return void
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                $this->redirect('index.php?page=home');
            } else {

                $error = "Invalid email or password.";
                $_SESSION['error'] = $error ?? null;

                $this->redirect('index.php?page=login');
            }
        } else {
            $this->view('users/login');
        }
    }

    /**
     * Handle user registration
     *
     * @return void
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $username = $_POST['username'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $confirm_password = $_POST['confirm-password'] ?? null;

            $errors = [];


            if (strlen($username) < 3) {
                $errors['username'] = "Username must be at least 3 characters long.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }
            if (strlen($password) < 8) {
                $errors['password'] = "Password must be at least 8 characters long.";
            }
            if ($password !== $confirm_password) {
                $errors['confirm-password'] = "Passwords do not match.";
            }
            if (!isset($_FILES['profile-photo']) || $_FILES['profile-photo']['error'] !== UPLOAD_ERR_OK) {
                $errors['profile-photo'] = "Profile photo is required.";
            }
            if ($userModel->getUserByEmail($email)) {
                $errors['email'] = "Email is already in use.";
            }
            if ($userModel->getUserByUsername($username)) {
                $errors['username'] = "Username is already in use.";
            }

            if (empty($errors)) {
                $photo_path = $this->uploadProfilePhoto($_FILES['profile-photo']);
                if (!$photo_path) {
                    $errors['profile-photo'] = "Failed to upload profile photo.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    if ($userModel->createUser($username, $email, $hashed_password, $photo_path)) {
                        $this->redirect('index.php?page=login');
                    } else {
                        $errors['general'] = "Registration failed. Please try again.";
                    }
                }
            }


            if (!empty($errors)) {
                $_SESSION['error'] = implode(' ', $errors);
                $this->redirect("index.php?page=register");
                exit;
            }
        } else {
            $this->view('users/register');
        }
    }

    /**
     * Handle user logout
     *
     * @return void Redirects to home page
     */
    public function logout()
    {
        session_destroy();
        $this->redirect('index.php?page=home');
    }

    /**
     * Display user profile
     *
     * @return void
     */
    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?page=login');
        }

        $userModel = $this->model('User');
        $user = $this->sanitizeArrayForOutput($userModel->getUserById($_SESSION['user_id']));
        $reviewModel = $this->model('Review');
        $reviews = $this->sanitizeArrayForOutput($reviewModel->getReviewsByUserId($_SESSION['user_id']));

        $this->view('users/profile', ['user' => $user, 'reviews' => $reviews]);
    }


    /**
     * Upload a profile photo
     *
     * @param array $file The uploaded file data
     * @return string|false The path to the uploaded file, or false on failure
     */
    private function uploadProfilePhoto($file)
    {
        $target_dir = "uploads/profile_photos/";
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


        if ($file["size"] > 9000000) {
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
     * Handle password change
     *
     * @return void Redirects to profile page
     */
    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $userModel = $this->model('User');
            $user = $userModel->getUserById($_SESSION['user_id']);

            if (!$user) {

                $this->redirect('index.php?page=login');
            }

            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword || $newPassword < 8) {
                $error = "New passwords do not match or too short.";
            } elseif (!password_verify($currentPassword, $user['password'])) {
                $error = "Current password is incorrect.";
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                if ($userModel->updatePassword($_SESSION['user_id'], $hashedPassword)) {

                    $success = "Password updated successfully.";
                } else {
                    $error = "Failed to update password. Please try again.";
                }
            }
            $_SESSION['error'] = $error ?? null;
            $_SESSION['success'] = $success ?? null;
        }
        $this->redirect('index.php?page=profile');
    }
}
