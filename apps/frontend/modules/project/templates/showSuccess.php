<?php slot('page_title', sprintf('Mandat n°%s %s', $project->getNumber(), $project->getTitle())); ?>

<div id="label">
  <?php include_component('project', 'statusProject') ?>
</div><!--end label-->
<div id="detail" class="detailmandat">
    <?php include_partial('projectDetail', array('project' => $project)) ?>
</div>
<div id="liste" class="workflowlist">
    <?php include_partial('workflow/list', array('workflow_list' => $workflow_list, 'project_id' => $project->getId())) ?>
</div>