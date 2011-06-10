<?php

/**
 * project component.
 *
 * @package    Magenta
 * @subpackage project
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: components.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class projectComponents extends sfComponents
{
  
  public function executeSubmenu()
  {
    
  }
  
  public function executeList(sfWebRequest $request)
  {
   $user = $this->getUser();
   $page = 1;
   
   //criteria for the list
   $criteria_project = new Criteria();
   
   if($request->hasParameter('query'))
   {
       //manage search
       $this->applySearchQuery($criteria_project);
   }
   else
   {
       //Manage filters
       $this->applyFilterStatusProject($criteria_project);
   }

    
   //manage security
   MagentaAccessRestrictions::applyFilterSecurityProject($criteria_project);
    
   // Create the list and the pager
   $criteria_project->addDescendingOrderByColumn(ProjectPeer::CREATED_AT); // fixme
    
   $page = $this->getCurrentPage();    
    
   $pager = new sfPropelPager('Project', sfConfig::get('app_project_max_per_page', 10));
   $pager->setCriteria($criteria_project);
   $pager->setPage($page);
   $pager->init();
  
   $this->pager = $pager;
  }
  
  /**
   * Component to display the projects status list
   *
   * @param out array() $statusProjectList
   * @return
   **/  
  public function executeStatusProject()
  {
    $this->statusProjectList = StatusProjectPeer::getStatusProjectListCounted(); 
    if($this->getRequest()->getParameter('status')){
      $this->status_select =  $this->getRequest()->getParameter('status');
    }else{
      $this->status_select = $this->getUser()->getAttribute('status','all','project/list');      
    }

    //add nb total project
    $total_nb_project = 0;
    foreach($this->statusProjectList as $status)
    {
      $total_nb_project += $status['nb'];
    }
    $this->total_nb_project = $total_nb_project;
    
    //add nb active project
    $c = new Criteria();
    $c->addJoin(StatusProjectPeer::ID, ProjectPeer::STATUS_PROJECT_ID);
    $c->add(StatusProjectPeer::POSITION, 200, Criteria::LESS_THAN);
    MagentaAccessRestrictions::applyFilterSecurityProject($c);    
    $this->active_nb_project = ProjectPeer::doCount($c);
    
  }
  
  /**
   * Component to display the projects status list
   *
   * @param out array() $statusProjectList
   * @return
   **/  
  public function executeChangeStatusProjectForm()
  {
    $this->statusProjectList = StatusProjectPeer::getStatusProjectList();
  }
  


  /**
   * Protected function to get and set the current page in the project list
   *
   * @return integer $page page number
   **/
  protected function getCurrentPage(){
    
    $request = $this->getRequest();
    $user = $this->getUser();    
    $page = 1;
    // Manage the current page
    if($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
      $user->setAttribute('page', $page, 'project/list');
    }
    elseif($user->hasAttribute('page', 'project/list'))
    {
      $page = $user->getAttribute('page', $page, 'project/list');
    }   
  
    return $page;
  }  
  
  
  /**
   * Protected function to get and set the current type of company list
   *
   * @return string $type type of company
   **/
  protected function getCurrentStatusProject()
  {
    $status = 'all';
    $request = $this->getRequest();
    $user = $this->getUser(); 
        
    if($request->hasParameter('status'))
    {
      $status = $request->getParameter('status');
      $user->setAttribute('status', $status, 'project/list');
    }
    elseif($user->hasAttribute('status', 'project/list'))
    {
      $status = $user->getAttribute('status', $status, 'project/list');
    }
    
    return $status;

  }  
  
  /**
   * Protected function that apply a filter type to the company list
   * @param Criteria $c criteria propel object
   * @return
   **/  
  protected function applyFilterStatusProject($c)
  {
    $request = $this->getRequest();
    $user = $this->getUser();
    $status_project = null;
    // dans le cas ou on change de filtre .. 
    if($request->getParameter('status')&&!$request->getParameter('page'))
    {
      // reset of page numbering -> go to 1
      $user->setAttribute('page', 1, 'project/list');    
      $status_project = $request->getParameter('status');
    }
    $status_project = $this->getCurrentStatusProject();
    
    if($status_project && $status_project != 'all'){
      if($status_project=='active'){
        $c->addJoin(StatusProjectPeer::ID, ProjectPeer::STATUS_PROJECT_ID);
        $c->add(StatusProjectPeer::POSITION, 200, Criteria::LESS_THAN);
      }else{
        $c->add(ProjectPeer::STATUS_PROJECT_ID, $status_project);        
      }

    }

  }
  
  /**
   * Protected function that apply a search to the company list on a given keyword
   * @param Criteria $c criteria propel object
   * @return
   **/  
  protected function applySearchQuery($c)
  {
    $request = $this->getRequest();
    $user = $this->getUser();
    
    if($request->hasParameter('query'))
    {
      $q = $request->getParameter('query');
      $user->setAttribute('type', 'all', 'project/list');
      $user->setAttribute('page', 1, 'project/list');
      
      
      $c->addJoin(ProjectPeer::ID, ProjectCompanyPeer::PROJECT_ID);
      $c->addJoin(ProjectCompanyPeer::COMPANY_ID, CompanyPeer::ID);
      $c->addJoin(ProjectPeer::ID, ProjectEmployeePeer::PROJECT_ID);
      $c->addJoin(ProjectEmployeePeer::EMPLOYEE_ID, EmployeePeer::ID);
      
      // Perform OR search on Project Title, Project Type and compagny Name
      $critSearch1 = $c->getNewCriterion(CompanyPeer::NAME, '%'.$q.'%', Criteria::LIKE);
      $critSearch1->addOr($c->getNewCriterion(ProjectPeer::TITLE, '%'.$q.'%', Criteria::LIKE));
      $critSearch1->addOr($c->getNewCriterion(ProjectPeer::NUMBER, '%'.$q.'%', Criteria::LIKE));      
      $critSearch1->addOr($c->getNewCriterion(ProjectPeer::TYPE_PROJECT, '%'.$q.'%', Criteria::LIKE)); // is it working ?
      $critSearch1->addOr($c->getNewCriterion(EmployeePeer::FIRSTNAME, '%'.$q.'%', Criteria::LIKE)); // is it working ?      
      
      $c->add($critSearch1);
      
      $c->setIgnoreCase(true);
      $c->setDistinct(true);
    }

  }
  
}