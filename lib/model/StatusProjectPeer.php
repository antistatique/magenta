<?php


/**
 * Skeleton subclass for performing query and update operations on the 'status_project' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class StatusProjectPeer extends BaseStatusProjectPeer {
  
  public static function getStatusProjectListCounted($criteria = null)
  {
    
    $connection = Propel::getConnection();
    
    $c = new Criteria();
    
    $c->addJoin(StatusProjectPeer::ID, ProjectPeer::STATUS_PROJECT_ID, Criteria::LEFT_JOIN);

    MagentaAccessRestrictions::applyFilterSecurityProject($c);
    
    $c->clearSelectColumns();
    
    $c->addSelectColumn(StatusProjectPeer::ID);
    $c->addSelectColumn(StatusProjectPeer::NAME);
    $c->addSelectColumn(StatusProjectPeer::POSITION);    
    $c->addSelectColumn('COUNT('.ProjectPeer::ID.')');
    $c->addGroupByColumn(StatusProjectPeer::ID);
    $c->addGroupByColumn(StatusProjectPeer::NAME);
    $c->addGroupByColumn(StatusProjectPeer::POSITION);    
    
    $c->addAscendingOrderByColumn(StatusProjectPeer::POSITION);
    
    $statement = parent::doSelectStmt($c);
    
    // Generated request
    // SELECT type_company.id, type_company.name, count(company.id) 
    // FROM type_company 
    // LEFT JOIN company ON type_company.id = company.type_company_id 
    // LEFT JOIN project_company ON company.id = project_company.company_id 
    // LEFT JOIN project ON project_company.project_id = project.id 
    // LEFT JOIN project_employee ON project.id = project_employee.project_id 
    // LEFT JOIN employee ON project_employee.employee_id = employee.id 
    // WHERE employee.sf_guard_user_id = 94 
    // GROUP BY type_company.id, type_company.name 
    // ORDER BY type_company.id;
    
    $status_project = array();
        
    while($resultset = $statement->fetch(PDO::FETCH_NUM)) {
      
       $status_project[] = array( 'id' => $resultset[0], 'name' => $resultset[1], 'position' => $resultset[2], 'nb' => $resultset[3]);
    }    

    return $status_project;
  }
  
  public static function getStatusProjectList()
  {
      $c = new Criteria();
      $c->addAscendingOrderByColumn(StatusProjectPeer::POSITION);
      
      return parent::doSelect($c);
  }

} // StatusProjectPeer
