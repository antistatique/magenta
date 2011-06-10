<div id="sousmenu">
  <?php if($sf_user->hasCredential(array('can_contact_modify', 'can_admin_contact'), false)): ?>  
   <ul>
      <!-- <li><a href="<?php echo url_for('employee/add')?>" class="sousmenuitem ajoutercontact" id="add_contact">Ajouter un collaborateur</a></li>       -->
   </ul>
  <?php endif;?>
</div><!--end sousmenu-->