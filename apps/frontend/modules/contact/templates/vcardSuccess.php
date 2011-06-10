<?php
decorate_with(false);
$sf_response->setHttpHeader('Pragma', '');
$sf_response->setContentType('application/directory; profile="vcard"; charset=utf-8');
$sf_response->setHttpHeader('Content-Length', strlen($output));
$sf_response->setHttpHeader('Content-Disposition', 'attachement; filename="'.$company->getName().'.vcf"');

echo $output;