
<ul id="trac_sub_menu">
        <li><a href="<?php echo url_for('@trac') ?>" class="sousmenuitem tracicone">Tous les tracs</a></li>
     <?php foreach ($trac_list as $trac): ?>
        <li><a href="<?php echo $trac['link'] ?>" class="sousmenuitem tracicone"><?php echo $trac['name'] ?></a></li>
      <?php endforeach; ?>
   </ul>

