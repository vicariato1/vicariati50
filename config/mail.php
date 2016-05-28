<?php

return [

'driver' => 'mailgun',
'host' => 'smtp.mailgun.org',
'port' => 587,
'from' => array('address' => 'mail@xxxxxx.com', 'name' => 'Xxxxxxxx'),
'encryption' => 'tls',
'username' => null,
'password' => null,
'sendmail' => '/usr/sbin/sendmail -bs',
'pretend' => false
];
