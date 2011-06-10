<?php echo use_helper('Date','magenta'); ?>
<?php slot('page_title', sprintf('Dashboard de %s', $employee->getFirstName())); ?>

<div id="label">

</div><!--end label-->
<div id="liste" style="width:122px;margin-right:8px;">


    <ul>
  <?php foreach($projects as $project):?>
      <li id="mandat_item_<?php echo $project->getId() ?>" class="mandat_item" style="width:120px;">
             <div class="liste1c ico_mandat_st_<?php echo $project->getStatusProject()->getPosition(); ?>">
                <strong><?php echo $project->getNumber() ?></strong>
                <a href="<?php echo url_for('@show_project?id='.$project->getId()) ?>" title="<?php echo $project->getTitle() ?>" class="show_project"><?php echo coupe_str($project->getTitle(),14) ?></a>  
                <br/>
                <span class="status_<?php echo $project->getStatusProject()->getPosition(); ?>"><?php echo coupe_str($project->getStatusProject(), 20); ?></span><br/> 
              </div>
            </li>                               
  <?php endforeach;?>
    </ul>

  
</div><!-- end liste-->
<?php if($workflows): ?>
<div id="liste" class="workflowlist">
    <?php include_partial('list', array('workflows' => $workflows, 'workflow_title' => $workflow_title, 'employee_list' => $employee_list, 'id_employee' => $id_employee)) ?>
</div>
<?php endif; ?>
<?php if($workflows2): ?>
<div id="liste" class="workflowlist workflowlist2">
    <?php include_partial('listTimeline', array('workflows' => $workflows2, 'workflow_title' => $workflow_title2)) ?>
</div>
<?php endif; ?>


