<?php

/**
 * Implement this interface if you want to use the hooks
 * If you don't want to implement both methods and don't need
 * to extend another class you can use the abstract class instead
 * 
 * @author Michael Knabe <mk@e-netconsulting.com>
 */
interface tx_tcemainhooks_user_interface {
	/**
	 * This method gets called whenever a record is changed in the backend.
	 * When this method is called, the new data is not yet stored
	 * 
	 * @param string $status What is done on the record (new, delete, update...)
	 * @param string $table The table being updated
	 * @param mixed $id The uid of the record (Warning: If $status is 'new' this is a string starting with NEW and no integer)
	 * @param mixed $record The old values of the record (Warning: If $status is 'new' this is NULL)
	 * @param t3lib_TCEmain $pObj The TCEmain class that does the work
	 * @return void
	 */
	public function preCommitHook($status, $table, $id, $record, $pObj);

	/**
	 * This method gets called whenever a record is changed in the backend.
	 * When this method is called, the new data is not yet stored
	 * 
	 * @param string $status What is done on the record (new, delete, update...)
	 * @param string $table The table being updated
	 * @param integer $id The uid of the record
	 * @param mixed $record The new values of the record
	 * @param mixed $oldRecord The old values of the record (Warning: If $status is 'new' this is NULL)
	 * @param t3lib_TCEmain $pObj The TCEmain class that does the work
	 * @return void
	 */
	public function postCommitHook($status, $table, $id, $record, $oldRecord, $pObj);
}

?>