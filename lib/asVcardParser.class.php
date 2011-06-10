<?php
require dirname(__FILE__).'/Contact_Vcard_Parse.php';

/**
 * Vcard parser parser class based on the Contact_Vcard_Parse PEAR class.
 *
 * @see Contact_Vcard_Parse (PEAR)
 * @package net.antistatique.lib
 * @author Gilles Doge
 * @version SVN: $Id: asVcardParser.class.php 50 2008-11-03 10:52:45Z  $
 **/
class asVcardParser extends Contact_Vcard_Parse
{
  // TODO: add special instruction to parse ADR field exported by Apple Address Book.
}