<?php

/**
 * contact actions.
 *
 * @package    Magenta
 * @subpackage Contact
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class contactActions extends magentaActions
{
  
 /**
  * Executes index action
  * Forward to the list action
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
    $this->forward('contact', 'list');
  }
  
  /**
   * Executes list action
   * Refer to components.class.php, the list action components hold all the logic for listing companies
   * @param sfRequest $request A request object
   */  
  public function executeList($request)
  {
    // refer to the components.class.php :-)

  }
  
  /**
   * Executes detail action
   * Display the details of a given company
   * @param sfRequest $request A request object
   * @param out Company $company the company to display
   * @todo Secure this function according to the credential
   */  
  public function executeDetail($request)
  {
    
    $criteria_company = new Criteria();
    MagentaAccessRestrictions::applyFilterSecurity($criteria_company);
    
    // $id = $this->getRequestParameter('id', 0);
    $criteria_company->add(CompanyPeer::ID, $this->getRequestParameter('id', 0));
    $this->company = CompanyPeer::doSelectOne($criteria_company);

    // $this->company = CompanyPeer::retrieveByPk($id);
      
    //envoi du 404 si l'objet est null
    //$this->forward404Unless($this->company);
    
  }
  
  /**
   * Executes Search action
   * Refer to components.class.php, the list action components hold all the logic for listing companies
   * @param sfRequest $request A request object
   */  
  public function executeSearch($request)
  {

  }

  /**
   * Executes addCompany action
   * Display the form to add a new company
   * @param sfRequest $request A request object
   * @param out CompanyForm $form the form to add a company
   */
  public function executeAddCompany($request)
  {
    $this->form = new CompanyForm();
  }

  /**
   * Executes editCompany action
   * Display the form to edit a given company
   * @param sfRequest $request A request object
   * @param out Company $company the company to edit
   * @param out CompanyForm $form the form to edit the given company
   */  
  public function executeEditCompany($request)
  {
    
    $this->company = CompanyPeer::retrieveByPk($request->getParameter('id'));
    $this->form = new CompanyForm($this->company);
 
  }
  
  /**
   * Executes updateCompany action
   * Update or Insert the company in the database. Display the form again if there is mistakes or redirect to the list and display the company's details
   * @param sfRequest $request A request object
   * @param out CompanyForm $form the form to add/edit a company if a requiered field was unpropered filled
   */  
  public function executeUpdateCompany($request)
  {
    $this->forward404Unless($request->isMethod('post'));
    
    $this->company = CompanyPeer::retrieveByPk($request->getParameter('id'));

    
    $this->form = new CompanyForm($this->company); 
    $this->form->bind($request->getParameter('company'));
    if ($this->form->isValid())
    {
      $company = $this->form->save();
      // todo: message confirmation
      $this->displayMessage('L&#x27;enregistrement a été effectué avec succès !', 'success');      
      $this->redirect('contact/list?id='.$company->getId());
    }
    else
    { 
      $this->displayMessage('Merci de renseigner les champs obligatoire !', 'error', false);
    }
    
    // load the good template in cas of error to the right form    
    if($this->company === null){
      $this->setTemplate('addCompany');
    }else{
      $this->setTemplate('editCompany');
    }    
    
    

    
  }
  
  /**
   * Executes deleteCompany action
   * Delete the company from the database. Redirect to the list
   * @param sfRequest $request A request object
   */  
  public function executeDeleteCompany($request)
  {
    $this->forward404Unless($company = CompanyPeer::retrieveByPk($request->getParameter('id')));

    //test if company has some interaction with projects if project_company table contain this company
    if(count($company->getProjectCompanys())!=0){
      
       $this->form = new CompanyForm($company); 
       $this->company = $company;
       
       $this->displayMessage('L\'entreprise possède un projet, impossible de la supprimer !', 'error', false);
      
       $this->setTemplate('editCompany');
      
    }elseif(count($company->getContacts())!=0){
        
        $this->form = new CompanyForm($company); 
        $this->company = $company;

        $this->displayMessage('L\'entreprise possède une personne, impossible de supprimer l\'entreprise !', 'error', false);

        $this->setTemplate('editCompany');        
        
    }else{

      $company->delete();
      // todo: message confirmation
      $this->displayMessage('L&#x27;enregistrement a été effacé avec succès !', 'success');
    
      $this->redirect('contact/list');
    }
  }
  
  /**
   * Executes addContact action
   * Display the form to add a new contact for a given company
   * @param sfRequest $request A request object
   * @param out ContactForm $form the form to add a contact
   */  
  public function executeAddContact($request)
  {
   $this->form = new ContactForm();
   if($request->getParameter('company')){
      $this->form->setDefault('company_id', $request->getParameter('company'));
   }
  }
  
  /**
   * Executes editContact action
   * Display the form to edit a given contact
   * @param sfRequest $request A request object
   * @param out Contact $contact the contact to edit
   * @param out ContactForm $form the form to edit the given contact
   */  
  public function executeEditContact($request)
  {
    $this->contact = ContactPeer::retrieveByPk($request->getParameter('id')); // FIXME: Pas besoin de passer l'objet au template, il est déja accessible via $form->getObject()
    $this->form = new ContactForm($this->contact);
  }
  
  /**
   * Executes exportAllContact action
   * Export all contact with e-mail for newsletters
   * @param sfRequest $request A request object
   * @param out companys $companys all the companies
   */  
  public function executeExportAllContact($request)
  {
     $this->companys = CompanyPeer::doSelect(new Criteria());
  }  
  
  /**
   * Executes updateContact action
   * Update or Insert the contact in the database. Display the form again if there is mistakes or redirect to the list and display the contact's company's details
   * @param sfRequest $request A request object
   * @param out ContactForm $form the form to add/edit a contact if a requiered field was unpropered filled
   */  
  public function executeUpdateContact($request)
  {
    $this->forward404Unless($request->isMethod('post'));
    
    $this->contact = ContactPeer::retrieveByPk($request->getParameter('id'));    
    
    $this->form = new ContactForm($this->contact); 
    $this->form->bind($request->getParameter('contact'));
    if ($this->form->isValid())
    {
      $contact = $this->form->save();
      // todo: message confirmation
      $this->displayMessage('L&#x27;enregistrement a été effectué avec succès !', 'success');
      $this->redirect('contact/list?id='.$contact->getCompanyId());
    }
    else
    { 
      $this->displayMessage('Merci de renseigner les champs obligatoire !', 'error', false);
    }
    
    
    // load the good template in cas of error to the right form
    if($this->contact === null){
      $this->setTemplate('addContact');
    }else{
      $this->setTemplate('editContact');
    }

  }
  
  /**
   * Executes deleteContact action
   * Delete the contact from the database. Redirect to the list
   * @param sfRequest $request A request object
   */  
  public function executeDeleteContact($request)
  {
    $this->forward404Unless($contact = ContactPeer::retrieveByPk($request->getParameter('id')));
    
    //test if contact has some interaction with projects if project_company table contain this contact
    if(count($contact->getProjectCompanys())!=0){
      
       $this->form = new ContactForm($contact); 
       $this->contact = $contact;
       
       $this->displayMessage('Le contact est acteur dans un projet, impossible de le supprimer !', 'error', false);
      
       $this->setTemplate('editContact');
      
    }else{
      
      $contact->delete();
      // todo: message confirmation
      $this->displayMessage('L&#x27;enregistrement a été effacé avec succès !', 'success');

      $this->redirect('contact/list');
      
    }

    
    
  }  
  
  
  /**
   * Import a contact from a VCARD
   * @param sfRequest $request A request object
   * @param out $form VcardForm or ContactForm
   * @return void
   **/
  public function executeImportVcard($request)
  {
    $this->form = new VcardForm();
    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('vcard'), $request->getFiles('vcard'));
      if($this->form->isValid())
      {
        // get the validated vcard
        $validatedFile = $this->form->getValue('vcard');
        $vcardFile     = $validatedFile->getTempName();

        // parse the vcard information
        // TODO: inject this code in a custom ValidatorVcardFile
        $parser    = new asVcardParser();
        $cardInfos = $parser->fromFile($vcardFile);
        if(!$cardInfos || !count($cardInfos))
        {
          // Impossible de lire la vcard
          $this->displayMessage("Impossible d'importer la VCARD !", 'error');
          return $this->redirect('contact/importVcard');
        }
        
        // DEBUG
        // echo '<pre>'; print_r($cardInfos[0]); echo '</pre>';
        
        // Fill Contact object with Vcard information
        // Note: a vcard can contain multiple contacts, get the first.
        $this->contact = new Contact();
        $this->contact->fromVcard($cardInfos[0]);
        
        // Create the contact form and display it.
        $this->form = new ContactForm($this->contact);
        $this->setTemplate('addContact');
      }
    }
  }
  
  /**
   * Export the company VCard
   *
   * @param out $output the vcard string
   * @param out $company Company
   * @author Gilles Doge
   **/
  public function executeExportVcardCompany($request)
  {
    $id = $request->getParameter('id'); // company_id
    $company = CompanyPeer::retrieveByPk($id);
    $this->forward404Unless($company);
    
    $contacts = $company->getContacts();
    $ouput    = ''; // Vcard as string
    
    if(empty($contacts))
    {
      // Build a company vcard
      throw new Exception("Vcard for company with no contact is not implemented.");
    }
    else
    {
      $vcards = array();
      // Build VCard for each person of the company
      foreach($contacts as $contact)
      {
        $vcard = new asVcardBuilder();
        $vcard->addOrganization($company->getName());
        
        // Name
        $vcard->setFormattedName($contact->getFirstname() .' '. $contact->getName());
        $vcard->setName($contact->getName(), $contact->getFirstname(), '', $contact->getFunctionName(), '');
        
        // Company address
        $vcard->addAddress('', '', $company->getFullStreet(), $company->getCity(), '', $company->getZipcode(), $company->getCountry());
        $vcard->addParam('TYPE', 'WORK');
        
        // Personal address?
        if($contact->getZipcode() && $contact->getCity())
        {
          $vcard->addAddress('', '', $contact->getAddress(), $contact->getCity(), '', $contact->getZipcode(), $contact->getCountry());
          $vcard->addParam('TYPE', 'HOME');
        }
        
        // Phones numbers
        if($company->getTel())
        {
          $vcard->addTelephone($company->getTel());
          $vcard->addParam('TYPE', 'WORK');
        }
        if($contact->getTel())
        {
          $vcard->addTelephone($company->getTel());
          $vcard->addParam('TYPE', 'HOME');
        }
        if($contact->getMobile())
        {
          $vcard->addTelephone($contact->getMobile());
          $vcard->addParam('TYPE', 'CELL');
        }
        
        // Emails
        $vcard->addEmail($contact->getEmail());
        $vcard->addParam('TYPE', 'WORK');
        $vcard->addParam('TYPE', 'PREF');
        
        $vcard->addEmail($company->getEmail());
        $vcard->addParam('TYPE', 'WORK');
        
        // URLs
        if($company->getUrl())
        {
          $vcard->setURL($company->getUrl());
          $vcard->addParam('TYPE', 'WORK');
          $vcard->addParam('TYPE', 'PREF');
        }
        if($contact->getUrl())
        {
          $vcard->setUrl($contact->getUrl());
          $vcard->addParam('TYPE', 'HOME');
        }
        
        // Special field for Apple Address book for display contact as a company
        $vcard->setABShowAsCompany(true);
        
        $vcards[] = $vcard;
      }
      
      // Fetch and append VCards
      $output = implode("", $vcards);
    }
    
    $this->setTemplate('vcard');
    $this->company = $company;
    $this->output = $output;
  }
}
