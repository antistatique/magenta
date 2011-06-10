<?php slot('page_title', 'Importer une VCARD'); ?>

<div id="label">
  <?php include_component('contact', 'typeCompany') ?>
</div><!--end label-->
<div id="liste">
  <?php include_component('contact', 'list') ?>
</div><!-- end liste-->
<div id="detail">
   <form action="<?php echo url_for('contact/importVcard') ?>" method="post" id="importvcard" enctype="multipart/form-data">
   <div id="detailcontent">
        <div id="personphoto">
           <img src="/images/person_shade.jpg" width="48" height="48" alt="Person Shade" />
        </div>
        <div id="personinfo">
           <p class="persontext">&nbsp;</p>        
           <p class="persontitre">Importer via vCard</p>

              <ul>
                 <?php echo $form ?>
              </ul>

        </div>

   </div>

   <div id="detailmenu">
      <ul>
        <li><input type="submit" name="importvcard" value="Importer" id="importer" class="bt_submit bt_form"><li>                
         <li><a href="<?php echo url_for('@contact');?>" class="detailmenuitem back">Retour</a></li>
      </ul>
   </div>
 </form>   
</div>

