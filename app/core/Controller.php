<?php

class Controller
{
    protected function model($model)
    {
        $modelFile = __DIR__ . '/../models/' . $model . '.php';

        if (!file_exists($modelFile)) {
            die("Model file not found: " . $modelFile);
        }

        require_once $modelFile;

        if (!class_exists($model)) {
            die("Model class not found: " . $model);
        }

        return new $model();
    }

    protected function view($view, $data = [])
    {
        $file = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($file)) {
            extract($data);
            require $file;
        } else {
            die("View not found: " . $view);
        }
    }
}