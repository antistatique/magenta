<?php

/**
 * main actions.
 *
 * @package    Magenta
 * @subpackage main
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class mainActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
    $this->forward('default', 'module');
  }
  public function executeError404($request)
  {
    
    //die('sadasd');
    
  }
}
