<?php

namespace Drupal\location\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SelectDependent extends FormBase {
  
public function getFormId(){
   return 'select_dependent_form';
}

public function buildForm(array $form, FormStateInterface $form_state) {
//  $country = array('none_country' => 'None', 'india' => 'India', 'australia' => 'Australia');
//  
//  $form['country'] = array(
//    '#type' => 'select',
//    '#title' => ('Country'),
//    '#options' => $country,
//  );
//
//  return $form;
  
}

public function submitForm(array &$form, FormStateInterface $form_state) {
 
}

  
}

