<?php slot('page_title', 'Liste des collaborateurs'); ?>

<div id="label">
  <?php include_component('employee', 'typeEmployee') ?>
</div><!--end label-->
<div id="liste" class="liste2colo">
  <?php include_component('employee', 'list', array('auto_display_details' => true)) ?>
</div><!-- end liste-->
<div id="detail">
</div><!--end detail-->