<?php

/**
 * Workflow form.
 *
 * @package    Magenta
 * @subpackage form
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: sfPropelFormTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
class WorkflowForm extends BaseWorkflowForm
{
    
  public function configure()
  {
      /// Widgets
      $this->widgetSchema['planned_date'] = new sfWidgetFormJQueryDate(array(
         'culture' => 'fr',
         'date_widget' => new sfWidgetFormDate(array('format' => '%day%/%month%/%year%')),
      ));
      $this->widgetSchema['project_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['author_id'] = new sfWidgetFormInputHidden();      
      
      $this->widgetSchema['type_workflow'] = new sfWidgetFormSelectRadio(
        array('choices' => WorkflowPeer::getTypeWorkflows())
      );      
      $this->widgetSchema['status_name'] = new sfWidgetFormSelectRadio(
        array('choices' => WorkflowPeer::getStatusNames())
      );
      
      /// labels
      $this->widgetSchema->setLabels(array(
         'title'               => 'Titre',
         'description'         => 'Description',
         'planned_date'        => 'Date plannifiée',
         'status_name'         => 'Statut',
         'type_workflow'       => 'Type',
         'manager_id'          => 'Employé',
         'category_workflow_id'=> 'Catégorie',
         'project_id'          => 'Projet',
      ));
      
      // default manager is the current user
      $this->setDefault('manager_id',sfContext::getInstance()->getUser()->getEmployeeId());
      $this->setDefault('planned_date', date('Y-m-d H:i:s'));  
      $this->setDefault('type_workflow',WorkflowPeer::TYPE_TASK);
      $this->setDefault('status_name',WorkflowPeer::STATUS_PLAN);
      //other default refer to action.class.php
      
      
      /// Validators
      
      $this->validatorSchema['status_name'] = new sfValidatorString(
        array('required' => true),
        array('required'  => 'Le statut est obligatoire')
      );
      $this->validatorSchema['type_workflow'] = new sfValidatorString(
        array('required' => true),
        array('required'  => 'Le type est obligatoire')
      );
      $this->validatorSchema['manager_id'] = new sfValidatorString(
        array('required' => true),
        array('required'  => 'L\'employé est obligatoire')
      );      
      $this->validatorSchema['title'] = new sfValidatorString(
        array('required' => true),
        array('required'  => 'Le titre est obligatoire')
      );
      $this->validatorSchema['category_workflow_id'] = new sfValidatorString(
        array('required' => true),
        array('required'  => 'La catégorie est obligatoire')
      );
      
      
      $this->widgetSchema->setFormFormatterName('list');
  }
  
  public function updatePlannedDatecolumn($value)
  {
     // add the actual time
     $ts = strtotime($value);
     $date = date("Y-m-d", $ts) . date(' H:i:s', time());

     return $date;
  }
  
}
