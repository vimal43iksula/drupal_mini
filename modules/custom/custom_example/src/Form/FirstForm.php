<?php

/**
 * @file
 * Contains \Drupal\custom_example\Form\FirstForm.
 */

namespace Drupal\custom_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Database\Database;

class FirstForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'firstform';
  }

  /**
   * {@inheritdoc}
   */

  /**
   * Paasing Variable $username into JS.
   * Attached library to form element 
   * Check Email Validate using ajax DB
   */
  public function buildForm(array $form, FormStateInterface $form_state) {



    

    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => 'User or Email',
      '#description' => 'Please enter in a user or email',
    );

    $form['actions']['submit'] = array(
      '#type' => 'button',
      '#title' => t('submit'),
      '#value' => $this->t('Submit'),
      '#ajax' => array(
        'callback' => '::display_email',
        'wrapper' => 'user-email',
        'effect' => 'fade',
        'event' => 'click',
        'progress' => array(
          'type' => 'throbber',
          'message' => NULL,
        ),
      ),
    );
    $values = $form_state->getValues();

    $email = $values['email'];
    if (!empty($email)) {
      $insert = \Drupal::database();
      $data_insert = $insert->insert('email_example')
          ->fields([
            'email',
          ])
          ->values(array(
            $email,
          ))
          ->execute();
    }

    $header = array('Id', 'Email');
    $db = \Drupal::database();
    $data = $db->select('email_example', 'l')
        ->fields('l', array('id', 'email'))
        ->execute()
        ->fetchAll();

    foreach ($data as $value) {
      $id = $value->id;
      $email = $value->email;
      $rows[] = array(
        'data' => array($id, $email));
    }
    if (!empty($rows)) {
      $form['table'] = [
        '#type' => 'table',
        '#prefix' => '<div id="user-email">',
        '#suffix' => '</div>',
        '#header' => $header,
        '#rows' => $rows,
      ];
        $username = $email;
    $form['#attached']['library'][] = 'custom_example/firstlibraries';
    $form['#attached']['drupalSettings']['custom_example']['name'] = $username;
    $form['#tree'] = TRUE;
       
      return $form;
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
//     $ajax_response = new AjaxResponse();
//     $email = $form_state->getValues()['email'];
//
//    $field = array(
//      'Email' => $email,
//    );
//
//    db_insert('email_example')
//        ->fields($field)
//        ->execute();
//    
//    
//    $ajax_response->addCommand(new HtmlCommand('#user-email', $text));
//    return $ajax_response;
  }

  /**
   * Ajax function which will work on click of submit
   * @param array $form
   * @param FormStateInterface $form_state
   * @return AjaxResponse
   */
  public function display_email(array $form, FormStateInterface $form_state) {
    return $form['table'];
  }

}
