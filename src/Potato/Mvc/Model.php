<?php namespace Potato\Mvc;

use Potato\Database\Database;

abstract class Model {

    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }
}