<?php echo use_helper('Date', 'magenta'); ?>
<?php slot('page_title', "Trac"); ?>

<div id="label">

</div><!--end label-->
<div id="liste" class="large trac_list">

  <ul class="trac_highlight">
      <?php foreach ($trac_list as $trac): ?>
        <li id="trac_item_<?php echo $trac['name'] ?>" class="trac_item">
          <div class="liste1c ico_trac">
            <strong><?php echo $trac['name'] ?></strong>
          </div>
          <div class="liste2c">
              <a href="<?php echo $trac['link'] ?>"><?php echo coupe_str($trac['link'],70) ?></a>  
          </div>
          <div class="liste3c">
                          
          </div>
          <div class="liste4c">
            

          </div>


        </li>

      <?php endforeach; ?>      
      </ul>


      
      <ul>
      <li class="liste_titre"><h2>Trac des mandats actifs</h2></li>
      <?php foreach ($trac_project_list as $project): ?>
        <li id="trac_item_<?php echo $project->getId() ?>" class="trac_item">
          <div class="liste1c ico_trac">
            <strong><?php echo $project->getNumber() ?></strong>
            <a href="<?php echo url_for('@show_project?id='.$project->getId()) ?>" class="show_project"><?php echo coupe_str($project->getTitle(),22) ?></a>  
          </div>
          <div class="liste2c">
              <a href="<?php echo $project->getTracLink() ?>"><?php echo coupe_str($project->getTracLink(),70) ?></a>  
          </div>
          <div class="liste3c">

          </div>
          <div class="liste4c">
            <span class="status_<?php echo $project->getStatusProject()->getPosition(); ?>"><?php echo coupe_str($project->getStatusProject(), 20); ?></span><br/>

          </div>


        </li>

      <?php endforeach; ?>      
  </ul>
  
      <ul>
      <li class="liste_titre"><h2>Trac des mandats inactifs</h2></li>
      <?php foreach ($trac_project_list_unactive as $project): ?>
        <li id="trac_item_<?php echo $project->getId() ?>" class="trac_item">
          <div class="liste1c ico_trac">
            <strong><?php echo $project->getNumber() ?></strong>
            <a href="<?php echo url_for('@show_project?id='.$project->getId()) ?>" class="show_project"><?php echo coupe_str($project->getTitle(),22) ?></a>  
          </div>
          <div class="liste2c">
              <a href="<?php echo $project->getTracLink() ?>"><?php echo coupe_str($project->getTracLink(),70) ?></a>  
          </div>
          <div class="liste3c">

          </div>
          <div class="liste4c">
            <span class="status_<?php echo $project->getStatusProject()->getPosition(); ?>"><?php echo coupe_str($project->getStatusProject(), 20); ?></span><br/>

          </div>


        </li>

      <?php endforeach; ?>      
  </ul>
  
  
</div><!-- end liste-->