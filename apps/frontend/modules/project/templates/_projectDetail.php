<?php echo use_helper('markdown'); ?>
<div id="detailcontent_p" class="detailcontent">
  <h2 class="titre"><?php echo $project->getTitle();?></h2>
  <span class="filtreitem<?php echo $project->getStatusProject()->getPosition();?> status_project_text"><?php echo $project->getStatusProject();?>&nbsp;|&nbsp;Mandat n° <?php echo $project->getNumber();?></span><br/>
  <?php foreach($project->getProjectCompanysJoinCompany() as $project_company):?>
    <a href="<?php echo url_for('@search_company?query='.$project_company->getCompany()->getName()) ?>" class="sous_titre_lien"><?php echo $project_company->getCompany(); ?></a>&nbsp;
  <?php endforeach;?>



   <ul>
     <li>
       <div class="markdownbloc">
        <?php echo Markdown($project->getDescription()); ?>
       </div>

          <dl>          
              <?php if($project->getTracLink()):?>
              <dt>Lien Trac</dt><dd><a href="<?php echo $project->getTracLink();?>">Accès au trac du projet</a></dd>            
              <?php endif; ?>
               <dt>Type de projet</dt><dd><?php echo $project->getRealTypeProject();?></dd>
          </dl>
      </li>
    </ul>

    <ul>
      <li>
       <h4>liste des collaborateurs du projet</h4>
      </li>
       <li>
           <dl>    
             <?php foreach($project->getProjectEmployeesJoinEmployee() as $project_employee):?>
                <dt><?php echo $project_employee->getFunctionProjectEmployee();?></dt>
                <dd><?php echo $project_employee->getEmployee();?></dd>
              <?php endforeach;?>
           </dl>
       </li>
     </ul>


 
  
</div>
<?php if($sf_user->hasCredential(array('can_project_modify', 'can_admin_project'), false)): ?>
<div id="detailmenu">
   <ul>
     <li><a href="<?php echo url_for('@edit_project?id='.$project->getId()) ;?>" class="detailmenuitem modifier" id="modifier_project">Modifier</a></li>
     <li><a href="<?php echo url_for('@add_workflow?project_id='.$project->getId()) ;?>" class="detailmenuitem ajoutertache" id="ajouter_workflow">Ajouter un événement</a></li>     
     <li>
         <?php include_component('project', 'changeStatusProjectForm', array('project' => $project)); ?>
         <a href="<?php echo url_for('@add_workflow?project_id='.$project->getId()) ;?>" class="detailmenuitem modifierstatus" id="modifier_projet_status">Modifier le status</a>
     </li>      
         
   </ul>          
</div>
<?php endif; ?>