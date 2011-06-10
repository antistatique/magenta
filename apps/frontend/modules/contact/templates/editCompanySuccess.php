<?php slot('page_title', sprintf('Edition de l\'entreprise "%s"', $company->getName())); ?>

<div id="label">
  <?php include_component('contact', 'typeCompany') ?>
</div><!--end label-->
<div id="liste">
  <?php include_component('contact', 'list') ?>
</div><!-- end liste-->
<div id="detail">
<form action="<?php echo url_for('contact/updateCompany?id='.$company->getId()) ?>" method="post" id="editcompany">
   <div id="detailcontent">
        <div id="personphoto">
           <img src="/images/person_shade.jpg" width="48" height="48" alt="Person Shade" />
        </div>
        <div id="personinfo">
           <p class="persontext">&nbsp;</p>        
           <p class="persontitre">Modifier une entreprise</p>
           
             <ul>
               <?php include_partial('formCompany', array('form' => $form)) ?>                                                                                                                   
             </ul>

        </div>

   </div>

   <div id="detailmenu">
      <ul>
        <li><input type="submit" name="editcompany" value="Modifier" id="modifier" class="bt_submit bt_form"><li>        
         <li><a href="<?php echo url_for('@detail_company?id='.$company->getId());?>" class="detailmenuitem back">Retour</a></li>
         <?php if($sf_user->hasCredential('can_admin_contact')): ?>
         <li><?php echo link_to('Supprimer', '@delete_company?id='.$company->getId(), array('post' => true, 'confirm' => 'Êtes vous sûr de vouloir supprimer cet enregistrement ?', 'class' => 'detailmenuitem remove')); ?></li>
         <?php endif;?>
      </ul>          
   </div>   
 </form>   
</div>