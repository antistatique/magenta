<?php

/**
 * Contact form.
 *
 * @package    Magenta
 * @subpackage form
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: sfPropelFormTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
class ContactForm extends BaseContactForm
{
   protected static $title_list = array('Monsieur' => 'Monsieur', 'Madame' => 'Madame', 'Mademoiselle' => 'Mademoiselle');
  
   public function configure()
   {     
     $this->widgetSchema->setLabels(array(
      'title'          => 'Titre',
      'name'           => 'Nom',
      'firstname'      => 'Prénom',
      'function_name'  => 'Fonction',
      'email'          => 'E-mail', 
      'tel'            => 'Téléphone',
      'fax'            => 'Fax',
      'mobile'         => 'Téléphone portable',
      'url'            => 'Site Internet',
      'im'             => 'Messagerie instantanée',
      'address'        => 'Adresse',
      'zipcode'        => 'NPA',
      'city'           => 'Ville',
      'country'        => 'Pays',
      'company_id'     => 'Entreprise',
     ));     
     
     $this->widgetSchema['country'] = new sfWidgetFormI18nSelectCountry(array('culture'   => 'fr'));
     $this->setDefault('country','CH');     
     
     $this->widgetSchema['title'] = new sfWidgetFormSelect(
       array('choices' => self::$title_list)
     );
     
     $this->widgetSchema->setFormFormatterName('list');   
      
     $this->validatorSchema['title'] = new sfValidatorChoice(
       array('choices' => array_keys(self::$title_list))
     );  
    
     $this->validatorSchema['company_id'] = new sfValidatorString(
      array('required' => true),
      array('required'  => 'L\'entreprise est obligatoire')
     );

     $this->validatorSchema['email'] = new sfValidatorEmail(
      array('required' => false), 
      array('required' => 'L\'email est obligatoire', 'invalid'  => 'L\'email entré n\'est pas valide')
     );
     $this->validatorSchema['name'] = new sfValidatorString(
       array('required' => true),
       array('required'  => 'Le nom est obligatoire')
     );
     $this->validatorSchema['firstname'] = new sfValidatorString(
       array('required' => true),
       array('required'  => 'Le prénom est obligatoire')
     );     
   }
   

}



