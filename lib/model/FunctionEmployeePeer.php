<?php


/**
 * Skeleton subclass for performing query and update operations on the 'function_employee' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class FunctionEmployeePeer extends BaseFunctionEmployeePeer
{
  
  /**
   * Return an array of employee's type (function) with the number of employees for each.
   *
   * @return array Array of employees type (id => function_employee_id, name, nb => number of employee)
   */
  public static function getFunctionEmployeeListCounted($criteria = null)
  {

    $connection = Propel::getConnection();
    
    $c = new Criteria();
    
    $c->addJoin(self::ID, EmployeePeer::FUNCTION_EMPLOYEE_ID, Criteria::LEFT_JOIN);
    
    $c->clearSelectColumns();
    
    $c->addSelectColumn(self::ID);
    $c->addSelectColumn(self::NAME);
    $c->addSelectColumn('COUNT('.EmployeePeer::ID.')');
    $c->addGroupByColumn(self::ID);
    $c->addGroupByColumn(self::NAME);
    
    $c->addAscendingOrderByColumn(self::ID);
    
    $statement = parent::doSelectStmt($c);
    $types = array();
    while($resultset = $statement->fetch(PDO::FETCH_NUM))
    {
      $types[] = array( 'id' => $resultset[0], 'name' => $resultset[1], 'nb' => $resultset[2]);
    }
    
    return $types;
  }
  
}
