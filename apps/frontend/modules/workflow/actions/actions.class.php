<?php

/**
 * workflow actions.
 *
 * @package    Magenta
 * @subpackage workflow
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class workflowActions extends magentaActions
{
   /**
    * Executes list workflow action
    * Display the workflow for a given project
    * @param sfRequest $request A request object
    * @param out Array $workflow_list the workflow_list related to the project
    * @todo Secure this function according to the credential
    */
   public function executeList(sfWebRequest $request)
   {
      /** @todo **/
      $this->forward404Unless($project = ProjectPeer::retrieveByPk($request->getParameter('id')));
      //retrieve the workflow list for a given project
      $this->workflow_list = WorkflowPeer::listWorkflow($project->getId());
   }
   
   public function executeEdit(sfWebRequest $request)
   {
      /*
         TODO refactorize (extract edit form from update workflow)
      */
      $this->form = new WorkflowForm(WorkflowPeer::retrieveByPk($request->getParameter('id')));

      //add a new workflow related to this project
      if($request->hasParameter('project_id')){
        $this->project_id = $request->getParameter('project_id');
        $this->project = ProjectPeer::retrieveByPk($this->project_id);
        // set form default values project_id and author_id
        $this->form->setDefault('project_id', $this->project_id);
        $this->form->setDefault('author_id', $this->getUser()->getEmployeeId());
      }


      if ($request->isMethod('post'))
      {
        $this->form->bind($request->getParameter('workflow'));
        if ($this->form->isValid())
        {
          $is_new = $this->form->isNew();
          $workflow = $this->form->save();
          
          if($is_new)
          {
             $this->dispatcher->notify(new sfEvent($this, 'workflow.add', array('object' => $workflow)));
          }
          else
          {
             $this->dispatcher->notify(new sfEvent($this, 'workflow.update', array('object' => $workflow)));
          }
          
          
          $request->setParameter('id', $workflow->getProjectId());


          if($this->request->isXmlHttpRequest())
          {
            $this->displayMessage('Workflow mis à jour avec succès', 'success', false);
            $this->forward('project','detail');      
          }
          else
          {
            $this->displayMessage('Workflow mis à jour avec succès', 'success', true);      
            $this->redirect('@show_project?id='.$workflow->getProjectId());
          }
        }
      }

      if(!$this->project_id){
        $params = $request->getParameter('workflow');
        $this->project_id = $params['project_id'];
        //$this->project_id = $request->getParameter('workflow[project_id]');
      }

      $this->workflow_list = WorkflowPeer::listWorkflow($this->project_id);
   }

   public function executeShow(sfWebRequest $request)
   {
      /** @todo **/
   }
   
   /**
    * Executes save as done for a given workflow
    * Ajax action that set the given workflow as done
    * @param sfRequest $request A request object
    */
   public function executeTaskAsDone(sfWebRequest $request)
   {
      // manage errors
      $this->forward404Unless($workflow = WorkflowPeer::retrieveByPk($request->getParameter('id')));      

      $workflow->setStatusName('done');
      $workflow->save();
      $this->dispatcher->notify(new sfEvent($this, 'workflow.taskAsDone', array('object' => $workflow)));

      $request->setParameter('id', $workflow->getProjectId());
      if($this->request->isXmlHttpRequest())
      {
        $this->displayMessage('Workflow mis à jour avec succès', 'success', false);
        $this->forward($this->getModuleName(), 'list');
      }
      else
      {
        $this->displayMessage('Workflow mis à jour avec succès', 'success', true);      
        $this->redirect('project/show?id='.$workflow->getProjectId());
      }
   }
   
   public function executeDelete(sfWebRequest $request)
   {
      /** @todo **/
      
      $this->forward404Unless($workflow = WorkflowPeer::retrieveByPk($request->getParameter('id')));
      $project_id = $workflow->getProjectId();

      $this->dispatcher->notify(new sfEvent($this, 'workflow.delete', array('object' => $workflow)));
      
      $workflow->delete();

      $this->displayMessage('L&#x27;enregistrement a été effacé avec succès !', 'success');    

      $this->redirect('project/show?id='.$project_id);
   }
   
   protected function listWorkflow($id)
   {
     /*
      TODO remove this function
     */
     return WorkflowPeer::listWorkflow($id);
   }
}
