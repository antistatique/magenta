<div id="sousmenu">
  <ul>
     <li><a href="<?php echo url_for('@list_project?status=active')?>" class="sousmenuitem listermandat" id="list_project">Liste des mandats</a></li>
  </ul>
  <?php if($sf_user->hasCredential(array('can_project_modify', 'can_admin_project'), false)): ?>  
   <ul>
      <li><a href="<?php echo url_for('@add_project')?>" class="sousmenuitem ajoutermandat" id="add_project">Ajouter un mandat</a></li>
   </ul>
  <?php endif;?>
  
  <div id="searchformblock">          
     <form id="searchform" action="<?php echo url_for('@search_project'); ?>">
         <fieldset>
           
             <label for="query">Recherche</label>
             <input type="search" placeholder="Recherche..." autosave="bsn_srch" results="5" name="query" id="query" class="autosuggest" value="<?php echo $sf_params->has('query') ? $sf_params->get('query') : '' ?>" />
             <input type="submit" name="submitquery" id="submitquery" value="Go" /> 
         </fieldset>
     </form>
  </div><!--end searchformblock-->  
</div><!--end sousmenu-->