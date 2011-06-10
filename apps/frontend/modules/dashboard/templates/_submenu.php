<div id="sousmenu">
<ul>
  <?php if($sf_user->hasCredential(array('can_contact_modify', 'can_admin_contact'), false)): ?>  

      <li><a href="<?php echo url_for('@add_company')?>" class="sousmenuitem ajoutercompany" id="add_company">Ajouter une entreprise</a></li>
      <li><a href="<?php echo url_for('@add_contact')?>" class="sousmenuitem ajoutercontact" id="add_contact">Ajouter une personne</a></li>      

  <?php endif;?>
  <?php if($sf_user->hasCredential(array('can_project_modify', 'can_admin_project'), false)): ?>  
      <li><a href="<?php echo url_for('@add_project')?>" class="sousmenuitem ajoutermandat" id="add_project">Ajouter un mandat</a></li>

  <?php endif;?>  
  </ul>
  <div id="searchformblock">          
     <form id="searchform" action="<?php echo url_for('@search'); ?>">
         <fieldset>
             <label for="query">Recherche</label>
             <input type="search" placeholder="Recherche..." autosave="bsn_srch" results="5" name="query" id="query" value="<?php echo $sf_params->has('query') ? $sf_params->get('query') : '' ?>" />
             <input type="submit" name="submitquery" id="submitquery" value="Go" /> 
         </fieldset>
     </form>
  </div><!--end searchformblock-->
</div>