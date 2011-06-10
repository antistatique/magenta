<?php use_helper('Text'); ?>
<div id="detailcontent_w" class="detailcontent">
  <ul>
          <li class="liste_titre"><h2><?php echo $workflow_title; ?>
             <form action="<?php echo url_for('@dashboard_employee')?>" method="get" accept-charset="utf-8" id="employee_select">
                <select name="employee_id"  size="1">
                   <?php foreach($employee_list as $employee):?>
                  <option value="<?php echo $employee->getUsername(); ?>" <?php echo $id_employee == $employee->getId() ? 'selected="selected"': '' ?>><?php echo $employee;?></option>
                    <?php endforeach;?>
                </select>             
             </form>
              </h2>

             
             </li>
  <?php foreach($workflows as $workflow): ?>
  <li id="workflow_item_<?php echo $workflow->getId(); ?>" class="workflow_item <?php echo $workflow->getStatusDayLateName(); ?>" workflow_id="<?php echo $workflow->getId(); ?>">
    <div class="liste1c ico_workflow_task_<?php echo $workflow->getTypeWorkflow()==WorkflowPeer::TYPE_SYSTEM ? WorkflowPeer::TYPE_SYSTEM : $workflow->getStatusName(); ?>">
    <?php echo coupe_str($workflow->getTitle(), 40); ?> (<?php echo $workflow->getEmployeeRelatedByManagerId(); ?>)<br/>

   
      <span class="listeitemarrow"><a href="<?php echo url_for('@show_project?id='.$workflow->getProject()->getId()) ;?>" alt"<?php echo $workflow->getProject()->getTitle(); ?>"><?php echo coupe_str($workflow->getProject()->getTitle(), 40); ?></a>   </span>      

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
      <p><?php echo nl2br(auto_link_text($workflow->getDescription(), 'all', array('target' => '_blank')));?><br/>
        <?php if ($workflow->getTypeWorkflow()!=WorkflowPeer::TYPE_SYSTEM): ?>
          Type : <?php echo $workflow->getRealTypeWorkflow(); ?><br/>
           Catégorie : <?php echo $workflow->getCategoryWorkflow(); ?>
        <?php endif;?>        

      </p>
      
    
      <div class="detailmenu">
         <ul>
     <?php if($sf_user->hasCredential('can_workflow_modify')): ?>            
           <li><a href="<?php echo url_for('@edit_workflow?id='.$workflow->getId());?>" class="detailmenuitem modifier">Modifier</a></li>
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