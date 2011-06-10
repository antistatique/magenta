<div id="detailcontent" company_id="<?php echo $employee->getId();?>">
   <div id="personphoto">
      <img src="/images/person_shade.jpg" width="48" height="48" alt="Person Shade" />
   </div>
   <div id="personinfo">
      <p class="persontext"><?php echo $employee->getFunctionEmployee()->getName();?></p>
      <p class="persontitre"><?php echo $employee; ?></p>
      <ul>
         <li>
             <dl>    
                <?php if($employee->getAddress()):?>                
                  <dt>Rue</dt><dd><?php echo $employee->getAddress();?></dd>
                <?php endif;?>
                <?php if($employee->getZipcode()&&$employee->getCity()):?>                
                  <dt>Ville</dt><dd><?php echo $employee->getZipcode();?> <?php echo $employee->getCity();?></dd>
                <?php endif;?>                   
                <?php if($employee->getCountry()):?>                
                  <dt>Pays</dt><dd><?php echo $employee->getCountry();?> <img src="/images/flags/<?php echo strtolower($employee->getCountry());?>.png" alt="<?php echo $employee->getCountry();?>"></dd>
                <?php endif;?>                   
             </dl>
         </li>
         <li>
            <dl>    
               <?php if($employee->getEmail()):?>                
                 <dt>Email</dt><dd><a href="mailto:<?php echo $employee->getEmail();?>"><?php echo $employee->getEmail();?></a></dd>
               <?php endif;?>
               <?php if($employee->getUrl()):?>                
                 <dt>Site</dt><dd><a href="<?php echo $employee->getUrl();?>" target="_blank"><?php echo $employee->getUrl();?></a></dd>
               <?php endif;?>
               <?php if($employee->getTel()):?>                
                 <dt>Tél.</dt><dd><span class="largeTypeAction"><?php echo $employee->getTel();?></span></dd>
               <?php endif;?>      
               <?php if($employee->getMobile()):?>                
                 <dt>Mobile</dt><dd><span class="largeTypeAction"><?php echo $employee->getMobile();?></span></dd>
               <?php endif;?>
               <?php if($employee->getIm()):?>                
                 <dt>IM</dt><dd><?php echo $employee->getIm();?></dd>
               <?php endif;?>
            </dl>
         </li>          
      </ul>      

   </div>
               
</div>
<div id="detailmenu">
   <ul>
     <?php if($sf_user->hasCredential(array('can_employee_modify', 'can_admin_employee'), false)): ?>
      <li><a href="<?php //echo url_for('@edit_company?id='.$company->getId()) ?>" class="detailmenuitem modifier">Modifier</a></li>
     <?php endif;?>
     
   </ul>          
</div>