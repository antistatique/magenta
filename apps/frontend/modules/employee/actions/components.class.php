<?php

/**
 * employee component.
 *
 * @package    Magenta
 * @subpackage employee
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id$
 */
class employeeComponents extends sfComponents
{  
  public function executeSubmenu() {}
  
  /**
   * Component to display the contact list
   *
   * @param sfRequest $request A request object   
   * @param in  bool    $auto_display_details
   * @param out sfPager $pager the list pager
   * @param out integer $load_employee_id ...
   * @param out integer $selected_employee_id ... 
   * @return
   **/
  public function executeList($request)
  {
    $user = $this->getUser();
    $page = $this->getCurrentPage();
    
    //criteria for the list
    $criteria = new Criteria();
    
    //manage search
    // $this->applySearchQuery($criteria);  
    
    //Manage filters
    $this->applyFilterType($criteria);
    $criteria->addAscendingOrderByColumn(EmployeePeer::FUNCTION_EMPLOYEE_ID);
    $criteria->addAscendingOrderByColumn(EmployeePeer::NAME); // FIXME
    
    // Create the list and the pager
    $pager = new sfPropelPager('Employee', sfConfig::get('app_employee_max_per_page', 10));
    $pager->setCriteria($criteria);
    $pager->setPage($page);
    $pager->init();
    
    // get the first employee id of the list
    $results = $pager->getResults();
    $first_id = count($results) ? $results[0]->getId() : null;
    
    // Automaticly load detail of the company ?
    $load_employee_id = false;
    if(isset($this->auto_display_details) && $this->auto_display_details)
    {
      $load_employee_id = $request->getParameter('id', $first_id);
    }
    
    $this->selected_employee_id = $request->getParameter('id', $first_id);
    $this->pager                = $pager;
    $this->load_employee_id     = $load_employee_id;
  }
  
  
  /**
   * Component to display the employees type list with number of employees for each
   *
   * @param out array() $list list of function employees 
   * @param out integer $type_select
   * @param out integer $total_nb_employee
   **/
  public function executeTypeEmployee($request)
  {
    $user = $this->getUser();
    $this->type_select = $request->getParameter('type', $user->getAttribute('type', 'all', 'employee/list'));

    // add nb total employee
    $this->total_nb_employee = EmployeePeer::doCount(new Criteria());
    $this->list = FunctionEmployeePeer::getFunctionEmployeeListCounted();
  }
  
  
  /**
   * Protected function to get and set the current page in the list
   *
   * @return integer $page page number
   **/
  protected function getCurrentPage(){
    
    $request = $this->getRequest();
    $user    = $this->getUser();
    $page    = 1;
    
    // Manage the current page
    if($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
      $user->setAttribute('page', $page, 'employee/list');
    }
    elseif($user->hasAttribute('page', 'employee/list'))
    {
      $page = $user->getAttribute('page', $page, 'employee/list');
    }   
  
    return $page;
  }
  
  
  /**
   * Protected function to get and set the current type of employee list
   *
   * @return string $type type of company
   **/
  protected function getCurrentType()
  {
    $type    = 'all';
    $request = $this->getRequest();
    $user    = $this->getUser(); 
        
    if($request->hasParameter('type'))
    {
      $type = $request->getParameter('type');
      $user->setAttribute('type', $type, 'employee/list');
    }
    elseif($user->hasAttribute('type', 'employee/list'))
    {
      $type = $user->getAttribute('type', $type, 'employee/list');
    }
    
    return $type;
  }
  
  /**
   * Protected function that apply a filter type to the employee list
   * @param Criteria $c criteria propel object
   * @return void
   **/  
  protected function applyFilterType($c)
  {
    $request = $this->getRequest();
    $user = $this->getUser();
    
    // dans le cas ou on change de filtre .. 
    if($request->getParameter('type') && !$request->getParameter('page'))
    {
      // reset of page numbering -> go to 1
      $user->setAttribute('page', 1, 'employee/list');
    }
    
    $type = $this->getCurrentType();
    if($type && $type != 'all')
    {
      $c->add(EmployeePeer::FUNCTION_EMPLOYEE_ID, $type);
    }
  }
}