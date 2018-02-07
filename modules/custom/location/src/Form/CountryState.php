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

namespace Drupal\location\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class CountryState extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_training';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    //$row[] = static::get_data();
    $row1 = $this->display_data();

    //dsm($row);
    $header = array('ID', 'Country', 'City');
    if (!empty($row)) {
      $form['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $row,
      ];
    }
    //$country = array('none_country' => 'None');
//    $default_state = array('Maharashtra', 'Gujrat');
    $form['country'] = array(
      '#type' => 'select',
      '#title' => ('Country'),
      '#options' => $row1,
      '#ajax' => array(
        'callback' => '::dependent_state',
        //'effect' => 'fade',
        'event' => 'change',
        'wrapper' => 'state',
      ),
    );

    $country = $form_state->getValues();
    $selected_country = !empty($country['country']) ? $country['country'] : 'none_country';
    $row2 = $this->get_child_tid($selected_country);

//    if ($selected_country == 'none_country') {
//      $options = array('none_state' => 'None');
//    }
//    else if ($selected_country == 'india') {
//      $options = array('maharashtra' => 'Maharashtra', 'gujrat' => 'Gujrat');
//    }
//    else if ($selected_country == 'pakistan') {
//      $options = array('lahore' => 'Lahore', 'karachi' => 'Karachi');
//    }
//    else if ($selected_country == 'srilanka') {
//      $options = array('colombo' => 'Colombo', 'kandy' => 'Kandy');
//    }
//    else if ($selected_country == 'bangladesh') {
//      $options = array('dhaka' => 'Dhaka', 'chittagong' => 'Chittagong');
//    }

    $form['state'] = array(
      '#type' => 'select',
      '#title' => ('State'),
      '#options' => $row2,
      '#prefix' => '<div id="state">',
      '#suffix' => '</div>',
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }
 /**
  * Function for submitting form
  * @param array $form
  * @param FormStateInterface $form_state
  */
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
 /**
  *  Function to know the dependent state of the corresponding country
  * @param array $form
  * @param FormStateInterface $form_state
  * @return array
  */
  public function dependent_state(array $form, FormStateInterface $form_state) {
    return $form['state'];
  }

//  public function get_data() {
//    $db = \Drupal::database();
//    $data = $db->select('location', 'l')
//        ->fields('l')
//        ->execute()
//        ->fetchAssoc();
//    return $data;
//  }

  /**
   * Display the Country List with the help of taxonomy
   * @return type
   */
  public function display_data() {
    $db = \Drupal::database();
    $query = $db->select('taxonomy_term_field_data', 't');
    $query->join('taxonomy_term_hierarchy', 'n', 'n.tid = t.tid');
    $result = $query
        ->fields('t', array('tid', 'name'))
        ->condition('t.vid', 'location', '=')
        ->condition('n.parent', 'parent', '0')
        ->execute()
        ->fetchAllKeyed(0, 1);
    return $result;
  }

  /**
   * Function to get state value dependening on country
   * @param type $tid
   * @return type
   */
  public function get_child_tid($tid) {
    $db = \Drupal::database();
    $query = $db->select('taxonomy_term_field_data', 't');
    $query->join('taxonomy_term_hierarchy', 'n', 'n.tid = t.tid');
    $result = $query
        ->fields('t', array('tid', 'name'))
        ->condition('n.parent', $tid, '=')
        ->execute()
        ->fetchAllKeyed(0, 1);
    return $result;
  }

}
