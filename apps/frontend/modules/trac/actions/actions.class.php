<?php

/**
 * trac actions.
 *
 * @package    Magenta
 * @subpackage trac
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class tracActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
    $this->forward('trac', 'list');
  }
  
  
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
   public function executeList($request)
   {
     $this->trac_list = sfConfig::get('app_trac_list');
     
     $c = new Criteria();
     $c->addJoin(StatusProjectPeer::ID, ProjectPeer::STATUS_PROJECT_ID);
     $c->add(StatusProjectPeer::POSITION, 200, Criteria::LESS_THAN);     
     $c->add(ProjectPeer::TRAC_LINK, '', Criteria::NOT_LIKE);      
     
     $this->trac_project_list = ProjectPeer::doSelect($c);
     
     
     $c2 = new Criteria();
     $c2->addJoin(StatusProjectPeer::ID, ProjectPeer::STATUS_PROJECT_ID);
     $c2->add(StatusProjectPeer::POSITION, 190, Criteria::GREATER_THAN);     
     $c2->add(ProjectPeer::TRAC_LINK, '', Criteria::NOT_LIKE);      
     $this->trac_project_list_unactive = ProjectPeer::doSelect($c2);

     
   }  
   
   /**
    * Executes submenu action
    *
    * @param sfRequest $request A request object
    */
    public function executeSubMenu($request)
    {
      $this->trac_list = sfConfig::get('app_trac_list');

    }   
  
}
