<?php


namespace Drupal\form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;


class Display extends ControllerBase {

  
  public function showdata() {

// you can write your own query to fetch the data I have given my example.

    $result = \Drupal::database()->select('exam_details', 'n')
            ->fields('n', array('id', 'exam_id', 'start_date', 'location', 'email'))
            ->execute()->fetchAllAssoc('exam_id');
// Create the row element.
    $rows = array();
    foreach ($result as $row => $content) {

      $url = Url::fromUri('internal:/exam-form/' . $content->id);
      $edit = Link::fromTextAndUrl('Edit', $url);
      
       /* $rows[] = array(
            'exam_id' =>$data->exam_id,
                'start_date' => $data->start_date,
                'location' => $data->location,
                //'email' => $data->email,
                'email' => $data->email,
                
                
            );*/

      $rows[] = array(
        'data' => array($content->exam_id, $content->start_date, $content->location, $content->email, $edit)
      );
    }

// Create the header.
    $header = array('Exam ID', 'START DATE', 'LOCATION', 'EMAIL', 'EDIT');
    $output = array(
      '#theme' => 'table',    // Here you can write #type also instead of #theme.
      '#header' => $header,
      '#rows' => $rows
    );
    return $output;
  }
}