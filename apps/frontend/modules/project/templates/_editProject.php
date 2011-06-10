<?php $project = $form->getObject() ?>  
<form action="<?php echo url_for('project/edit'.(!$project->isNew() ? '?id='.$project->getId() : '')) ?>" method="post" id="edit_project">
<div id="detailcontent_p" class="detailcontent">

           <h2 class="titre"><?php echo $project->isNew() ? 'Ajouter' : 'Editer' ?> un mandat</h2>
             <?php echo $form->renderGlobalErrors(); ?>
             <?php if($project->isNew()&&!$company_selected):?>
             <p>L'entreprise doit exister pour lui affecter un mandat. <a href="<?php echo url_for('@add_company');?>">Ajouter une entreprise</a></p>
             <?php endif;?>
             <ul>
               
                <?php echo $form['number']->renderRow(array('class' => 'required_field')) ?>      

                <?php echo $form['title']->renderRow(array('class' => 'required_field')) ?>
                <?php echo $form['slug']->renderRow(array('class' => 'required_field')) ?>
                <li>
                <?php echo $form['description']->renderLabel() ?>
                </li>
                <li>
                <?php echo $form['description']->render(array('class' => 'markdownbloc_edit')) ?>
                </li>
                <li>

                  <br/>
                </li>
                <?php echo $form['type_project']->renderRow(array('class' => 'required_field')) ?>
                <?php echo $form['trac_link']->renderRow() ?>                
                <?php echo $form['status_project_id']->renderRow(array('class' => 'required_field')) ?>  
                <?php echo $form['project_company_list']->renderRow(array('class' => 'required_field')) ?>
                
                </ul>
                 <h4><?php echo $form['my_project_employee_list']->renderLabel() ?></h4>
                 <?php echo $form['my_project_employee_list']->renderError() ?>
                <ul class="project_employee_list">
                <?php foreach($form['my_project_employee_list'] as $field):?>
                    <li>
                              <?php echo $field['employee_id']->renderError(); ?>
                              <?php echo $field['employee_id']->renderLabel(); ?>
                              <?php echo $field['employee_id']->render(); ?>
                    </li>
                    <li>
                              <?php echo $field['function_project_employee_id']->renderError(); ?>
                              <?php echo $field['function_project_employee_id']->renderLabel(); ?>
                              <?php echo $field['function_project_employee_id']->render(); ?>
                       
                    </li>
                   <li><br/></li>
                  <?php endforeach;?>
                  
           </ul>
           
           <?php echo $form['id'] ?>

</div>

<div id="detailmenu">
<ul>
  <?php if (!$project->isNew()): ?>
    <li><input type="submit" name="edit_project" value="Modifier" id="modifier" class="bt_submit bt_form"><li>
    <li><a href="<?php echo url_for('@detail_project?id='.$project->getId());?>" class="detailmenuitem back" id="detail_project">Retour</a></li>
    <?php if($sf_user->hasCredential('can_admin_project')): ?>           
    <li><?php echo link_to('Supprimer', '@delete_project?id='.$project->getId(), array('post' => true, 'confirm' => 'Êtes vous sûr de vouloir supprimer cet enregistrement ?', 'class' => 'detailmenuitem remove')); ?></li>                   
    <?php endif; ?>
  <?php else:?>
    <li><input type="submit" name="edit_project" value="Ajouter" id="add" class="bt_submit bt_form"><li>    
    <li><a href="<?php echo url_for('@project');?>" class="detailmenuitem back">Retour</a></li>    
  <?php endif; ?>
  <li><a href="javascript:void(0);" class="detailmenuitem ajoutercontact" id="add_employee_project">Ajouter un collaborateur</a></li>
</ul>          
</div>
</form>