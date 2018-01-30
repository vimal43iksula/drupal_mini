<?php

namespace Drupal\drup_view\Controller;

use Drupal\Core\Controller\ControllerBase;

class BasicController extends ControllerBase {

  /**
   * Display markup.
   *
   * @return array
   */
  public function content() {

    return [
      '#markup' => t('Hello India!'),
    ];
  }
 public function content1() {

    return [
      '#markup' => t('Hello India11!'),
    ];
  }

}
