<?php
/**
 * Base Controller Class
 *
 * This class serves as the base for all other controllers.
 */
class Controller {
    /**
     * Load a model
     *
     * @param string $model The name of the model to load
     * @return object The instantiated model
     */
    protected function model($model) {
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
    protected function view($view, $data = []) {
        extract($data);
        require_once "../app/views/{$view}.php";
    }

    /**
     * Redirect to a URL
     *
     * @param string $url The URL to redirect to
     * @return void
     */
    protected function redirect($url) {
        header("Location: " . BASE_URL .'/'. $url);
        exit;
    }
}