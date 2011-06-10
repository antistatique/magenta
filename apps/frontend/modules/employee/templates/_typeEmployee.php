   <ul id="filtremenu">
      <li>
        <?php echo ($type_select=='all') ? '<strong>' : '' ;?>        
        <?php echo link_to('Tous'.'<i>'.$total_nb_employee.'</i>','employee/list?type=all', array('class' => 'type_all')) ?>
        <?php echo ($type_select=='all') ? '</strong>' : '' ;?>             
      </li>
      <?php foreach ($list as $function): ?>  
      <li>
        <?php printf(($type_select == $function['id']) ? '<strong>%s</strong>' : '%s',
          link_to($function['name'].'<i>'.$function['nb'].'</i>', 'employee/list?type='.$function['id'], array('class' => 'type_'.$function['id']))
        ) ?>
       </li>
     <?php endforeach;?>
   </ul>