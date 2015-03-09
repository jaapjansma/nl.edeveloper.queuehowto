<?php
/**
 * Created by PhpStorm.
 * User: jaap
 * Date: 3/9/15
 * Time: 3:25 PM
 */

class CRM_Queuehowto_Tasks {

  public static function TaskWithoutParameters(CRM_Queue_TaskContext $ctx) {
    CRM_Core_Session::setStatus('Task without parameters is exeucuted', 'Queue task', 'success');
    return true;
  }

  public static function TaskWithParameter(CRM_Queue_TaskContext $ctx, $number) {
    CRM_Core_Session::setStatus('Task with parameter number: '.$number.' is executed', 'Queue task', 'success');
    return true;
  }

  public static function DelayedTask(CRM_Queue_TaskContext $ctx) {
    CRM_Core_Session::setStatus('A delayed task is executed', 'Queue task', 'success');
    return true;
  }

}