<?php

namespace Drupal\location\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SelectDependent extends FormBase {
  
public function getFormId(){
   return 'select_dependent_form';
}

public function buildForm(array $form, FormStateInterface $form_state) {
  $country = array('none_country' => 'None', 'india' => 'India', 'australia' => 'Australia');
    $form['country'] = array(
    '#type' => 'select',
    '#title' => ('Country'),
    '#options' => $country,
    '#ajax' => array(
      'callback' => '::dependent_state',
      '#event' => 'change',
      'wrapper' => 'state',
    )
  );
   $country = $form_state->getvalues();
   $selected_country = !empty($country['country']) ? $country['country'] : 'none_country';
   
   if($selected_country == 'none_country'){
     $options = array('none_state' => 'None');
   }
   if($selected_country == 'india'){
     $options = array('tamilnadu' => 'TamilNadu', 'goa' => 'Goa');
   }
   if($selected_country == 'australia'){
     $options = array('sydney' => 'Sydney', 'perth' => 'Perth');
   }
    
    $form['state'] = array(
      '#type' => 'select',
      '#title' => 'State',
      '#options' => $options,
      '#prefix' => '<div id="state">',
      '#suffix' => '</div>',
    ); 
    
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => 'Submit',
    );
  
  return $form;
  
}

public function submitForm(array &$form, FormStateInterface $form_state) {
 
}

public function dependent_state(array &$form, FormStateInterface $form_state){
  return $form['state'];
}
  
}

