<?php

########################################################################
# Extension Manager/Repository config file for ext "tcemainhooks".
#
# Auto generated 27-01-2012 12:55
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'SIMPLE interface to hook into tcemain',
	'description' => 'Usually you need four hook methods and some more logic to hook into tcemain to get informed whenever a record is updated, created or deleted.
This extension provides a simple interface that informs you on those changes. It provides you with two hooks , one is called before the dataset is written and one that is called afterwards.',
	'category' => 'be',
	'author' => 'Michael Knabe',
	'author_email' => 'michael.knabe@e-net.info',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.0.1',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:8:{s:25:"class.tx_tcemainhooks.php";s:4:"7478";s:30:"class.tx_tcemainhooks_test.php";s:4:"4c19";s:36:"class.tx_tcemainhooks_user_class.php";s:4:"bffe";s:16:"ext_autoload.php";s:4:"286e";s:12:"ext_icon.gif";s:4:"aa6e";s:17:"ext_localconf.php";s:4:"d39c";s:44:"interface.tx_tcemainhooks_user_interface.php";s:4:"6a6c";s:14:"doc/manual.sxw";s:4:"6458";}',
	'suggests' => array(
	),
);

?>