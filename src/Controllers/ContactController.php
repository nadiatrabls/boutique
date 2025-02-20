<?php
namespace Boutique\controllers;



class ContactController extends Controller {
    public function contactPage() {
        $this->render('contact');
    }
}