<?php

class Controller {
    public function model($model) {
        require_once 'models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        if (file_exists('views/' . $view . '.php')) {
            // Extract data to variables
            extract($data);
            
            // Start output buffering
            ob_start();
            
            // Include the view
            require_once 'views/' . $view . '.php';
            
            // Get the content of the buffer
            $content = ob_get_clean();
            
            // You can wrap the content in a layout here if you want
            // For now, just output it
            echo $content;
        } else {
            die('View does not exist');
        }
    }
}