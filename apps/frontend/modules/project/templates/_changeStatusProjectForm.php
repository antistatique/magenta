<form id="action_quick_status_project_change" style="display:none" name="quick_status_project_change_form" action="<?php echo url_for('@change_status_project?project_id='.$project->getId()) ;?>" method="post" accept-charset="utf-8">
    
   <p>
    <select name="status_project_id" class="required_field" id="project_status_project_id">
        <?php foreach($statusProjectList as $status): ?>
            <?php printf('<option value="%s" %s>%s</option>', $status->getId(), ($project->getStatusProjectId() == $status->getId() ? 'selected="selected"' : ''), $status->getName()); ?>
        <?php endforeach; ?>
    </select>
    
    <input type="submit" value="ok"></p>
</form>