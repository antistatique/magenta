<?php


/**
 * Skeleton subclass for representing a row from the 'project' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Project extends BaseProject {

  /**
   * Initializes internal state of Project object.
   * @see        parent::__construct()
   */
  public function __construct()
  {
    // Make sure that parent constructor is always invoked, since that
    // is where any default values for this object are set.
    parent::__construct();
  }
  
  public function getProjectManager()
  {
    // SELECT * FROM project LEFT JOIN project_employee ON project.id = project_employee.project_id left join employee ON project_employee.employee_id = employee.id WHERE project_employee.function_project_employee_id ='project_manager' AND project.id=8;
    
    $c = new Criteria();
    $c->addJoin(ProjectPeer::ID, ProjectEmployeePeer::PROJECT_ID, Criteria::LEFT_JOIN);
    $c->addJoin(ProjectEmployeePeer::EMPLOYEE_ID, EmployeePeer::ID, Criteria::LEFT_JOIN);    
    $c->add(ProjectEmployeePeer::FUNCTION_PROJECT_EMPLOYEE_ID, FunctionProjectEmployeePeer::PROJECT_MANAGER);
    $c->add(ProjectPeer::ID, $this->getId());    
    $c->setLimit(1);

    return EmployeePeer::doSelectOne($c);
  }
  
  public function getProjectLastWorkflow()
  {
     //  SELECT * FROM project LEFT JOIN workflow ON project.id = workflow.project_id WHERE workflow.status_name = 'réalisé' ORDER BY workflow.updated_at DESC LIMIT 1;
    $c = new Criteria();
    $c->add(WorkflowPeer::STATUS_NAME, WorkflowPeer::STATUS_DONE);
    $c->addDescendingOrderByColumn(WorkflowPeer::PLANNED_DATE);
    $c->add(WorkflowPeer::PROJECT_ID, $this->getId());
    $c->setLimit(1);
    
    return WorkflowPeer::doSelectOne($c);
  }
  
  public function getRealTypeProject()
  {
    $typeProject = ProjectPeer::getTypeProjects();
    return $typeProject[$this->getTypeProject()];
    
  }
  
  public function __toString(){
    return $this->getTitle();
  }
  
  // public function getStatusProject()
  // {
  //   $c = new Criteria();
  //   $c->add(StatusProjectPeer::ID, $this->getStatusProjectId());    
  //   $statusProject = StatusProjectPeer::doSelect($c);
  //   return $statusProject[0];
  // }

} // Project
