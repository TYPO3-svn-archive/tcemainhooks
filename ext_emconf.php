<?php

########################################################################
# Extension Manager/Repository config file for ext "tcemainhooks".
#
# Auto generated 26-01-2012 16:44
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
	'author_email' => 'mk@e-netconsulting.com',
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
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:10:{s:25:"class.tx_tcemainhooks.php";s:4:"8c83";s:30:"class.tx_tcemainhooks_test.php";s:4:"4c19";s:36:"class.tx_tcemainhooks_user_class.php";s:4:"893d";s:16:"ext_autoload.php";s:4:"286e";s:12:"ext_icon.gif";s:4:"aa6e";s:17:"ext_localconf.php";s:4:"d39c";s:44:"interface.tx_tcemainhooks_user_interface.php";s:4:"798b";s:14:"doc/manual.sxw";s:4:"3f49";s:19:"doc/wizard_form.dat";s:4:"f3e4";s:20:"doc/wizard_form.html";s:4:"c814";}',
	'suggests' => array(
	),
);

?>