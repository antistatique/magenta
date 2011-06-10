<?php if(!$sf_request->isXmlHttpRequest()):?>
<?php slot('page_title', sprintf("%s un workflow pour \"%s\"", ($form->isNew() ? 'Ajouter':'Editer'), $project)); ?>

<div id="label">
  <?php include_component('project', 'statusProject') ?>
</div><!--end label-->
<div id="detail" class="detailmandat">
<?php endif;?>
<?php $workflow = $form->getObject() ?>
<div id="detailcontent_p" class="detailcontent">
<h2 class="titre"><?php echo $workflow->isNew() ? 'Nouveau' : 'Editer un' ?> Workflow</h2>
  <span class="itemfade"><?php echo isset($project) ? $project : $workflow->getProject(); ?></span><br/>
<form action="<?php echo url_for((!$workflow->isNew() ? '@edit_workflow?id='.$workflow->getId() : '@add_workflow?project_id='.$project_id)) ?>" method="post" id="edit_workflow">

           <?php echo $form->renderGlobalErrors() ?>               
             <ul>     


          <?php echo $form['title']->renderRow(array('class' => 'required_field')) ?>
          <?php echo $form['description']->renderRow() ?>
          <?php echo $form['status_name']->renderRow() ?>
          <?php echo $form['type_workflow']->renderRow() ?>
          <?php echo $form['planned_date']->renderRow() ?>
          <?php echo $form['manager_id']->renderRow(array('class' => 'required_field')) ?>
          <?php echo $form['category_workflow_id']->renderRow(array('class' => 'required_field')) ?>   
          <?php echo $form['project_id'] ?>
          <?php echo $form['author_id'] ?>          
          <?php echo $form['id'] ?> 
          
           </ul>
           <br/><br/>
          </form>
          
</div>
<div id="detailmenu">
<ul>
  <?php if (!$workflow->isNew()): ?>
    <li><input type="submit" name="edit_workflow" value="Modifier" id="modifier" class="bt_submit bt_form"><li>    
    <li><a href="<?php echo url_for('@detail_project?id='.(!$project_id ? $workflow->getProjectId() : $project_id));?>" class="detailmenuitem back" id="detail_project">Retour</a></li>         
    <?php if($sf_user->hasCredential('can_workflow_admin')): ?>           
    <li><?php echo link_to('Supprimer', '@delete_workflow?id='.$workflow->getId(), array('post' => true, 'confirm' => 'Êtes vous sûr de vouloir supprimer cet enregistrement ?', 'class' => 'detailmenuitem remove')); ?></li>                   
    <?php endif; ?>
    
  <?php else:?>
    <li><input type="submit" name="edit_workflow" value="Ajouter" id="add" class="bt_submit bt_form"><li>        
    <li><a href="<?php echo url_for('@detail_project?id='.(!$project_id ? $workflow->getProjectId() : $project_id));?>" class="detailmenuitem back" id="detail_project">Retour</a></li>    
  <?php endif; ?>
  
</ul>          
</div>

<?php if(!$sf_request->isXmlHttpRequest()):?>     
</div>
  <?php if(isset($workflow_list)):?>
    <div id="liste" class="workflowlist">
    <?php include_partial('workflow/list', array('workflow_list' => $workflow_list, 'project_id' => $form->getObject()->getId())) ?>
    </div>
  <?php endif;?>
<?php endif;?>