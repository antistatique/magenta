<?php

/**
 * trac component.
 *
 * @package    Magenta
 * @subpackage trac
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: components.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class tracComponents extends sfComponents
{
  
  public function executeSubmenu()
  {
      $this->trac_list = sfConfig::get('app_trac_list');    
  }
}