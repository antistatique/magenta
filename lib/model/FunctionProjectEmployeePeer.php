<?php


/**
 * Skeleton subclass for performing query and update operations on the 'function_project_employee' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class FunctionProjectEmployeePeer extends BaseFunctionProjectEmployeePeer {

  // Constante des functions des employés dans les projets
  
  /**
   * Constant which define the function of an employee for a given project
   * @var string PROJECT_MANAGER
   * @var string COLLABORATOR
   * @var string EXTERNAL   
   */
  const PROJECT_MANAGER     = "project_manager";
  const COLLABORATOR        = "collaborator";
  const EXTERNAL            = "external";

} // FunctionProjectEmployeePeer
