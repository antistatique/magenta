<?php slot('page_title', sprintf('Edition de la personne "%s"', $contact->getFullName())); ?>

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
           <p class="persontitre">Editer une personne</p>
           <form action="<?php echo url_for('contact/updateContact?id='.$contact->getId()) ?>" method="post" id="editcontact">
             <ul>
               <?php include_partial('formContact', array('form' => $form)) ?> 

             </ul>
           </form>
        </div>

   </div>

   <div id="detailmenu">
      <ul>
        <li><input type="submit" name="editcontact" value="Modifier" id="modifier" class="bt_submit bt_form"><li>        
         <li><a href="<?php echo url_for('@detail_company?id='.$contact->getCompanyId());?>" class="detailmenuitem back">Retour</a></li>         
         <?php if($sf_user->hasCredential('can_admin_contact')): ?>           
         <li><?php echo link_to('Supprimer', '@delete_contact?id='.$contact->getId(), array('post' => true, 'confirm' => 'Êtes vous sûr de vouloir supprimer cet enregistrement ?', 'class' => 'detailmenuitem remove')); ?></li>                   
         <?php endif; ?>
      </ul>          
   </div>   
</div>