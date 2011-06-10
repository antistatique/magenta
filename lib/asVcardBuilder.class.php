<?php
require dirname(__FILE__).'/Contact_Vcard_Build.php';

/**
 * Vcard parser parser class based on the Contact_Vcard_Parse PEAR class.
 *
 * @see Contact_Vcard_Build (PEAR)
 * @package net.antistatique.lib
 * @author Gilles Doge
 * @version SVN: $Id: asVcardBuilder.class.php 56 2008-11-04 16:51:03Z  $
 **/
class asVcardBuilder extends Contact_Vcard_Build
{
  protected $ABShowAsCompany = false;
  
  /**
   * This method can modify the way how Apple Address Book display the contact.
   * If true AAB will display the contact as a company.
   *
   * @param bool $val default true
   * @return void
   * @author Gilles Doge
   **/
  public function setABShowAsCompany($val = true)
  {
    $this->ABShowAsCompany = $val;
  }
  
  public function fetch()
  {
    $vcard = parent::fetch();
    
    if($this->ABShowAsCompany)
    {
      // TODO: Add the field 'X-ABShowAs:COMPANY'
    }
    
    return $vcard;
  }
  
  public function __toString()
  {
    return $this->fetch();
  }
}