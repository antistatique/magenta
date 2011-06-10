<?php


/**
 * Skeleton subclass for representing a row from the 'company' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Company extends BaseCompany {

  /**
   * Initializes internal state of Company object.
   * @see        parent::__construct()
   */
  public function __construct()
  {
    // Make sure that parent constructor is always invoked, since that
    // is where any default values for this object are set.
    parent::__construct();
  }
  
  public function getProjects($c = null) {
     $projects = array();
     foreach($this->getProjectCompanysJoinProject($c) as $ref) {
        $projects[] = $ref->getProject();
     }
     return $projects;
  } 
  
  public function getProjectManager()
  {
    /**
     * @todo implement method that take the lower process project, retrieve the project manager for the project.
     */
    return null;
  }
  
  public function __toString(){
    return $this->getName();
  } 
  
  /**
   * Return the street + street number
   *
   * @return string full street address
   **/
  public function getFullStreet()
  {
    $street = $this->getStreet();
    if($this->getStreetNumber())
    {
      $street .= ' '.$this->getStreetNumber();
    }

    return $street;
  }
  
  public function getContact(){
    /**
     * @todo 
     */
    $contacts = $this->getContacts();
    if($contacts){
      return $contacts[0];      
    }else{
      return new Contact();
    }
    

  }

} // Company
