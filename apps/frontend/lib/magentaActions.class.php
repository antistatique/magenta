<?php

/**
 * Magenta base actions.
 *
 * @package    Magenta
 * @subpackage 
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class magentaActions extends sfActions
{
  /**
   * Display error/success/info message
   * Use two ways, persistent with flash session and non-persistent with request attribute variable.
   * @param string $message The message to display
   * @param string $type type of message to display [error|success|info]
   * @param boolean persistant display methode, default is true
   */
  public function displayMessage($message, $type, $persistent = true)
  {
    if($persistent)
    {
      $this->getUser()->setFlash('message', $message);
      $this->getUser()->setFlash('message_type', $type);
    }
    else
    {
      $this->getRequest()->setAttribute('message', $message);
      $this->getRequest()->setAttribute('message_type', $type);
    }
  }
}