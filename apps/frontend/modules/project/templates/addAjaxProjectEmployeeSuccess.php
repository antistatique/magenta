<li>
  <label for="project_employee_employee_id">Employé</label>                               
  <select name="project[my_project_employee_list][<?php echo $new_number ?>][employee_id]" id="project_my_project_employee_list_new_employee_id">
    <option value="" selected="selected"></option>
    <?php foreach($employee_list as $employee): ?>
      <option value="<?php echo $employee->getId() ?>"><?php echo $employee ?></option>
    <?php endforeach;?>
  </select>                    
</li>

<li>
  <label for="project_employee_function_project_employee_id">Fonction</label>                               
  <select name="project[my_project_employee_list][<?php echo $new_number ?>][function_project_employee_id]" id="project_my_project_employee_list_new_function_project_employee_id">
    <option value="" selected="selected"></option>
    <?php foreach($function_project_employee_list as $function_project_employee): ?>
      <option value="<?php echo $function_project_employee->getId() ?>"><?php echo $function_project_employee ?></option>
    <?php endforeach;?>
  </select>
</li>
<li><br/></li>





