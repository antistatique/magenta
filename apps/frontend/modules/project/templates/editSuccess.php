<?php slot('page_title', $form->getObject()->isNew() ? "Ajouter un mandat" : sprintf('Editer le mandat "%s"', $form->getObject()->getTitle())); ?>

<?php if(!$sf_request->isXmlHttpRequest()):?> 
<div id="label">
  <?php include_component('project', 'statusProject') ?>
</div><!--end label-->
<div id="detail" class="detailmandat">
<?php endif;?>
    <?php include_partial('editProject', array('form' => $form, 'company_selected' => $company_selected)) ?>
<?php if(!$sf_request->isXmlHttpRequest()):?>     
</div>
  <?php if(isset($workflow_list)):?>
    <div id="liste" class="workflowlist">
    <?php include_partial('workflow/list', array('workflow_list' => $workflow_list, 'project_id' => $form->getObject()->getId())) ?>
    </div>
  <?php endif;?>
<?php endif;?>
