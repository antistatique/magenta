<?php slot('page_title', sprintf('Recherche pour "%s"', $sf_params->get('query'))); ?>

<?php if(!$sf_request->isXmlHttpRequest()):?>
   <div id="label">
  <?php include_component('project', 'statusProject') ?>
</div><!--end label-->
<div id="liste" class="large">
<?php endif; ?>   
  <?php include_component('project', 'list') ?>
<?php if(!$sf_request->isXmlHttpRequest()):?>  
</div><!-- end liste-->
<?php endif; ?>