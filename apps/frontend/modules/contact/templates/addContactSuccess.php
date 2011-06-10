<?php slot('page_title', 'Ajouter une personne (contact)'); ?>

<div id="label">
  <?php include_component('contact', 'typeCompany') ?>
</div><!--end label-->
<div id="liste">
  <?php include_component('contact', 'list') ?>
</div><!-- end liste-->
<div id="detail">
   <div id="detailcontent">
        <div id="personphoto">
           <img src="/images/person_shade.jpg" width="48" height="48" alt="Person Shade" />
        </div>
        <div id="personinfo">
           <p class="persontext">&nbsp;</p>        
           <p class="persontitre">Ajouter une personne</p>
           <form action="<?php echo url_for('contact/updateContact') ?>" method="post" id="editcontact">
             <ul>
               <?php include_partial('formContact', array('form' => $form)) ?>
             </ul>
           </form>
        </div>
   </div>
   <div id="detailmenu">
      <ul>
        <li><input type="submit" name="editcontact" value="Ajouter" id="add" class="bt_submit bt_form"><li>
        <li><a href="<?php echo url_for('@detail_company?id='.$sf_request->getParameter('company'));?>" class="detailmenuitem back">Retour</a></li>                                     
      </ul>          
   </div>   
</div>