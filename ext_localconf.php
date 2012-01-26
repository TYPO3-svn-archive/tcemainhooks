<?php
if (TYPO3_MODE == 'BE') {
		// Register our hooks in tceMain
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['tcemainhooks'] =
		'EXT:tcemainhooks/class.tx_tcemainhooks.php:tx_tcemainhooks';
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['tcemainhooks'] =
		'EXT:tcemainhooks/class.tx_tcemainhooks.php:tx_tcemainhooks';



/*
 * This is an example on how to add the hook to your ext_localconf.php
 * Also have a look at the class.tx_tcemainhooks_test.php file.
 * The require_once is of cause not needed if you can use the TYPO3 4.3 autoloader
	require_once(t3lib_extMgm::extPath('tcemainhooks') . 'class.tx_tcemainhooks_test.php');

	$GLOBALS['EXTCONF']['tcemainhooks']['preCommit'][] = array (
		'class' => 'tx_tcemainhooks_test',
		'filter' => array(
			'status' => array(
				'new'
			),
			'tables' => array(
				'tt_address_group',
			),
		),
	);

	$GLOBALS['EXTCONF']['tcemainhooks']['postCommit'][] = array (
		'class' => 'tx_tcemainhooks_test',
		'filter' => array (
			'allFieldsChanged' => array('title', 'description'),
			'tables' => array(
				'tt_address',
			),
		),
	);
*/
}
?>