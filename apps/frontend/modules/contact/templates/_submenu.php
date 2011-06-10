<div id="sousmenu">
  <?php if($sf_user->hasCredential(array('can_contact_modify', 'can_admin_contact'), false)): ?>  
   <ul>
      <li><a href="<?php echo url_for('@add_company')?>" class="sousmenuitem ajoutercompany" id="add_company">Ajouter une entreprise</a></li>
      <li><a href="<?php echo url_for('@add_contact')?>" class="sousmenuitem ajoutercontact" id="add_contact">Ajouter une personne</a></li>      
      <li><a href="<?php echo url_for('contact/importVcard') ?>" class="sousmenuitem importer">Importer VCard</a></li>
   </ul>
  <?php endif;?>
   <div id="searchformblock">          
      <form id="searchform" action="<?php echo url_for('@search_company'); ?>">
          <fieldset>
            
              <label for="query">Recherche</label>
              <input type="search" placeholder="Recherche..." autosave="bsn_srch" results="5" name="query" id="query" class="autosuggest" value="<?php echo $sf_params->has('query') ? $sf_params->get('query') : '' ?>" />
              <input type="submit" name="submitquery" id="submitquery" value="Go" /> 
          </fieldset>
      </form>
   </div><!--end searchformblock-->
</div><!--end sousmenu-->