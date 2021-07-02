<?php namespace Potato\Mvc;

use Potato\Http\Errors\NotFoundException;
use Potato\Persistence\FileSystem;

class View {
 
    public static function render(string $name, array $data = null): void {
        if (!is_null($data)) {
            extract($data);
        }

        $viewPath = "../views/$name.phtml";

        if (!FileSystem::exists($viewPath)) {
            throw new NotFoundException("View not found!");
        }

        // TODO: if user is authenticated put user in var
        
        $helpers = FileSystem::folderContent('../views/helpers', '*.helper.php');
        foreach ($helpers as $helper) {
            require_once $helper;
        }

        include $viewPath;
    }

    public static function renderWithTemplate(string $name, array $data = null): void {
        static::render('templates/header', $data);
        static::render($name, $data);
        static::render('templates/footer', $data);
    }
}