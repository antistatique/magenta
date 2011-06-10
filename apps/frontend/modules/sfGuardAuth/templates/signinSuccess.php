<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
<?php use_helper('Javascript') ?>
<?php echo javascript_tag("window.onload = function(){
  document.getElementById('signin_username').focus();document.getElementById('signin_username').select()}")
  ;?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <h1>Magenta - Login</h1>
  <div id="content">
    <div id="login">

    <p>
      <?php echo $form['username']->render(array('class' => 'fields')) ?>
     
      <?php echo $form['password']->render(array('class' => 'fields')) ?>
      
      <?php echo $form['remember']->render(array('class' => 'remember')) ?>

      <input id="submit_btn" type="submit" value="Valider" class="btn pink"/>
      <a href="<?php echo url_for('@sf_guard_password') ?>" class="btn pink">Mot de passe oublié ?</a>
    </p>
    </div>
    <?php if($form->hasGlobalErrors() && $errors = $form->getGlobalErrors()): ?>
      <div id="login_error">
        <h2><?php echo $errors[0]; ?></h2>
      </div>
    <?php endif; ?>
  </div>
</form>

<script type="text/javascript" src="http://include.reinvigorate.net/re_.js"></script>
<script type="text/javascript">
try {
var re_name_tag = "<?php echo $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getUsername() : 'Anonymous';  ?>";
var re_context_tag = "<?php echo $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getUsername().'@antistatique.net' : ''; ?>";
reinvigorate.track("c6607-7da73691r2");
} catch(err) {}
</script>
</body>
</html>
