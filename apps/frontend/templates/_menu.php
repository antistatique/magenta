<div id="menu">
   <ul>
      <?php //if($sf_user->hasCredential('can_contact_view')): ?>  
       <li<?php echo $sf_context->getModuleName()=='dashboard' ? ' class="currentli"' : ''; ?>><a href="<?php echo url_for('@dashboard') ?>"><span class="menuitem dashboard"><?php echo __('Dashboard');?></span></a></li>
     <?php //endif;?> 
     <?php if($sf_user->hasCredential('can_contact_view')): ?>  
      <li<?php echo $sf_context->getModuleName()=='contact' ? ' class="currentli"' : ''; ?>><a href="<?php echo url_for('@contact?type=all&page=1') ?>"><span class="menuitem client"><?php echo __('Contact');?></span></a></li>
    <?php endif;?>
     <?php if($sf_user->hasCredential('can_project_view')): ?> 
      <li<?php echo $sf_context->getModuleName()=='project' ? ' class="currentli"' : ''; ?>><a href="<?php echo url_for('@list_project?status=active') ?>"><span class="menuitem mandat"><?php echo __('Mandats');?></span></a></li>
    <?php endif;?>
     <?php if($sf_user->hasCredential('icollab')): ?>       
      <li<?php echo $sf_context->getModuleName()=='employee' ? ' class="currentli"' : ''; ?>><a href="<?php echo url_for('@employee') ?>"><span class="menuitem collaborateur"><?php echo __('Collaborateurs');?></span></a></li>
    <?php endif;?>
      <?php
      /*<li<?php echo $sf_context->getModuleName()=='workflow' ? ' class="currentli"' : ''; ?>><a href="<?php echo url_for('@workflow') ?>"><span class="menuitem svn"><?php echo __('Workflow');?></span></a></li>*/
      ?>
     <?php if($sf_user->hasCredential('icollab')): ?>       
      <li<?php echo $sf_context->getModuleName()=='trac' ? ' class="currentli"' : ''; ?>><a href="<?php echo url_for('@trac') ?>" id="trac_menu_item"><span class="menuitem svn"><?php echo __('Trac');?></span></a></li>                 
    <?php endif;?>      
   </ul>
</div><!--end menu-->