<?php

/**
 * Company form.
 *
 * @package    Magenta
 * @subpackage form
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: sfPropelFormTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
class CompanyForm extends BaseCompanyForm
{
   
  public function configure()
  {     
    $this->widgetSchema->setLabels(array(
     'name'           => 'Raison sociale',
     'street'         => 'Rue',
     'street_number'  => 'N&deg;',
     'zipcode'        => 'NPA',
     'city'           => 'Ville',
     'country'        => 'Pays',
     'url'            => 'Site Internet',
     'tel'            => 'Téléphone',  
     'email'          => 'E-mail', 
     'employee_id'    => 'Contact client',      
     'type_company_id' => 'Type',
    ));     
    
    $this->widgetSchema['country'] = new sfWidgetFormI18nSelectCountry(array('culture'   => 'fr'));
    $this->setDefault('country','CH'); 
    
    unset($this->widgetSchema['project_company_list']);
        
    $this->widgetSchema->setFormFormatterName('list');
         
    $this->validatorSchema['email'] = new sfValidatorEmail(
      array('required' => false), 
      array('invalid'  => 'L\'email entré n\'est pas valide')
    );
    $this->validatorSchema['name'] = new sfValidatorString(
      array('required' => true),
      array('required'  => 'La raison sociale est obligatoire')
    );
    $this->validatorSchema['city'] = new sfValidatorString(
      array('required' => true),
      array('required'  => 'La ville est obligatoire')
    );   
       
    $this->validatorSchema['zipcode'] = new sfValidatorString(
      array('required' => true, 'min_length' => 4),
      array('invalid'  => 'Le npa n\'est pas valide', 'required'  => 'Le npa est obligatoire')      
    );
    
  $this->validatorSchema['employee_id'] = new sfValidatorString(
    array('required' => true),
    array('required'  => 'Le contact client est obligatoire')
  );
  $this->setDefault('employee_id',sfContext::getInstance()->getUser()->getEmployeeId());
  
  $this->validatorSchema['type_company_id'] = new sfValidatorString(
    array('required' => true),
    array('required'  => 'Le type est obligatoire')
  );
  $this->setDefault('type_company_id','client');    
    
  }
}
