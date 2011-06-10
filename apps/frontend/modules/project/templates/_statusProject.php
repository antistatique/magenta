<ul id="filtremenu">
  
<?php

?>
  <li>
      <?php echo ($status_select=='active') ? '<strong>' : '' ;?>
     <?php echo link_to('Projets actifs'.'<i>'.$active_nb_project.'</i>','project/list?status=active', array('class' => 'filtreitemactive')) ?>
      <?php echo ($status_select=='active') ? '</strong>' : '' ;?> 
   </li>
  <li>
     <?php echo ($status_select=='all') ? '<strong>' : '' ;?>
     <?php echo link_to('Tous les projets'.'<i>'.$total_nb_project.'</i>','project/list?status=all', array('class' => 'filtreitem0')) ?>
     <?php echo ($status_select=='all') ? '</strong>' : '' ;?> 
   </li>


    <?php foreach ($statusProjectList as $statusProject): ?>  
    <li>
     <?php echo ($status_select==$statusProject['id']) ? '<strong>' : '' ;?>
     <?php echo link_to($statusProject['name'].'<i>'.$statusProject['nb'].'</i>', 'project/list?status='.$statusProject['id'], array('class' => 'filtreitem'.$statusProject['position']));?>
     <?php echo ($status_select==$statusProject['id']) ? '</strong>' : '' ;?>     
    </li>
    <?php endforeach;?>    
</ul>