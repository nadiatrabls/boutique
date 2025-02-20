<?php
namespace Boutique\Controllers;

class UserController extends Controller {
    public function register() {
        $this->render('login');
    }
    
    public function login() {
        $this->render('login');
    }
    
    public function logout() {
        $this->render('accueil');
    }
}