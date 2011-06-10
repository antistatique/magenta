<?php


/**
 * Skeleton subclass for performing query and update operations on the 'type_company' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class TypeCompanyPeer extends BaseTypeCompanyPeer {
  
  /**
   * Return an array of company's type with the number of companies for each.
   * Security : Restricted according to the ContactAccessRestrictions class
   * @return array Array of companies type (id => company_type_id, name, nb => number of company) with the number of companies for each.
   */
  public static function getTypeCompanyListCounted($criteria = null)
  {

    $connection = Propel::getConnection();
    
    $c = new Criteria();
    
    $c->addJoin(TypeCompanyPeer::ID, CompanyPeer::TYPE_COMPANY_ID, Criteria::LEFT_JOIN);

    MagentaAccessRestrictions::applyFilterSecurity($c);
    
    $c->clearSelectColumns();
    
    $c->addSelectColumn(TypeCompanyPeer::ID);
    $c->addSelectColumn(TypeCompanyPeer::NAME);
    $c->addSelectColumn('COUNT('.CompanyPeer::ID.')');
    $c->addGroupByColumn(TypeCompanyPeer::ID);
    $c->addGroupByColumn(TypeCompanyPeer::NAME);
    
    $c->addAscendingOrderByColumn(TypeCompanyPeer::ID);
    
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
    
    $type_company = array();
        
    while($resultset = $statement->fetch(PDO::FETCH_NUM)) {
      
       $type_company[] = array( 'id' => $resultset[0], 'name' => $resultset[1], 'nb' => $resultset[2]);
    }    
    
    return $type_company;
    
  }
  
} // TypeCompanyPeer
