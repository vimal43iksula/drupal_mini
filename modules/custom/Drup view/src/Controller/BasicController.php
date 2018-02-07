<?php

namespace Drupal\drup_view\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

class BasicController extends ControllerBase {

  /**
   * Display markup.
   *
   * @return array
   */

  public function content($first) {
	 if(is_numeric($first)){
    $user_load = User::load($first);
      if(!empty($user_load)){
        return[
          '#markup' =>  t($user_load->name->getString())
            ];
       }
    $node_load = Node::load($first);
      if(!empty($node_load)){
        return [
          '#markup' => t($node_load->title->getString())
            ];
        }

  
  return[
    '#markup'  =>  t('value not found')
     ];   
   }
  return[
   '#markup'  =>  t($first)
     ];
  }
}





