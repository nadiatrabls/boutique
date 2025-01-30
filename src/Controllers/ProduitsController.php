<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class ProduitsController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new ProduitsModel;
    }

    private function tousLesProduits()     {
        return $this->model->tousLesProduits();
    }


    public function index()
    {

        $touslesproduits=$this->tousLesProduits();
       
        
        $this->render('produits',compact('touslesproduits'));

    }



}