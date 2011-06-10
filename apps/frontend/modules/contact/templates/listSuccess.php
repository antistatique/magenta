<?php slot('page_title', 'Contact'); ?>

<div id="label">
  <?php include_component('contact', 'typeCompany') ?>
</div><!--end label-->
<div id="liste">
  <?php include_component('contact', 'list', array('auto_display_details' => true)) ?>
</div><!-- end liste-->
<div id="detail">
   <?php //include_partial('contact/detail') ?>
</div><!--end detail-->

