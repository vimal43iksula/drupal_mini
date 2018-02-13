<?php

namespace Drupal\form\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class SubjectDetails extends ConfigFormBase {

  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  public function getFormId() {
    return 'subject_details';
  }

 
  protected function getEditableConfigNames() {
    return ['config.subject_details'];
  }

 
  public function buildForm(array $form, FormStateInterface $form_state) {

    
    $config = $this->config('config.subject_details');

    
    $form['subject_name_1'] = [
      '#type' => 'textfield',
      '#title' => t('Subject Name 1'),
      '#default_value' => $config->get('subject_name_1') ? $config->get('subject_name_1') : '',
      '#required' => TRUE,
    ];

    
    $form['subject_name_2'] = [
      '#type' => 'textfield',
      '#title' => t('Subject Name 2'),
      '#default_value' => $config->get('subject_name_2') ? $config->get('subject_name_2') : '',
      '#required' => TRUE,
    ];

    
    $form['subject_name_3'] = [
      '#type' => 'textfield',
      '#title' => t('SUbject Name 3'),
      '#default_value' => $config->get('subject_name_3') ? $config->get('subject_name_3') : '',
      '#required' => TRUE,
    ];
    
    $form['subject'] = [
      '#type' => 'select',
      '#title' => ('subject'),
      '#options' => [
        '1' => t('marathi'),
        '2' => t('Urdu'),
      ],
      '#default_value' => $config->get('subject') ? $config->get('subject') : '',
      '#required' => TRUE,
    ];
    
    $form['contact'] = [
      '#type' => 'tel',
      '#title' => ('Contact Info'),
      '#default_value' => $config->get('contact') ? $config->get('contact') : '',
      '#required' => TRUE,
    ];
   
    return parent::buildForm($form, $form_state);
  }
     public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
      if(strlen($form_state->getValue('contact'))<10 || strlen($form_state->getValue('contact'))>10){
           $form_state->setErrorByName('contact', $this->t('Contact number must be equal to 10.'));
      }
    }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $values = $form_state->getValues();

    $this->config('config.subject_details')
      ->set('subject_name_1', $values['subject_name_1'])
      ->set('subject_name_2', $values['subject_name_2'])
      ->set('subject_name_3', $values['subject_name_3'])
      ->set('subject', $values['subject']) 
      ->set('contact', $values['contact'])  
      ->save();
  }
}
