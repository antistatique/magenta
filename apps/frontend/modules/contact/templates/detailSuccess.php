<?php slot('page_title', sprintf('Contact de %s', $company->getName())); ?>

<?php if(!$sf_request->isXmlHttpRequest()):?>
  <div id="label">
    <?php include_component('contact', 'typeCompany') ?>
  </div><!--end label-->
  <div id="liste">
<?php include_component('contact', 'list', array('auto_display_details' => false)) ?>
  </div><!-- end liste-->
  <div id="detail">
<?php endif;?>    
  <?php include_partial('contact/detail', array("company" => $company) ) ?>
<?php if(!$sf_request->isXmlHttpRequest()):?>    
  </div><!--end detail-->
<?php endif;?>  