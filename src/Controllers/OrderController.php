<?php
namespace Boutique\Controllers;

class OrderController extends Controller {
    public function createOrder() {
        $this->render('checkout');
    }
}