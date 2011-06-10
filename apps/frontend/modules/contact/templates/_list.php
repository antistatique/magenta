<?php echo use_helper('Javascript', 'magenta'); ?>
<?php if($load_company_id): ?>
   <?php // handle to display company projet and company details ?>
   <?php echo javascript_tag("jQuery(function(){
     displayCompanyDetails('".url_for('@detail_company?id='.$load_company_id)."');
     $('#contact_item_$load_company_id').attr('selected', true).children('.show_projects').slideDown('fast');
   })"); ?>
 <?php endif; ?>
<ul>
  <?php $companies = $pager->getResults();?>
  <?php $i=0; foreach ($companies as $company): $i++; ?>
   <li id="contact_item_<?php echo $company->getId() ?>" contact_id="<?php echo $company->getId() ?>" <?php echo ($selected_company_id == $company->getId()) ? 'selected="true"':'' ?> class="contact_item">
      <div class="liste1c <?php echo 'ico_type_'.$company->getTypeCompanyId() ;?>">
        <a href="<?php echo url_for('@detail_company?id='.$company->getId()) ; ?>" title="<?php echo $company->getName() ?>" class="titrenolink contact_item_link"  contact_id="<?php echo $company->getId() ?>">
          <?php echo coupe_str($company->getName(), 20); ?>
        </a>
        <br />
         <span class="listeitemarrow">
           <?php echo coupe_str($company->getEmployee(), 15) ?>
         </span>
         </div>
      <div class="liste2c">
         <?php echo coupe_str($company->getContact()->getName(), 15); ?>
         <br />
         <span class="listeitemfade">
          <?php echo coupe_str($company->getContact()->getFunctionName(), 15); ?>
         </span>                
      </div>
      <div class="liste3c">
         <a href="mailto:<?php echo ($company->getContact()->getEmail()) ? $company->getContact()->getEmail() : $company->getEmail() ; ?>" title="<?php echo ($company->getContact()->getEmail()) ? $company->getContact()->getEmail() : $company->getEmail() ; ?>"><?php echo coupe_str(($company->getContact()->getEmail()) ? $company->getContact()->getEmail() : $company->getEmail(),18) ; ?></a><br />
         <span class="listeitemfade"><?php echo $company->getContact()->getTel() ? $company->getContact()->getTel() : $company->getContact()->getMobile(); ?></span>
      </div>        

      <?php foreach ($company->getProjects() as $project): ?> 
      <!--au cas ou cliqué ouvre :-->           
      <div id="show_projects_<?php echo $company->getId() ?>" class="show_projects">
         <div class="listeopenc c1c"><a href="<?php echo url_for('@show_project?id='.$project->getId()); ?>" class="titrenolink"><?php echo coupe_str($project->getTitle(), 20); ?></a></div>
         <div class="listeopenc c2c"><?php echo coupe_str($project->getTypeProject(), 14); ?></div>
         <div class="listeopenc c3c"><span class="status_<?php echo $project->getStatusProject()->getPosition(); ?>"><?php echo coupe_str($project->getStatusProject(), 20); ?></span></div>     
      </div>      
      <!-- end : au cas ou cliqué ouvre :-->
      <?php endforeach;?>     
                 
   </li>                                 
 <?php endforeach;?>
 <li class="listefooter">
    <div class="liste1c nbmandat">
       <?php echo $pager->getNbResults() ?> Entreprise<?php echo $pager->getNbResults()<=1 ? '' :'s'; ?>
    </div>
    <div class="liste2cpages">
      <?php if ($pager->haveToPaginate()): ?>
        <ul>
        <li><?php echo link_to('<i>back</i>', 'contact/list?page='.$pager->getPreviousPage(), array('class' => 'prev')) ?></li>
        <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
          <li><?php echo ($page == $pager->getPage()) ? '<b>'.$page.'</b>' : link_to($page, 'contact/list?page='.$page) ?></li>
        <?php endforeach ?>
        <li><?php echo link_to('<i>next</i>', 'contact/list?page='.$pager->getNextPage(), array('class' => 'next')) ?></li>
        </ul>
      <?php endif ?>      
    </div>
    <div class="liste3c nbclient">
       <?php echo $pager->getFirstIndice() ?> - <?php echo $pager->getLastIndice() ?>.
    </div>
 </li>
</ul>