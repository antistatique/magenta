   <ul id="filtremenu">
      <li>
        <?php echo ($type_select=='all') ? '<strong>' : '' ;?>        
        <?php echo link_to('Tous les contacts'.'<i>'.$total_nb_company.'</i>','contact/list?type=all', array('class' => 'type_all')) ?>
        <?php echo ($type_select=='all') ? '</strong>' : '' ;?>             
      </li>
      <?php foreach ($typeCompanyList as $typeCompany): ?>  
      <li>
        <?php echo ($type_select==$typeCompany['id']) ? '<strong>' : '' ;?>        
        <?php echo link_to($typeCompany['name'].'<i>'.$typeCompany['nb'].'</i>', 'contact/list?type='.$typeCompany['id'], array('class' => 'type_'.$typeCompany['id']));?>
        <?php echo ($type_select==$typeCompany['id']) ? '</strong>' : '' ;?>            
      </li>
     <?php endforeach;?>
   </ul>