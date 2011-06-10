<?php

/**
 * employee actions.
 *
 * @package    Magenta
 * @subpackage employee
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class employeeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
    $this->forward($this->getModuleName(), 'list');
  }
  
  /**
   * List Employees
   *
   * @see EmployeeComponents::executeList
   */
  public function executeList($request)
  {
    // see components class.
  }
  
  public function executeDetail($request)
  {
    $criteria_employee = new Criteria();
    $criteria_employee->add(EmployeePeer::ID, $this->getRequestParameter('id', 0));
    $this->employee = EmployeePeer::doSelectOne($criteria_employee);    
  }
  
  /**
   * Executes edit action
   * Edit and Add project, display form and form errors or forward to show or detail
   * If the project has just been created, it loads fixtures from 800_project_workflow_template.yml
   * @param sfRequest $request A request object
   * @param out Project $project the project to display
   * @param out Array $workflow_list the workflow_list related to the project
   */  
  public function executeEdit($request)
  {
    $this->form = new EmployeeForm(EmployeePeer::retrieveByPk($request->getParameter('id')));
    
    
    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('employee'));
      if ($this->form->isValid())
      {
        $employee = $this->form->save();

        if($request->isXmlHttpRequest())
        {
          $request->setParameter('id', $employee->getId());
          $this->forward('employee','detail');
        }
        else
        {
          $this->displayMessage('Employee mis à jour avec succès', 'success', true);
          $this->redirect('employee/detail?id='.$employee->getId());
        }
        
      }
      elseif($request->isXmlHttpRequest())
      {
        //there is an error with the form send a 406
        $this->getResponse()->setStatusCode(406);
      } 
    }
  }
  
}
