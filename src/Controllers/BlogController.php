<?php
namespace Boutique\controllers;

use Boutique\Models\ProduitsModel;

class BlogController extends Controller {
    public function index() {
        $this->render('blog');
    }
    
   
}