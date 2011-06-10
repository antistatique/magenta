<?php

/**
 * project actions.
 *
 * @package    Magenta
 * @subpackage project 
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9306 2008-05-27 03:52:55Z dwhittle $
 */
class projectActions extends magentaActions
{
  
  /**
   * Executes index action
   * Forward to the list action
   * @param sfRequest $request A request object
   */  
  public function executeIndex($request)
  {
    $this->forward('project', 'list');    
  }
  
  /**
   * Executes list action
   * Refer to components.class.php, the list action components hold all the logic for listing companies
   * @param sfRequest $request A request object
   */  
  public function executeList($request)
  {
    // refer to the components.class.php :-)
  }


  /**
   * Executes Search action
   * Refer to components.class.php, the list action components hold all the logic for listing projects
   * @param sfRequest $request A request object
   */  
  public function executeSearch($request)
  {

  }

  /**
   * Executes show action
   * Display the details of a given project
   * @param sfRequest $request A request object
   * @param out Project $project the project to display
   * @param out Array $workflow_list the workflow_list related to the project
   */
  public function executeShow($request)
  {
    $criteria_project = new Criteria();
    
    MagentaAccessRestrictions::applyFilterSecurityProject($criteria_project);
    $criteria_project->add(ProjectPeer::ID, $request->getParameter('id', 0));
    
    $this->forward404Unless($project = ProjectPeer::doSelectOne($criteria_project));
    $this->project = $project;
    $this->workflow_list = WorkflowPeer::listWorkflow($project->getId());
  }
  
  /**
   * Executes preview description action
   * Display a preview of the markdown description
   * @param sfRequest $request A request object
   */
  public function executePreview($request)
  {
      $this->description_preview = $request->getParameter('data', '');
  }  
  

  /**
   * Executes detail action
   * Display the details of a given project Use for ajax request need only project detail
   * @param sfRequest $request A request object
   * @param out Project $project the project to display
   * @todo Secure this function according to the credential
   */
  public function executeDetail($request)
  {

    $this->forward404Unless($project = ProjectPeer::retrieveByPk($request->getParameter('id')));
    $this->project = $project;
       
    if(!$this->request->isXmlHttpRequest()){
      $this->redirect('project/show?id='.$project->getId());   
    }

    
  }
  
  /**
   * Executes edit action
   * Edit and Add project, display form and form errors or forward to show or detail
   * If the project has just been created, it loads fixtures from 800_project_workflow_template.yml
   * @param sfRequest $request A request object
   * @param out Project $project the project to display
   * @param out Array $workflow_list the workflow_list related to the project
   */  
  public function executeEdit($request)
  {
    $this->form = new ProjectForm(ProjectPeer::retrieveByPk($request->getParameter('id')));
    $this->company_selected = false;        
    if($request->hasParameter('company')){
       $this->form->setDefault('project_company_list',$request->getParameter('company'));     
       $this->company_selected = true;    
    }

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('project'));
      if ($this->form->isValid())
      {
        if(!$this->form->isNew())
        {
          $old_status_project_id = ProjectPeer::retrieveByPk($request->getParameter('id'))->getStatusProjectId();
        }
        
        $project = $this->form->save();
        
        //if is new ....        
        if($this->form->isNew())
        {
          
          // add a task workflow "project creation"
          $fixture_file = sfConfig::get('sf_config_dir').'/fixtures/800_project_workflow_template.yml';
          $data = sfYaml::load($fixture_file);
          // define the project id
          $project_id = $project->getId();
          // define the author id
          $author_id = $this->getUser()->getEmployeeId();
          // define the updated date
          $updated_date = date('Y/m/d');     
          foreach ($data['Workflow'] as $key => $val) {
            $data['Workflow'][$key]['project_id'] = $project_id;
            $data['Workflow'][$key]['manager_id'] = $author_id;      
            $data['Workflow'][$key]['author_id'] = $author_id;
            $data['Workflow'][$key]['planned_date'] = $updated_date;            
            $workflow = new Workflow();
            $workflow->fromArray($data['Workflow'][$key], BasePeer::TYPE_FIELDNAME);
            $workflow->save();
          }
          
          $this->dispatcher->notify(new sfEvent($this, 'project.add', array('object' => $project)));
        }
        else
        {
          $this->updateWorkflowSystem($project->getStatusProjectId(), $old_status_project_id , $project->getId());
          $this->dispatcher->notify(new sfEvent($this, 'project.update', array('object' => $project)));
        }
        
        
        $request->setParameter('id', $project->getId());
        if($request->isXmlHttpRequest())
        {
          $this->forward('project','detail');
        }
        else
        {
          $this->displayMessage('Mandat mis à jour avec succès', 'success', true);
          $this->redirect('project/show?id='.$project->getId());
        }
      }
            
