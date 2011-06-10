<?php echo use_helper('Javascript', 'magenta'); ?>
<?php if($load_employee_id): ?>
   <?php echo javascript_tag("jQuery(function(){
     displayEmployeeDetails('".url_for('@detail_employee?id='.$load_employee_id)."');
   })"); ?>
 <?php endif; ?>

<ul>
  <?php $employees = $pager->getResults();?>
  <?php $i=0; foreach ($employees as $employee): $i++; ?>
   <li id="contact_item_<?php echo $employee->getId() ?>" contact_id="<?php echo $employee->getId() ?>" <?php echo ($selected_employee_id == $employee->getId()) ? 'selected="true"':'' ?> class="contact_item">
      <div class="liste1c <?php echo 'ico_type_'.$employee->getFunctionEmployeeId() ;?>">
        <a href="<?php echo url_for('@detail_employee?id='.$employee->getId()) ; ?>" title="<?php echo $employee->getName() ?>" class="titrenolink contact_item_link"  contact_id="<?php echo $employee->getId() ?>">
          <?php echo coupe_str($employee->getFirstName().' '.$employee->getName(), 20); ?>
        </a>
        <br />
         <span class="listeitemarrow">
           <?php echo coupe_str($employee->getFunctionEmployee()->getName(), 45) ?>
         </span>
         </div>
      <div class="liste2c">
          <a href="mailto:<?php echo coupe_str($employee->getEmail(), 45) ?>"><?php echo coupe_str($employee->getEmail(), 45) ?></a><br/>
        <span class="listeitemfade">
          <?php echo coupe_str($employee->getMobile(), 45) ?>
        </span>
      </div>

   </li>                                 
 <?php endforeach;?>
 
 <li class="listefooter">
    <div class="liste1c nbmandat">
       <?php echo $pager->getNbResults() ?> Employés
    </div>
    <div class="liste2cpages">
      <?php if ($pager->haveToPaginate()): ?>
        <ul>
        <li><?php echo link_to('<i>back</i>', 'employee/list?page='.$pager->getPreviousPage(), array('class' => 'prev')) ?></li>
        <?php $links = $pager->getLinks(); foreach ($links as $page): ?>
          <li><?php echo ($page == $pager->getPage()) ? '<b>'.$page.'</b>' : link_to($page, 'employee/list?page='.$page) ?></li>
        <?php endforeach ?>
        <li><?php echo link_to('<i>next</i>', 'employee/list?page='.$pager->getNextPage(), array('class' => 'next')) ?></li>
        </ul>
      <?php endif ?>      
    </div>
    <div class="liste3c nbclient">
       <?php echo $pager->getFirstIndice() ?> - <?php echo $pager->getLastIndice() ?>.
    </div>
 </li>
</ul>