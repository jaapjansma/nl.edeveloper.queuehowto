<?php

require_once 'CRM/Core/Page.php';

class CRM_Queuehowto_Page_Tasks extends CRM_Core_Page {
  function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Tasks'));

    //retrieve the queue
    $queue = CRM_Queuehowto_Helper::singleton()->getQueue();

    $this->addTaskWithouhtParameter($queue);

    $this->addTaskWithParameter($queue);

    $this->addDelayedTask($queue);

    parent::run();
  }

  private function addTaskWithouhtParameter(CRM_Queue_Queue &$queue) {
    //create a task without parameters
    $task = new CRM_Queue_Task(
      array('CRM_Queuehowto_Tasks', 'TaskWithoutParameters'), //call back method
      array() //parameters
    );
    //now add this task to the queue
    $queue->createItem($task);
  }

  private function addTaskWithParameter(CRM_Queue_Queue &$queue) {
    $number = rand(1, 100); //set parameter for task a random number between 1 and 100

    //create a task without parameters
    $task = new CRM_Queue_Task(
      array('CRM_Queuehowto_Tasks', 'TaskWithParameter'), //call back method
      array($number) //parameters
    );
    //now add this task to the queue
    $queue->createItem($task);
  }

  private function addDelayedTask(CRM_Queue_Queue &$queue) {
    $release_time = new DateTime();
    $release_time->modify('+10 minutes'); //release after ten minutes from now

    //create a task without parameters
    $task = new CRM_Queue_Task(
      array('CRM_Queuehowto_Tasks', 'DelayedTask'), //call back method
      array() //parameters
    );

    $dao              = new CRM_Queue_DAO_QueueItem();
    $dao->queue_name  = $queue->getName();
    $dao->submit_time = CRM_Utils_Time::getTime('YmdHis');
    $dao->data        = serialize($task);
    $dao->weight      = 0; //weight, normal priority
    $dao->release_time = $release_time->format('YmdHis');
    $dao->save();
  }
}