      $this->workflow_list = WorkflowPeer::listWorkflow($request->getParameter('id'));
      // //there is an error with the form send a 406
      // FIXME: only if ajax
      $this->getResponse()->setStatusCode(406);
    }
  }
  
  /**
   * Executes add field projectEmployee and function action
   * Retrieve form elements to add employee and function to a give project
   * @param sfRequest $request A request object
   */  
  public function executeAddAjaxProjectEmployee($request){
    $this->new_number = 'new'.$request->getParameter('new');
    $this->employee_list = EmployeePeer::doSelect(new Criteria());
    $this->function_project_employee_list = FunctionProjectEmployeePeer::doSelect(new Criteria());    
  }
  
  
  /**
   * Change project status
   * @param sfRequest $request A request object
   */  
  public function executeChangeStatusProject($request){
    $project = ProjectPeer::retrieveByPk($request->getParameter('project_id'));
    $this->forward404Unless($request->isMethod('post') && $project);
    
    $new_status_project_id = $request->getParameter('status_project_id');
    $old_status_project_id = $project->getStatusProjectId();
    try {
      // Set new status and save
      $project->setStatusProjectId($new_status_project_id);
      $project->save();
    } catch(PropelException $e) {
      // on error, display a message and stop.
      $this->displayMessage('Erreur: Impossible de changer le status du projet', 'error', true);
      return $this->redirect('project/show?id='.$project->getId());
    }

    // create workflow event
    $this->updateWorkflowSystem($project->getStatusProjectId(), $old_status_project_id , $project->getId());
    $this->dispatcher->notify(new sfEvent($this, 'project.update', array('object' => $project)));

    // notification display             
    $this->displayMessage('Status du projet mis à jour avec succès', 'success', true);
    return $this->redirect('project/show?id='.$project->getId());
  }  



  /**
   * Executes delete action
   * Delete the given project
   * @param sfRequest $request A request object
   */
  public function executeDelete($request)
  {
   /*
      TODO remove
   */
    $this->forward404Unless($project = ProjectPeer::retrieveByPk($request->getParameter('id')));

    $this->dispatcher->notify(new sfEvent($this, 'project.delete', array('object' => $project)));

    $project->delete();
    
    $this->displayMessage('L&#x27;enregistrement a été effacé avec succès !', 'success');    

    $this->redirect('project/list');
  }
    
  
  
  protected function updateWorkflowSystem($new_status_project_id, $old_status_project_id, $project_id)
  {
    if($new_status_project_id<>$old_status_project_id){
      $c_new = new Criteria();
      $c_new->add(StatusProjectPeer::ID, $new_status_project_id);
      $statusNew = StatusProjectPeer::doSelectOne($c_new);

      $c_old = new Criteria();
      $c_old->add(StatusProjectPeer::ID, $old_status_project_id);
      $statusOld = StatusProjectPeer::doSelectOne($c_old);

      
      $workflow = new Workflow();
      $workflow->setTitle($statusNew->getName());
      $workflow->setDescription('Changement de statut ('.$statusOld->getName().' à '.$statusNew->getName().')');
      $workflow->setPlannedDate(date('Y-m-d H:i:s'));
      $workflow->setStatusName(WorkflowPeer::STATUS_DONE);
      $workflow->setTypeWorkflow(WorkflowPeer::TYPE_SYSTEM);
      $workflow->setAuthorId($this->getUser()->getEmployeeId());
      $workflow->setManagerId($this->getUser()->getEmployeeId());
      /** 
       * @todo change this ... properly
       **/
      $workflow->setCategoryWorkflowId('autre');
      $workflow->setProjectId($project_id);
      $workflow->save();
      
    }

  }
  
}
