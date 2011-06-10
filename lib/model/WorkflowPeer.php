<?php


/**
 * Skeleton subclass for performing query and update operations on the 'workflow' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class WorkflowPeer extends BaseWorkflowPeer {
  /**
   * Constant which define the type_workflow
   * @var string TYPE_TASK
   * @var string TYPE_EVENT
   * @var string TYPE_EXTERNAL
   * @var array type_workflow   
   */
  const TYPE_TASK     = "task";
  const TYPE_EVENT    = "event";
  const TYPE_SYSTEM   = "system";
  const TYPE_BILL     = "bill";
  protected static $type_workflow = array(
    self::TYPE_TASK   => 'Tâche',
    self::TYPE_EVENT  => 'Evénement',
    self::TYPE_SYSTEM => 'Système',
    self::TYPE_BILL   => 'Facturation'
  );
  
  /**
   * Constant which define the status_name
   * Réalisé
   * Planifié
   * Annulé
   * @var string STATUS_DONE
   * @var string STATUS_PLAN
   * @var string STATUS_CANCEL
   * @var array status_name   
   */
  const STATUS_DONE   = "done";
  const STATUS_PLAN   = "plan";
  const STATUS_CANCEL = "cancel";
  protected static $status_name = array(
    self::STATUS_DONE => 'Réalisé',
    self::STATUS_PLAN => 'Planifié',
    self::STATUS_CANCEL => 'Annulé'
  );  
  
  
  /**
   * Return an array of workflow types
   * @return array of workflow types
   */
  public static function getTypeWorkflows()
  {
    return self::$type_workflow;
  }
  
  /**
   * Return an array of workflow status name
   * @return array of workflow status name
   */
  public static function getStatusNames()
  {
    return self::$status_name;
  }
  
  public static function listWorkflow($project_id)
  {
    $c = new Criteria();
    $c->add(WorkflowPeer::PROJECT_ID, $project_id);
    $c->addDescendingOrderByColumn(WorkflowPeer::PLANNED_DATE);
    $c->addDescendingOrderByColumn(WorkflowPeer::STATUS_NAME);
    
    return WorkflowPeer::doSelect($c);
  }
  
} // WorkflowPeer
