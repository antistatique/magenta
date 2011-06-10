<?php slot('page_title', sprintf('Detail de %s', $employee->getName())); ?>

<?php if(!$sf_request->isXmlHttpRequest()):?>
  <div id="label">
    <?php include_component('employee', 'typeEmployee') ?>
  </div><!--end label-->
  <div id="liste" class="liste2colo">
<?php include_component('employee', 'list', array('auto_display_details' => false)) ?>
  </div><!-- end liste-->
  <div id="detail">
<?php endif;?>    
  <?php include_partial('employee/detail', array("employee" => $employee) ) ?>
<?php if(!$sf_request->isXmlHttpRequest()):?>    
  </div><!--end detail-->
<?php endif;?>