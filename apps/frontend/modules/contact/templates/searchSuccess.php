<?php if(!$sf_request->isXmlHttpRequest()):?>
  <div id="label">
    <?php include_component('contact', 'typeCompany') ?>
  </div><!--end label-->
  <div id="liste">
<?php endif;?>
<?php include_component('contact', 'list', array('auto_display_details' => true)) ?>
<?php if(!$sf_request->isXmlHttpRequest()):?>
  </div><!-- end liste-->
  <div id="detail">
     <?php //include_partial('contact/detail') ?>
  </div><!--end detail-->
<?php endif;?>