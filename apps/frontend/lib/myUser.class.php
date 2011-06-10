<?php
/**
  * User class.
  *
  * @package    Magenta
  * @subpackage 
  * @author     Marc Friederich <marc@antistatique.net>
  * @version    SVN: $Id: myUser.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class myUser extends sfGuardSecurityUser
{
  /**
   * Redefine method signin to clear user attributes displaying the current page
   *
   */
  public function signIn($user, $remember = false, $con = null)
  {
    $this->getAttributeHolder()->removeNamespace('contact/list');
    $this->getAttributeHolder()->removeNamespace('project/list');
    $this->getAttributeHolder()->removeNamespace('employee/list');
    $this->getAttributeHolder()->removeNamespace('magenta_session');
    $this->getAttributeHolder()->clear();
    
    // to display welcome message to the user
    sfContext::getInstance()->getUser()->setFlash('signin', true);
    
    parent::signIn($user, $remember, $con);
  }
  
  /**
   * Redefine method signout to clear user attributes displaying the current page
   *
   */  
  public function signOut(){
    $this->getAttributeHolder()->removeNamespace('contact/list');
    $this->getAttributeHolder()->removeNamespace('project/list');
    $this->getAttributeHolder()->removeNamespace('employee/list');
    $this->getAttributeHolder()->removeNamespace('magenta_session');
    $this->getAttributeHolder()->clear();
    parent::signOut();
  }
  
  /**
   * Return the employee_id of the session user 
   * @return int employee_id
   */
  public function getEmployeeId(){
    
    if($this->hasAttribute('employee_id', 'magenta_session')){
      return $this->getAttribute('employee_id', null, 'magenta_session');
    }else{
      $employee_id = $this->getProfile()->getId();
      $this->setAttribute('employee_id', $employee_id, 'magenta_session');
      return $employee_id;              
    }
  }
  
  
  /**
   * Returns true if user is authenticated.
   *
   * @return boolean
  */ 
  public function isAuthenticated()
  {
    if (!$this->authenticated)
    {      
      if ($cookie = sfContext::getInstance()->getRequest()->getCookie(sfConfig::get('app_sf_guard_plugin_magenta_remember_me', 'sfRemember')))
      {
        $c = new Criteria();
        $c->add(sfGuardRememberKeyPeer::REMEMBER_KEY, $cookie);
        $rk = sfGuardRememberKeyPeer::doSelectOne($c);
        if ($rk && $rk->getSfGuardUser())
        {
          $this->signIn($rk->getSfGuardUser());
        }
      }
    }
    
    return $this->authenticated;
  }  
  
  
  
}
