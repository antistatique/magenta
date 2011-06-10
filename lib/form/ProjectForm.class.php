<?php

/**
 * Project form.
 *
 * @package    Magenta
 * @subpackage form
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: sfPropelFormTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
class ProjectForm extends BaseProjectForm
{
  public function configure()
  {
    
    $this->widgetSchema->setLabels(array(
      'slug'              => 'Slug',
      'title'             => 'Titre',
      'number'            => 'Numéro de mandat',
      'description'       => 'Description',
      'trac_link'         => 'Lien Trac',
      'type_project'      => 'Type de mandat',
      'status_project_id' => 'Statut du projet',
      'project_company_list' => 'Entreprise',
      'my_project_employee_list' => 'Liste des collaborateurs du projet',
    ));   
    
    
    // this widget will be replaced by the embed form below
    unset($this->widgetSchema['project_employee_list']);

    $myProjectEmployeeList = new ProjectEmployeeListForm($this->getObject());
    $this->embedForm('my_project_employee_list', $myProjectEmployeeList);

    $this->widgetSchema['project_company_list'] = new sfWidgetFormPropelSelectMany(array('model' => 'Company', 'order_by' => array('Name', 'asc') ));


    $this->widgetSchema['type_project'] = new sfWidgetFormSelect(
      array('choices' => ProjectPeer::getTypeProjects())
    );

    $this->widgetSchema['status_project_id'] = new sfWidgetFormPropelChoice(array('model' => 'StatusProject', 'add_empty' => true, 'order_by' => array('Position', 'asc') ));
    
    $this->validatorSchema['status_project_id'] = new sfValidatorString(
      array('required' => true),
      array('required'  => 'Le statut est obligatoire')
    );    
    

    $this->validatorSchema['slug'] = new sfValidatorString(
    array('required' => true),
    array('required'  => 'Le slug est obligatoire')
    );

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Project', 'column' => array('slug')), array('invalid'=>'Ce slug existe déjà')),
        new sfValidatorPropelUnique(array('model' => 'Project', 'column' => array('number')), array('invalid'=>'Ce numéro existe déjà'))
    )));
    
    $this->setDefault('number',ProjectPeer::getNextNumber());  
  
    $this->validatorSchema['title'] = new sfValidatorString(
    array('required' => true),
    array('required'  => 'Le titre est obligatoire')
    );

    $this->validatorSchema['project_company_list'] = new sfValidatorPropelChoiceMany(
    array('model' => 'Company', 'required' => true),
    array('required'  => 'Au moins une entreprise est obligatoire')
    );    


    $this->validatorSchema['number'] = new sfValidatorString(
    array('required' => true),
    array('required'  => 'Le numéro est obligatoire')
    );      
    
    $this->widgetSchema->setFormFormatterName('list');

  }
  

  protected function doSave($con = null)
  {
    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $this->updateObject();

    $this->object->save($con);
    
    $this->saveProjectCompanyList($con);
    $this->saveMyProjectEmployeeList($con);
    
    // $this->saveEmbeddedForms($con);
  }

  public function saveMyProjectEmployeeList($con = null)
  {

    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProjectEmployeePeer::PROJECT_ID, $this->object->getPrimaryKey());
    ProjectEmployeePeer::doDelete($c, $con);

    $values = $this->getValue('my_project_employee_list');
    
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        if($value['employee_id']&&$value['function_project_employee_id'])
        {

          $obj = new ProjectEmployee();
          $obj->setProjectId($this->object->getPrimaryKey());
          $obj->setEmployeeId($value['employee_id']);
          $obj->setFunctionProjectEmployeeId($value['function_project_employee_id']);
          $obj->save();
        }
      }
    }
  }  

}
