<?php

/**
 * dashboard actions.
 *
 * @package    Magenta
 * @subpackage dashboard
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class dashboardActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
    $user = $this->getUser();
    $id_guard = $user->getGuardUser()->getId();
    $this->id_employee = $user->getProfile()->getId();
    
    //get users
    $c_employee_list = new Criteria();
    $c_employee_list->add(EmployeePeer::FUNCTION_EMPLOYEE_ID, 'admin_type', Criteria::NOT_EQUAL);
    $this->employee_list = EmployeePeer::doSelect($c_employee_list);

    $criteria_workflow_employee = new Criteria();

    //Manage filters
    // dans le cas ou on change de filtre .. 
    // si parameter employee_id .. alors affichage des tâches de l'employer
    if($request->getParameter('username')&&($user->hasCredential(array('can_project_modify', 'can_admin_project'), false)))
    {
      $this->forward404Unless($employee = EmployeePeer::retrieveByUsername($request->getParameter('username')));
      $criteria_workflow_employee->add(WorkflowPeer::MANAGER_ID, $employee->getId());
      $this->workflow_title = "Les tâches de ".$employee->getFirstname();      
      $this->id_employee = $employee->getId();
      $this->employee    = $employee;

    }else{
       $this->workflow_title = "Vos tâches";   
       $criteria_workflow_employee->add(WorkflowPeer::MANAGER_ID, $this->id_employee);
       $this->employee    = EmployeePeer::retrieveByPk($this->id_employee);
    }


    
    
    // liste des workflows pour l'employé loggué


    $criteria_workflow_employee->add(WorkflowPeer::STATUS_NAME, WorkflowPeer::STATUS_PLAN);
    $criteria_workflow_employee->addAscendingOrderByColumn(WorkflowPeer::PLANNED_DATE); 
    $criteria_workflow_employee->setLimit(15);
    $this->workflows = WorkflowPeer::doSelect($criteria_workflow_employee);
    
    
    $cw2 = new Criteria();
    $cw2->add(WorkflowPeer::STATUS_NAME,WorkflowPeer::STATUS_PLAN, Criteria::ALT_NOT_EQUAL);
    $cw2->addDescendingOrderByColumn(WorkflowPeer::PLANNED_DATE); 
    $cw2->setLimit(15);
    $this->workflows2 = WorkflowPeer::doSelect($cw2);
    
    $this->workflow_title2 = "Timeline";
    // $cw->add()
    
    // liste des projet pour l'employé loggué
    $cp = new Criteria();
    $cp->addJoin(ProjectPeer::ID, ProjectEmployeePeer::PROJECT_ID, Criteria::LEFT_JOIN);
    $cp->addJoin(ProjectPeer::STATUS_PROJECT_ID, StatusProjectPeer::ID, Criteria::LEFT_JOIN);
    $cp->addJoin(ProjectEmployeePeer::EMPLOYEE_ID, EmployeePeer::ID, Criteria::LEFT_JOIN);
    //affiche que les projet pour lequel l'employée est lié
    $cp->add(EmployeePeer::ID, $this->id_employee); 
    //affiche que les projets actifs   
    $cp->add(StatusProjectPeer::POSITION, 200, Criteria::LESS_THAN);
    $cp->addDescendingOrderByColumn(ProjectPeer::ID);
    
    $this->projects = ProjectPeer::doSelect($cp);
    
    

    
  }

  

  
  public function executeSearch($request)
  {
     $query = $request->getParameter('query');
     $query = trim($query);
     
     // looking for a contact (command c<space>QUERY)
     if(preg_match('/c (.*)/i', $query, $matches))
     {
        $query = $matches[1];
        return $this->redirect('@search_company?query='.$query);
     }
     
     return $this->redirect('@search_project?query='.$query);
  }

}
