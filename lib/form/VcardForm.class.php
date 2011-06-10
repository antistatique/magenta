<?php
/**
 * Vcard importer form.
 *
 * @package    Magenta
 * @subpackage form
 * @author     Marc Friederich <marc@antistatique.net>
 * @version    SVN: $Id: VcardForm.class.php 236 2010-06-11 16:47:08Z gde $
 */
class VcardForm extends BaseForm
{
   public function configure() {
            
      $this->setWidgets(array(
         'vcard' => new sfWidgetFormInputFile()
      ));
      
      $this->setValidators(array(
         'vcard' => new sfValidatorFile(array('required' => true))
      ));

      $this->widgetSchema->setLabels(array(
        'vcard' => 'Fichier vCard',  
      ));
      
      $this->widgetSchema->setFormFormatterName('list');
      $this->widgetSchema->setNameFormat('vcard[%s]');
   }
}