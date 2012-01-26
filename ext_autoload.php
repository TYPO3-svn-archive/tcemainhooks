<?php
$extensionPath = t3lib_extMgm::extPath('tcemainhooks');
return array(
	'tx_tcemainhooks' => $extensionPath . 'class.tx_tcemainhooks.php',
	'tx_tcemainhooks_user_class' => $extensionPath . 'class.tx_tcemainhooks_user_class.php',
	'tx_tcemainhooks_user_interface' => $extensionPath . 'interface.tx_tcemainhooks_user_interface.php',
	'tx_tcemainhooks_test' => $extensionPath . 'class.tx_tcemainhooks_test.php'
);
?>