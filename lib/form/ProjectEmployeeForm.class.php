<?php

/**
 * ProjectEmployee form.
 *
 * @package    Magenta
 * @subpackage form
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: sfPropelFormTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
class ProjectEmployeeForm extends BaseProjectEmployeeForm
{
  public function configure()
  {
    
    $this->widgetSchema->setLabels(array(
      'employee_id'                   => 'Employé',
      'function_project_employee_id'  => 'Fonction',
    ));
    
    $this->widgetSchema['employee_id'] = new sfWidgetFormPropelSelect(array('model' => 'Employee', 'add_empty' => true));
   
    // add a post validator
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkProjectEmployee')))
    );

  }
  
  public function checkProjectEmployee($validator, $values)
  {
    if ((!$values['employee_id'] && $values['function_project_employee_id'])||($values['employee_id'] && !$values['function_project_employee_id']))
    {
      // the 2 fields is not filled (one is filled but not the second), throw an (local field related) error
      throw new sfValidatorErrorSchema($validator, array(
        'employee_id' => new sfValidatorError($validator, 'Choisir une fonction et un employé')
      ));
    }
   
    // field is correctly filled, return the clean values
    return $values;
  }
}
