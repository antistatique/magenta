<?php


/**
 * Skeleton subclass for representing a row from the 'workflow' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Workflow extends BaseWorkflow {

	/**
	 * Initializes internal state of Workflow object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

  public function getRealTypeWorkflow()
  {
    $typeWorkflow = WorkflowPeer::getTypeWorkflows();
    return $typeWorkflow[$this->getTypeWorkflow()];
    
  }

  public function getStatusRealName()
  {
    $statusName = WorkflowPeer::getStatusNames();
    return $statusName[$this->getStatusName()];
    
  }

  public function getStatusDayLate()
  {
     /* Compare midnight dates between today and planned date*/
     $todayMidnight = mktime(0,0,0,date('m'),date('d'),date('Y'));
     $plannedDateMidnight = mktime(0,0,0,$this->getPlannedDate('m'),$this->getPlannedDate('d'),$this->getPlannedDate('Y'));
     return ($plannedDateMidnight - $todayMidnight);
  }
  
  public function getStatusDayLateName()
  {
     if($this->getStatusName()==WorkflowPeer::STATUS_PLAN){
        if($this->getStatusDayLate()>0){
           return 'early';
        }elseif($this->getStatusDayLate()<0){
           return 'late';        
        }else{
           return 'today';        
        }        
     }
     return '';
  }

  public function __toString()
  {
    return  $this->getTitle();
  }

} // Workflow
