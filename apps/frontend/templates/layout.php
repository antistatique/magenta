<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<title><?php
if(has_slot('page_title')):
   echo get_slot('page_title').' - '.sfConfig::get('app_magenta_appname', 'Magenta');
else:
   echo $sf_response->getTitle();
endif;
?></title>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
   <div id="centreur">
      <div id="header">

         <div id="logo">
            <?php echo link_to(image_tag('/images/contenu_magenta_logo.gif'),'@homepage')?>
         </div>
         
        <?php include_partial('global/menu') ?>
        <?php include_component_slot('submenu_module') ?>
        
        <div id="session_bloc"<?php echo $sf_user->hasFlash('signin') ? ' class="just_signed"' : ''; ?>>
          Bienvenue <?php echo $sf_user->getGuardUser()->getUsername() ?><br/>
          <a href="<?php echo url_for('@sf_guard_signout');?>" id="signout_link">déconnexion</a>
        </div>
        
        <?php $type = $sf_request->hasAttribute('message_type') ? $sf_request->getAttribute('message_type') : $sf_user->getFlash('message_type', '') ?>
        <?php $message = $sf_request->hasAttribute('message') ? $sf_request->getAttribute('message') : $sf_user->getFlash('message', '') ?>        
         <div id="message" <?php echo $type ? 'class="actived '.$type.'"' : ''; ?> >
           <h2><?php echo $message ?></h2>
         </div>
         
      </div><!--end header-->
      <div id="contenu">
            <?php echo $sf_data->getRaw('sf_content') ?>
         <div id="footer">
            <ul>
               <li><a href="<?php echo sfConfig::get('app_magenta_trac_ticket') ?>" class="sousmenuitem tracicone"><span>Signaler un bug</span></a></li>
            </ul>
            <div id="magenta_version">
               Version <?php echo sfConfig::get('app_magenta_version') ?>
            </div>
         </div>
      </div><!--end contenu-->
      

   </div><!--end centreur-->

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
