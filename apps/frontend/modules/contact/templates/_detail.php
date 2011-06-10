   <div id="detailcontent" company_id="<?php echo $company->getId();?>">
      <div id="personphoto">
         <img src="/images/person_shade.jpg" width="48" height="48" alt="Person Shade" />
      </div>
      <div id="personinfo">
         <p class="persontext"><?php echo $company->getTypeCompany()->getName(); ?> n°<?php echo $company->getId();?></p>
         <p class="persontitre"><?php echo $company->getName();?></p>
         <?php foreach($company->getContacts() as $contact):?>
         <p class="persontext"><a href="#contact_<?php echo $contact->getId(); ?>" title="<?php echo $contact->getTitle()." ".$contact->getFirstname()." ".$contact->getName(); ?>"><?php echo $contact->getTitle()." ".$contact->getFirstname()." ".$contact->getName(); ?></a> <?php echo $contact->getFunctionName() ? '('.$contact->getFunctionName().')': '' ;?></p>
         <?php endforeach;?>
         <ul>
            <li>
                <dl>    
                   <?php if($company->getStreet()):?>                
                     <dt>Rue</dt><dd><?php echo $company->getStreet();?> <?php echo $company->getStreetNumber();?><!--prévoir une deuxième ligne d'adresse --></dd>
                   <?php endif;?>
                   <?php if($company->getZipcode()&&$company->getCity()):?>                
                     <dt>Ville</dt><dd><?php echo $company->getZipcode();?> <?php echo $company->getCity();?></dd>
                   <?php endif;?>                   
                   <?php if($company->getCountry()):?>                
                     <dt>Pays</dt><dd><?php echo $company->getCountry();?> <img src="/images/flags/<?php echo strtolower($company->getCountry());?>.png" alt="<?php echo $company->getCountry();?>"></dd>
                   <?php endif;?>                   
                </dl>
            </li>
            <li>
               <dl>    
                  <?php if($company->getEmail()):?>                
                    <dt>Email</dt><dd><a href="mailto:<?php echo $company->getEmail();?>"><?php echo $company->getEmail();?></a></dd>
                  <?php endif;?>
                  <?php if($company->getUrl()):?>                
                    <dt>Site</dt><dd><a href="<?php echo $company->getUrl();?>" target="_blank"><?php echo $company->getUrl();?></a></dd>
                  <?php endif;?>
                  <?php if($company->getTel()):?>                
                    <dt>Tél.</dt><dd><span class="largeTypeAction"><?php echo $company->getTel();?></span></dd>
                  <?php endif;?>      
               </dl>
            </li>          
         </ul>
         
         
         <?php foreach($company->getContacts() as $contact):?>
           
           
           <ul>
             <li>
              <h4><a name="contact_<?php echo $contact->getId(); ?>"></a>
              <?php if($sf_user->hasCredential(array('can_contact_modify', 'can_admin_contact'), false)): ?>
                <a href="<?php echo url_for('@edit_contact?id='.$contact->getId())?>">
              <?php endif;?>
                <?php echo $contact->getTitle()." ".$contact->getFirstname()." ".$contact->getName(); ?>
                <?php echo $contact->getFunctionName() ? '('.$contact->getFunctionName().')': '' ;?>
              <?php if($sf_user->hasCredential(array('can_contact_modify', 'can_admin_contact'), false)): ?>
                </a>
              <?php endif;?>
              </h4>
             </li>
              <li>
                  <dl>    
                     <?php if($contact->getAddress()):?>                
                       <dt>Rue</dt><dd><?php echo $contact->getAddress();?></dd>
                     <?php endif;?>
                     <?php if($contact->getZipcode()&&$contact->getCity()):?>                
                       <dt>Ville</dt><dd><?php echo $contact->getZipcode();?> <?php echo $contact->getCity();?></dd>
                     <?php endif;?>                   
                     <?php if($contact->getCountry()):?>                
                       <dt>Pays</dt><dd><?php echo $contact->getCountry();?> <img src="/images/flags/<?php echo strtolower($contact->getCountry());?>.png" alt="<?php echo $contact->getCountry();?>"></dd>
                     <?php endif;?>                   
                  </dl>
              </li>
              <li>
                 <dl>    
                    <?php if($contact->getEmail()):?>                
                      <dt>Email</dt><dd><a href="mailto:<?php echo $contact->getEmail();?>"><?php echo $contact->getEmail();?></a></dd>
                    <?php endif;?>
                    <?php if($contact->getUrl()):?>                
                      <dt>Site</dt><dd><a href="<?php echo $company->getUrl();?>" target="_blank"><?php echo $contact->getUrl();?></a></dd>
                    <?php endif;?>
                    <?php if($contact->getTel()):?>                
                      <dt>Tél.</dt><dd><span class="largeTypeAction"><?php echo $contact->getTel();?></span></dd>
                    <?php endif;?> 
                    <?php if($contact->getFax()):?>                
                      <dt>Fax</dt><dd><span class="largeTypeAction"><?php echo $contact->getFax();?></span></dd>
                    <?php endif;?>
                    <?php if($contact->getMobile()):?>                
                      <dt>Mobile</dt><dd><span class="largeTypeAction"><?php echo $contact->getMobile();?></span></dd>
                    <?php endif;?>     
                    <?php if($contact->getIm()):?>                
                      <dt>Im</dt><dd><?php echo $contact->getIm();?></dd>
                    <?php endif;?>                                        
                 </dl>
              </li>
              <li>
                 <dl>
                    <?php if($contact->getComment()):?>
                      <dt>Remarque</dt><dd><?php echo nl2br($contact->getComment());?></dd>
                    <?php endif;?>
                 </dl>
              </li>
           </ul>           
           
           
         <?php endforeach;?>
         

      </div>
                  
   </div>
   <div id="detailmenu">
      <ul>
        <?php if($sf_user->hasCredential(array('can_contact_modify', 'can_admin_contact'), false)): ?>
         <li><a href="<?php echo url_for('@edit_company?id='.$company->getId()) ?>" class="detailmenuitem modifier">Modifier</a></li>
         <li><a href="<?php echo url_for('@add_contact?company='.$company->getId())?>" class="detailmenuitem ajoutercontact" id="add_contact">Ajouter une personne</a></li>
        <?php endif;?>
        <?php if($sf_user->hasCredential(array('can_project_modify', 'can_admin_project'), false)): ?>
         <li><a href="<?php echo url_for('@add_project?company='.$company->getId())?>" class="detailmenuitem ajoutermandat" id="add_mandat">Mandat</a></li>
        <?php endif;?>
        <li><a href="<?php echo url_for('contact/exportVcardCompany?id='.$company->getId()) ?>" class="detailmenuitem exportvcard">VCard</a></li>
      </ul>          
   </div>