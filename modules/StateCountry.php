<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResumeForm
 *
 * @author user
 */

namespace Drupal\ajax_training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class StateCountry extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_training';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
     $row[] = static::get_data();
     //dsm($row);
    $header = array('ID', 'Country', 'City');
    if (!empty($row)) {
      $form['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $row,
      ];
    }
    $country = array('none_country' => 'None', 'india' => 'India', 'pakistan' => 'Pakistan', 'srilanka' => 'Srilanka', 'bangladesh' => 'Bangladesh');
    $default_state = array('Maharashtra', 'Gujrat');
    $form['country'] = array(
      '#type' => 'select',
      '#title' => ('Country'),
      '#options' => $country,
      '#ajax' => array(
        'callback' => '::dependent_state',
        //'effect' => 'fade',
        'event' => 'change',
        'wrapper' => 'state',
      ),
    );
    $country = $form_state->getValues();
    $selected_country = !empty($country['country']) ? $country['country'] : 'none_country';

    if ($selected_country == 'none_country') {
      $options = array('none_state' => 'None');
    }
    else if ($selected_country == 'india') {
      $options = array('maharashtra' => 'Maharashtra', 'gujrat' => 'Gujrat');
    }
    else if ($selected_country == 'pakistan') {
      $options = array('lahore' => 'Lahore', 'karachi' => 'Karachi');
    }
    else if ($selected_country == 'srilanka') {
      $options = array('colombo' => 'Colombo', 'kandy' => 'Kandy');
    }
    else if ($selected_country == 'bangladesh') {
      $options = array('dhaka' => 'Dhaka', 'chittagong' => 'Chittagong');
    }

    $form['state'] = array(
      '#type' => 'select',
      '#title' => ('State'),
      '#options' => $options,
      '#prefix' => '<div id="state">',
      '#suffix' => '</div>',
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    
 //Display result.
    $data = $form_state->getValues();
    $country = $data['country'];
    $state = $data['state'];
    db_merge('location')
        ->insertFields(array(
          'country' => ucfirst($country),
          'state' => ucfirst($state),
        ))
        ->updateFields(array(
          'country' => ucfirst($country),
          'state' => ucfirst($state),
        ))
        ->key(array('id' => 1))
        ->execute();
  }

  public function dependent_state(array $form, FormStateInterface $form_state) {
    return $form['state'];
  }
  
   public function get_data() {
     $db = \Drupal::database();
     $data = $db->select('location', 'l')
         ->fields('l')
         ->execute()
         ->fetchAssoc();
     return $data;
   }

}
