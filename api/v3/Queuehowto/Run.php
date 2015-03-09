<?php

function civicrm_api3_queuehowto_run($params) {
  $returnValues = array();

  //retrieve the queue
  $queue = CRM_Queuehowto_Helper::singleton()->getQueue();
  $runner = new CRM_Queue_Runner(array(
    'title' => ts('Queue howto runner'), //title fo the queue
    'queue' => $queue, //the queue object
    'errorMode'=> CRM_Queue_Runner::ERROR_CONTINUE, //continue on error otherwise the queue will hang
  ));

  $maxRunTime = time() + 30; //stop executing next item after 30 seconds
  $continue = true;
  while(time() < $maxRunTime && $continue) {
    $result = $runner->runNext(false);
    if (!$result['is_continue']) {
      $continue = false; //all items in the queue are processed
    }
    $returnValues[] = $result;
  }

  // Spec: civicrm_api3_create_success($values = 1, $params = array(), $entity = NULL, $action = NULL)
  return civicrm_api3_create_success($returnValues, $params, 'Queuehowto', 'Run');
}

