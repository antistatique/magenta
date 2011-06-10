<?php echo use_helper('Date', 'magenta'); ?>
<ul>
    <li class="listeheader">
       <div class="liste1c">
           <h2>Mandat</h2>
       </div>
       <div class="liste2c">
           <h2>Client</h2>
       </div>
       <div class="liste3c">
           <h2>Dernier événement</h2>
       </div>
       <div class="liste4c">
           <h2>Status</h2>
       </div>       
    </li>
    <?php foreach ($pager->getResults() as $project): ?>
      <li id="mandat_item_<?php echo $project->getId() ?>" class="mandat_item">
        <div class="liste1c ico_mandat_st_<?php echo $project->getStatusProject()->getPosition(); ?>">
          <strong><?php echo $project->getNumber() ?></strong>
          <a href="<?php echo url_for('@show_project?id='.$project->getId()) ?>" class="show_project"><?php echo coupe_str($project->getTitle(),22) ?></a>  
          <br/>
          <?php echo $project->getRealTypeProject() ?>              
        </div>
        <div class="liste2c">
          <?php foreach($project->getProjectCompanysJoinCompany() as $project_company):?>
            <a href="<?php echo url_for('@search_company?query='.$project_company->getCompany()->getName()) ?>"><?php echo coupe_str($project_company->getCompany(), 30); ?></a>
          <?php endforeach;?>
          <br/>
          <span class="listeitemarrow">
             <?php echo $project->getProjectManager(); ?> 
          </span>

        </div>
        <div class="liste3c">
          <?php if($project->getProjectLastWorkflow()):?>
              <?php echo $project->getProjectLastWorkflow()->getTitle() ;?> (<?php echo $project->getProjectLastWorkflow()->getCategoryWorkflow()->getName() ;?>)
              <br/>
              <span class="listeitemarrow">
              <?php echo $project->getProjectLastWorkflow()->getEmployeeRelatedByManagerId() ;?> (<?php echo $project->getProjectLastWorkflow()->getUpdatedAt('d/m/Y') ;?>)
              </span>
          <?php endif;?>
        </div>
        <div class="liste4c">
          <span class="status_<?php echo $project->getStatusProject()->getPosition(); ?>"><?php echo coupe_str($project->getStatusProject(), 20); ?></span><br/>
          <?php echo format_date($project->getUpdatedAt(), 'dd/MM/yy HH:mm', 'fr') ?>  
        </div>
        

      </li>

    <?php endforeach; ?>
    <li class="listefooter">
       <div class="liste1c nbmandat">
          <?php echo $pager->getNbResults() ?> mandat<?php echo $pager->getNbResults()<=1 ? '' :'s'; ?>
       </div>
       <div class="liste2cpages">
         <?php if ($pager->haveToPaginate()): ?>
           <ul>
           <li><?php echo link_to('<i>back</i>', 'project/list?page='.$pager->getPreviousPage(), array('class' => 'prev')) ?></li>
           <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
             <li><?php echo ($page == $pager->getPage()) ? '<b>'.$page.'</b>' : link_to($page, 'project/list?page='.$page) ?></li>
           <?php endforeach ?>
           <li><?php echo link_to('<i>next</i>', 'project/list?page='.$pager->getNextPage(), array('class' => 'next')) ?></li>
           </ul>
         <?php endif ?>      
       </div>
       <div class="liste3c nbclient">
          <?php echo $pager->getFirstIndice() ?> - <?php echo $pager->getLastIndice() ?>.
       </div>
    </li>    
</ul>