<?php namespace Potato\Mvc;

use Potato\Http\FlashBag;
use Potato\Http\Request;
use Potato\Http\Session;
use stdClass;

abstract class SecuredController extends Controller {

    const SESSION_KEY = '@potato::user';

    protected $user;

    public function __construct()
    {
        $this->user = Request::isAuthenticated();

        if (!$this->user) {
            FlashBag::add('Forbidden', 'danger');
            $this->redirect('/');
        }
    }

    public static function setUser(stdClass $user): void {
        Session::set(static::SESSION_KEY, $user);
    }

    public static function logout(): void {
        Session::remove(static::SESSION_KEY);
    }
}