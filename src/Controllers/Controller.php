<?php
namespace Boutique\Controllers;

abstract class Controller 
{

   protected function render($view,$tab_message=[])
   {
      extract($tab_message);
     



      ob_start();
      include('../views/'.$view.'.php');
      $contenu=ob_get_clean();
        
      include('../views/templates/template.php');
   }


}