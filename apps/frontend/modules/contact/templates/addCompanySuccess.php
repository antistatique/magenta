<?php slot('page_title', 'Ajouter une Entreprise'); ?>

<div id="label">
  <?php include_component('contact', 'typeCompany') ?>
</div><!--end label-->
<div id="liste">
  <?php include_component('contact', 'list') ?>
</div><!-- end liste-->
<div id="detail">
  <form action="<?php echo url_for('contact/updateCompany') ?>" method="post" id="editcompany">
   <div id="detailcontent">
        <div id="personphoto">
           <img src="/images/person_shade.jpg" width="48" height="48" alt="Person Shade" />
        </div>
        <div id="personinfo">
           <p class="persontext">&nbsp;</p>        
           <p class="persontitre">Ajouter une entreprise</p>
         
             <ul>
               <?php include_partial('formCompany', array('form' => $form)) ?>
             </ul>

        </div>

   </div>

   <div id="detailmenu">
      <ul>
        <li><input type="submit" name="editcompany" value="Ajouter" id="add" class="bt_submit bt_form"><li>        
         <li><a href="<?php echo url_for('@contact');?>" class="detailmenuitem back">Retour</a></li>   
      </ul>
   </div>
 </form>   
</div>