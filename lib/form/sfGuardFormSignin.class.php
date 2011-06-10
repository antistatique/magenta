<?php
// Override sfGuardFormSignin of sfGuardPlugin
class sfGuardFormSignin extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(),
      'remember' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'username' => new sfValidatorString(),
      'password' => new sfValidatorString(),
      'remember' => new sfValidatorBoolean(),
    ));
    
    $this->setDefault('remember', true);
    
    $this->validatorSchema->setPostValidator(new sfGuardValidatorUser(array('throw_global_error' => true), array(
      'invalid' => 'Mot de passe invalide!'
    )));

    $this->widgetSchema->setNameFormat('signin[%s]');
  }
}