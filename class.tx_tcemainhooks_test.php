<?php

require_once(t3lib_extMgm::extPath('tcemainhooks') . 'interface.tx_tcemainhooks_user_interface.php');

class tx_tcemainhooks_test implements tx_tcemainhooks_user_interface {
	public function preCommitHook($status, $table, $id, $record, $pObj) {
		debug(func_get_args(), 'prehook called');
	}
	public function postCommitHook($status, $table, $id, $record, $oldRecord, $pObj) {
		debug(func_get_args(), 'posthook called');
	}
}

?>