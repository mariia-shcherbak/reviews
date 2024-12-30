<?php

/**
 * Base Controller Class
 *
 * This class serves as the base for all other controllers.
 */
class Controller
{
    /**
     * Load a model
     *
     * @param string $model The name of the model to load
     * @return object The instantiated model
     */
    protected function model($model)
    {
        require_once "../app/models/{$model}.php";
        return new $model();
    }

    /**
     * Load a view
     *
     * @param string $view The name of the view to load
     * @param array $data The data to pass tothe view
     * @return void
     */
    protected function view($view, $data = [])
    {
        extract($data);
        require_once "../app/views/{$view}.php";
    }

    /**
     * Redirect to a URL
     *
     * @param string $url The URL to redirect to
     * @return void
     */
    protected function redirect($url)
    {
        header("Location: " . BASE_URL . '/' . $url);
        exit;
    }

    /**
     * Sanitize input data to prevent XSS and other vulnerabilities.
     *
     * @param mixed $data The data to sanitize.
     * @return mixed The sanitized data.
     */
    protected function sanitizeArrayForOutput($data)
    {
        if (is_array($data)) {
          return array_map([$this, 'sanitizeArrayForOutput'], $data);
        } elseif (is_string($data)) {
            
            return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
        }

        
        return $data;
    }
}
