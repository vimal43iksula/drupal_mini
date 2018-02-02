<?php

/*Cotains form details */

 namespace Drupal\form\Form;

 use Drupal\Core\Form\FormBase;
 use Drupal\Core\Form\FormStateInterface;
 use Drupal\Core\Database\Database;

 class ExamDetails extends FormBase {
   
   public function getFormId() {
     return 'exam_details';
   }    

   public function buildForm(array $form, FormStateInterface $form_state, $data=NULL) {

    $form['exam_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('exam_id'),
      '#default_value' => $data[0]->exam_id ? $data[0]->exam_id : '',
      '#required' => TRUE,
    ];
   
     $form['start_date'] = [
      '#type' => 'date',
      '#title' => $this->t('start_date'),
      '#default_value' => $data[0]->start_date ? $data[0]->start_date : '',
      '#required' => TRUE,
    ];

     $form['location'] = [
      '#type' => 'textfield',
      '#title' => $this->t('location'),
      '#default_value' => $data[0]->location ? $data[0]->location : '',
      '#required' => TRUE,
    ];

     $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('email'),
      '#default_value' => $data[0]->email ? $data[0]->email : '',
      '#required' => TRUE,
    ];

     $form['sumbit'] = [
       '#type' => 'submit',
       '#value' => $this->t('Save Exam Form'),
       '#attributes' => [
          'class' => ['btn'],
       ],
    ];
    $form['#theme'] = ['employee_details_template'];
    return $form;
  }

    public function ValidateForm(array &$form, FormStateInterface $form_state){
      if (date('Y-m-d') < $form_state->getValue('start_date')) {
        $form_state->setErrorByName('start_date', $this->t('Date should less than current date.'));
      }	
    }
    
    public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $values = $form_state->getValues();
   
   $connection = Database::getConnection();
   $connection->insert('exam_details')->fields(
     [
       'exam_id' => $values['exam_id'],
       'start_date' => strtotime($values['start_date']),
       'location' => $values['location'],
       'email' => $values['email'],
     ]
    )->execute();
   }
}
