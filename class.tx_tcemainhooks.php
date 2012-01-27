<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Michael Knabe <michael.knabe@e-net.info>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Hook methods for tcemain
 *
 * @author	Michael Knabe <michael.knabe@e-net.info>
 */
class tx_tcemainhooks {
	protected $hookObjects = array();
	protected $records = array();

	/**
	 * This hook is called for example by list module if deleting a record.
	 * At this point the action is not yet done, so for example deleted is still 0.
	 *
	 * @param string $command new, delete, ...
	 * @param string $table Table we are working on
	 * @param int $id Record uid of the updated record
	 * @param mixed $value Unused
	 * @param t3lib_TCEmain &$pObj Unused reference to parent object
	 * @return void
	 */
	public function processCmdmap_preProcess($command, $table, $id, $value, &$pObj) {
		$this->callPreCommitHook($command, $table, $id, $pObj);
	}

	public function processCmdmap_postProcess($command, $table, $id, $value, &$pObj) {
		$this->callPostCommitHook($command, $table, $id, $pObj);
	}

	/**
	 * This hook is called before the dataset and its relations are written.
	 * This way you can become aware of relations which are about to be deleted.
	 *
	 * @param array $fieldArray The record values (before the change)
	 * @param string $table Table we are working on
	 * @param int $id Record uid of the updated record
	 * @param t3lib_TCEmain &$pObj Unused reference to parent object
	 * @return void
	 */
	public function processDatamap_preProcessFieldArray($fieldArray, $table, $id, &$pObj) {
			// If this is a new record the processDatamap_postProcessFieldArray
			// hook already called the preCommitHook
		if (t3lib_div::testInt($id)) {
				// This is no new record, so we assume this is an update.
				// This is exactly the same that TCEmain does.
			$this->callPreCommitHook('update', $table, $id, $pObj);
		}
	}

	/**
	 * If this is a _new_ record, the relations are written when this hook is called.
	 * However, getting the information about the actual record is quite ugly here
	 * as we have to make some assumptions about the internals of the parent object.
	 * Thats why we use this hook only for new records.
	 *
	 * @param t3lib_TCEmain &$pObj The caller object
	 * @return void
	 */
	public function processDatamap_afterAllOperations(&$pObj) {
		$table = reset($pObj->substNEWwithIDs_table);
		$id = reset($pObj->substNEWwithIDs);

			// This is the only case where $id being an integer indicates a new record
		if (t3lib_div::testInt($id) && $id > 0) {
			/*
			 * This should always be true as long as the assumptions made
			 * above are right. But when TCEmain changes, we prefer to not
			 * call the hook at all instead of calling it with wrong parameters.
			 *
			 * This needs to be in the if clause for new records, as the hook
			 * would be called twice for updated records otherwise.
			 * Once here and once in the processDatamap_postProcessFieldArray hook.
			 */
			if (strlen($table) && intval($id)) {
				$this->callPostCommitHook('new', $table, $id, $pObj);
			}
		}
	}

	/**
	 * If this is a _new_ record, the relations are not yet written.
	 * If this is an old record being updated, the relations are already written.
	 *
	 * @param string $status new, delete...
	 * @param string $table The table we are working on
	 * @param integer $id The UID of the record
	 * @param array $fieldArray The data of the record. Not sure if already updated.
	 * @param t3lib_TCEmain &$pObj The caller object
	 * @return void
	 */
	public function processDatamap_postProcessFieldArray($status, $table, $id, $fieldArray, &$pObj) {
		if ($status == 'new') {
			$this->callPreCommitHook($status, $table, $id, $pObj);
		}
	}

	/**
	 * If this is a _new_ record, the relations are not yet written.
	 * If this is an old record being updated, the relations are already written.
	 *
	 * @param string $status new, delete...
	 * @param string $table The table we are working on
	 * @param integer $id The UID of the record
	 * @param array $fieldArray The data of the record. Not sure if already updated.
	 * @param t3lib_TCEmain &$pObj The caller object
	 * @return void
	 */
	public function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, &$pObj) {
		if ($status !== 'new') {
			$this->callPostCommitHook($status, $table, $id, $pObj);
		}
	}

	protected function callPreCommitHook($status, $table, $id, $pObj) {
		if (t3lib_div::testInt($id)) {
			list($record) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $table, 'uid=' . $id);
		} else {
				// This is a new record and it is not written yet.
				// That's why we don't try to fetch it.
				// This is a special case you have to handle in your hook methods.
				// @TODO find a better solution
			$record = NULL;
		}

		if (is_array($GLOBALS['EXTCONF']['tcemainhooks']['preCommit'])) {
			foreach ($GLOBALS['EXTCONF']['tcemainhooks']['preCommit'] as $hookConfig) {
				if ($this->hookShallBeCalled($hookConfig, $status, $table, $id, $record)) {
					$hookObject = $this->getHookObject($hookConfig);
					$hookObject->preCommitHook($status, $table, $id, $record, $pObj);
				}
			}
		}

		$this->records[$table][$id] = $record;
	}

	protected function callPostCommitHook($status, $table, $id, $pObj) {
		list($record) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $table, 'uid=' . $id);

		if (is_array($GLOBALS['EXTCONF']['tcemainhooks']['postCommit'])) {
			foreach ($GLOBALS['EXTCONF']['tcemainhooks']['postCommit'] as $hookConfig) {
				if ($this->hookShallBeCalled($hookConfig, $status, $table, $id, $record)) {
					$hookObject = $this->getHookObject($hookConfig);
					$hookObject->postCommitHook($status, $table, $id, $record, $this->records[$table][$id], $pObj);
				}
			}
		}
	}

	protected function hookShallBeCalled($hookConfig, $status, $table, $id, $record) {
		$filter = $hookConfig['filter'];

			// No filters configured
		if (!is_array($filter)) {
			return TRUE;
		}

			// Filter by table name
		if (is_array($filter['tables']) && !in_array($table, $filter['tables'])) {
			return FALSE;
		}

			// Filter by status
		if (is_array($filter['status']) && !in_array($status, $filter['status'])) {
			return FALSE;
		}

			// If the record is deleted no field is ever changed.
			// So we call the hook ignoring the changed-filters.
		if ($status == 'delete') {
			return TRUE;
		}

			// Filter by changed fields (AND)
			// This makes only sense for the postCommitHook
		if (is_array($filter['allFieldsChanged'])) {
			$oldRecord = $this->records[$table][$id];
			foreach ($filter['allFieldsChanged'] as $fieldName) {
				if ($oldRecord[$fieldName] === $record[$fieldName]) {
					return FALSE;
				}
			}
		}

			// Filter by changed fields (OR)
			// This makes only sense for the postCommitHook
		if (is_array($filter['oneFieldChanged'])) {
			$oldRecord = $this->records[$table][$id];
			foreach ($filter['oneFieldChanged'] as $fieldName) {
				if ($oldRecord[$fieldName] !== $record[$fieldName]) {
					return TRUE;
				}
			}
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Returns the object containing the hook methods that will be called
	 *
	 * @param array $hookConfig
	 * @return tx_tcemainhooks_user
	 */
	protected function getHookObject($hookConfig) {
		$className = $hookConfig['class'];
		if (! array_key_exists($className, $this->hookObjects)) {
			$this->hookObjects[$className] = t3lib_div::makeInstance($className);
		}
		if (!$this->hookObjects[$className] instanceof tx_tcemainhooks_user_interface) {
			throw new Exception('No valid hook object configured. Must implement tx_tcemainhooks_user_interface', 1302899792);
		}
		return $this->hookObjects[$className];
	}
}

?>