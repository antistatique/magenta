<?php use_helper('magenta'); ?>
<?php use_helper('Text'); ?>
<div id="detailcontent_w" class="detailcontent">
  <ul>
  <?php foreach($workflow_list as $workflow): ?>
  <li id="workflow_item_<?php echo $workflow->getId(); ?>" class="workflow_item" workflow_id="<?php echo $workflow->getId(); ?>">
    <div class="liste1c ico_workflow_task_<?php echo $workflow->getTypeWorkflow()==WorkflowPeer::TYPE_SYSTEM ? WorkflowPeer::TYPE_SYSTEM : $workflow->getStatusName(); ?>">
    <?php echo coupe_str($workflow->getTitle(), 40); ?><br/>
    <?php if ($workflow->getTypeWorkflow()!=WorkflowPeer::TYPE_SYSTEM): ?>
      <span class="listeitemarrow"><?php echo $workflow->getEmployeeRelatedByManagerId(); ?></span>      
    <?php endif ?>
    </div>


    <div class="liste3c liste3right">
    <?php if ($workflow->getTypeWorkflow()!=WorkflowPeer::TYPE_SYSTEM): ?>
            <?php echo $workflow->getStatusRealName(); ?><br/>
    <?php endif;?>
        <span class="listeitemfade">
          <?php echo $workflow->getPlannedDate('d/m/Y'); ?><br/>
        </span>                
  
    </div>

    <div class="show_workflow_detail">
      <p><?php echo nl2br(auto_link_text($workflow->getDescription(), 'all', array('target' => '_blank'))); ?><br/>
        <?php if ($workflow->getTypeWorkflow()!=WorkflowPeer::TYPE_SYSTEM): ?>
          Type : <?php echo $workflow->getRealTypeWorkflow(); ?><br/>
           Catégorie : <?php echo $workflow->getCategoryWorkflow(); ?>
        <?php endif;?>        

      </p>
      
    
      <div class="detailmenu">
         <ul>
     <?php if($sf_user->hasCredential('can_workflow_modify')): ?>            
           <li><a href="<?php echo url_for('@edit_workflow?id='.$workflow->getId());?>" class="detailmenuitem modifier modifier_workflow">Modifier</a></li>
    <?php endif;?> 
          <?php if($workflow->getStatusName()=='plan'&&$sf_user->hasCredential(array('can_workflow_admin', 'can_workflow_modify', 'can_workflow_set_as_done'), false)):?>
           <li><a href="<?php echo url_for('@taskasdone_project?id='.$workflow->getId());?>" class="detailmenuitem modifier_tache">Marqué comme effectué</a></li>         
          <?php endif;?>
         </ul>          
      </div>
     
    </div>



  </li>
  <?php endforeach;?>
  </ul>
</div>
<?php if($sf_user->hasCredential(array('can_workflow_admin', 'can_workflow_modify'), false)): ?>
<div class="detailmenu">
   <ul>
     <li class="listefooter"><a href="<?php echo url_for('@add_workflow?project_id='.$project_id) ;?>" class="detailmenuitem ajoutertache" id="ajouter_workflow">Ajouter un événement</a></li>     
   </ul>          
</div>
<?php endif;?>