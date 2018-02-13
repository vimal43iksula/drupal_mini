<?php

namespace Drupal\custom_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SecondForm extends FormBase {

  public function getFormId() {
    return 'secondform';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['user_email'] = array(
      '#type' => 'textfield',
      '#title' => 'User Name or Email',
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#title' => t('submit'),
      '#value' => $this->t('Submit'),    
      );
    return $form;
  }



public function submitForm(array &$form, FormStateInterface $form_state) {
  // Submit Code Here
}

}