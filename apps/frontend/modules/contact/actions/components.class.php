<?php

/**
 * contact component.
 *
 * @package    Magenta
 * @subpackage contact
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class contactComponents extends sfComponents
{
  public function executeSubmenu()
  {

  }
  
  /**
   * Component to display the contact list
   *
   * @param sfRequest $request A request object   
   * @param in  bool    $auto_display_details
   * @param out sfPager $pager the list pager
   * @param out integer $load_company_id ...
   * @param out integer $selected_company_id ... 
   * @return
   **/
  public function executeList($request)
  {
    $user = $this->getUser();
    $page = 1;
    //criteria for the list
    $criteria_company = new Criteria();
    
    //manage search
    $this->applySearchQuery($criteria_company);
    
    //Manage filters
    $this->applyFilterType($criteria_company);
    
    //manage security
    MagentaAccessRestrictions::applyFilterSecurity($criteria_company);    
    
    $page = $this->getCurrentPage();

    // Create the list and the pager
    $criteria_company->addAscendingOrderByColumn(CompanyPeer::NAME); // fixme
    
    $pager = new sfPropelPager('Company', sfConfig::get('app_contact_max_per_page', 10));
    $pager->setCriteria($criteria_company);
    $pager->setPage($page);
    $pager->init();
    
    // get the first compagny id of the list
    $results = $pager->getResults();
    $first_company_id = count($results) ? $results[0]->getId() : null;

    // Automaticly load detail of the company ?
    $load_company_id = false;
    if(isset($this->auto_display_details) && $this->auto_display_details)
    {
      $load_company_id = $request->getParameter('id', $first_company_id);
    }
    
    
    $this->pager = $pager;
    $this->load_company_id = $load_company_id;
    $this->selected_company_id = $request->getParameter('id', $first_company_id);
  }

  /**
   * Component to display the company type list with number of company for each
   * Security issues : the security filter for external collaborators is in the getTypCOmpanyListCounted function
   * @param out array() $typeCompanyList ... 
   * @return
   **/
  public function executeTypeCompany()
  {


    if($this->getRequest()->getParameter('type')){
      $this->type_select =  $this->getRequest()->getParameter('type');
    }else{
      $this->type_select = $this->getUser()->getAttribute('type','all','contact/list');      
    }
    
    $this->typeCompanyList = TypeCompanyPeer::getTypeCompanyListCounted();    
    
    //add nb total company
    $c = new Criteria();
    MagentaAccessRestrictions::applyFilterSecurity($c);
    $this->total_nb_company = CompanyPeer::doCount($c);
    
  }
  
  /**
   * Component to display the projects status list
   * Not used.
   * @param out array() $statusProjectList
   * @return
   **/  
  public function executeStatusProject()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(StatusProjectPeer::POSITION);
    $this->statusProjectList = StatusProjectPeer::doSelect($c);    
  }  

  /**
   * Protected function to get and set the current page in the company list
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
      $user->setAttribute('page', $page, 'contact/list');
    }
    elseif($user->hasAttribute('page', 'contact/list'))
    {
      $page = $user->getAttribute('page', $page, 'contact/list');
    }   
  
    return $page;
  }
  
  /**
   * Protected function to get and set the current type of company list
   *
   * @return string $type type of company
   **/
  protected function getCurrentType()
  {
    $type = 'all';
    $request = $this->getRequest();
    $user = $this->getUser(); 
        
    if($request->hasParameter('type'))
    {
      $type = $request->getParameter('type');
      $user->setAttribute('type', $type, 'contact/list');
    }
    elseif($user->hasAttribute('type', 'contact/list'))
    {
      $type = $user->getAttribute('type', $type, 'contact/list');
    }
    
    return $type;

  }
  
  /**
   * Protected function that apply a filter type to the company list
   * @param Criteria $c criteria propel object
   * @return
   **/  
  protected function applyFilterType($c)
  {
    $request = $this->getRequest();
    $user = $this->getUser();
    
    // dans le cas ou on change de filtre .. 
    if($request->getParameter('type')&&!$request->getParameter('page'))
    {
      // reset of page numbering -> go to 1
      $user->setAttribute('page', 1, 'contact/list');    
    }
    $type = $this->getCurrentType();
    if($type && $type != 'all'){
      $c->add(CompanyPeer::TYPE_COMPANY_ID, $type);
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
      $user->setAttribute('type', 'all', 'contact/list');
      $user->setAttribute('page', 1, 'contact/list');
      // do search on contact, too.
      $c->addJoin(CompanyPeer::ID, ContactPeer::COMPANY_ID, Criteria::LEFT_JOIN);

      // Perform OR search
      $critSearch1 = $c->getNewCriterion(CompanyPeer::NAME, '%'.$q.'%', Criteria::LIKE);
      $critSearch1->addOr($c->getNewCriterion(ContactPeer::FIRSTNAME, '%'.$q.'%', Criteria::LIKE));
      $critSearch1->addOr($c->getNewCriterion(ContactPeer::NAME, '%'.$q.'%', Criteria::LIKE));
      $c->add($critSearch1);
      
      $c->setIgnoreCase(true);
      // don't display double entries if a compagny contains multiple contact
      $c->setDistinct(true);
    }

  }  

}
?>