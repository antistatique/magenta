<?php

/**
 * MagentaAccessRestrictions class
 *
 * @package    Magenta
 * @subpackage contact
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class MagentaAccessRestrictions
{
  /**
   * Protected function that apply a filter for security reason, certain permission let access to the whole list of company. 
   * Others let just access companies that have project which user is working on
   * @param Criteria $c criteria propel object
   * @return
   **/  
  public static function applyFilterSecurity($c)
  {
    $user = sfContext::getInstance()->getUser();
    // if the user is not admin or icollab so he's a ecollab
    // adding where clause for contact whose having a project the user is working on
    // the sql syntaxe should be this :
    // SELECT * FROM company LEFT JOIN project_company ON company.id = project_company.company_id 
    // LEFT JOIN project ON project_company.project_id = project.id 
    // LEFT JOIN project_employee ON project.id = project_employee.project_id 
    // LEFT JOIN employee ON project_employee.employee_id = employee.id 
    // WHERE employee.sf_guard_user_id = 68;
    if(!$user->hasCredential('admin')&&!$user->hasCredential('icollab')){
      $c->addJoin(CompanyPeer::ID, ProjectCompanyPeer::COMPANY_ID, Criteria::LEFT_JOIN);
      $c->addJoin(ProjectCompanyPeer::PROJECT_ID, ProjectPeer::ID, Criteria::LEFT_JOIN);
      $c->addJoin(ProjectPeer::ID, ProjectEmployeePeer::PROJECT_ID, Criteria::LEFT_JOIN);
      $c->addJoin(ProjectEmployeePeer::EMPLOYEE_ID, EmployeePeer::ID, Criteria::LEFT_JOIN);
      $c->add(EmployeePeer::SF_GUARD_USER_ID,$user->getGuardUser()->getId());
    }
  }
  
  /**
   * Protected function that apply a filter for security reason, certain permission let access to the whole list of company. 
   * Others let just access companies that have project which user is working on
   * @param Criteria $c criteria propel object
   * @return
   **/  
  public static function applyFilterSecurityProject($c)
  {
    $user = sfContext::getInstance()->getUser();
    // if the user is not admin or icollab so he's a ecollab
    // adding where clause for contact whose having a project the user is working on
    // the sql syntaxe should be this :
    // SELECT * FROM company LEFT JOIN project_company ON company.id = project_company.company_id 
    // LEFT JOIN project ON project_company.project_id = project.id 
    // LEFT JOIN project_employee ON project.id = project_employee.project_id 
    // LEFT JOIN employee ON project_employee.employee_id = employee.id 
    // WHERE employee.sf_guard_user_id = 68;
    if(!$user->hasCredential('admin')&&!$user->hasCredential('icollab')){
      $c->addJoin(ProjectPeer::ID, ProjectEmployeePeer::PROJECT_ID, Criteria::LEFT_JOIN);
      $c->addJoin(ProjectEmployeePeer::EMPLOYEE_ID, EmployeePeer::ID, Criteria::LEFT_JOIN);
      $c->add(EmployeePeer::SF_GUARD_USER_ID,$user->getGuardUser()->getId());
    }
  }  
}