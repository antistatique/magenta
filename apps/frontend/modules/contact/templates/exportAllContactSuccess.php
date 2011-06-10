<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>exportAllContactSuccess</title>
	
</head>

<body>
<table border="1" cellspacing="5" cellpadding="5">
   <tr>
      <th>Email</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Hi message</th>
      <th>Intro Texte</th>
      <th>Team Guy</th>            
      <th>Titre</th>
   </tr>
   <?php foreach($companys as $company):?>
      <?php foreach($company->getContacts() as $contact):?>
         <tr>
            <td>
               <?php if(!$contact->getEmail()):?>
                  <?php echo $company->getEmail();?>
               <?php else:?>
                  <?php echo $contact->getEmail();?>
               <?php endif;?>
            </td>
            <td>
               <?php echo $contact->getName();?>
            </td>
            <td>
               <?php echo $contact->getFirstname();?>
            </td>  
            <td>
               
            </td>
            <td>
               
            </td>
            <td>
               <?php echo $company->getEmployee()->getFirstName();?>
            </td>
            <td>
               <?php echo $contact->getTitle();?>               
            </td>
         </tr>
         
      <?php endforeach;?>
   <?php endforeach;?>   
   </table>
</body>
</html>
