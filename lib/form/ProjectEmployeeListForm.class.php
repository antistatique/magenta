<?php

/**
 * ProjectEmployeeList form.
 * part form embeded in projectForm.class.php to display projectEmployee and select their functions 
 * Save process done in projectForm
 *
 * @package    Magenta
 * @subpackage form
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: sfPropelFormTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
class ProjectEmployeeListForm extends BaseFormPropel
{
  public function configure()
  {
    $project = $this->getObject();
    
    // embed one form for each employee
    foreach ($project->getProjectEmployees() as $index=>$projectEmployee)
    {
      $form = new ProjectEmployeeForm($projectEmployee, array('index' => $index));
      $this->embedForm(strval($index), $form);
    }
    
    // Create the 'new' form for adding an other employee to the list
    $projectNewEmployeeForm = new ProjectEmployeeForm(null);
    if($project->isNew())
    {
      $projectNewEmployeeForm->setDefault('employee_id', sfContext::getInstance()->getUser()->getEmployeeId());      
      $projectNewEmployeeForm->setDefault('function_project_employee_id', FunctionProjectEmployeePeer::PROJECT_MANAGER);    
    }
    $this->embedForm('new', $projectNewEmployeeForm);
    
    
    $this->widgetSchema->setNameFormat('[%s]');
    
    // add a post validator
    $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'checkProjectEmployeeList')))
    );
    
    // FIXME: Actually we allow that's javascript can add extra fields
    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);
  }


  public function getModelName()
  {
    return "Project";
  }
  



  public function checkProjectEmployeeList($validator, $values)
  {
    $is_empty = true;
    if (is_array($values))
    {
      foreach($values as $key => $value) {
        if(isset($value['employee_id']) && $value['employee_id'])
        {
          $is_empty = false;
          break;
        }
      }
    }
    
    if($is_empty)
    {
      // global form error
      //throw new sfValidatorError($validator, 'Choisir au moins un employé');
      // FIXME:
      throw new sfValidatorErrorSchema($validator, array(
        'employee_id' => new sfValidatorError($validator, 'Choisir au moins un employé')
      ));
      
    }
    
    return $values;
  }
  
  
  
}
