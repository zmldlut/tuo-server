<?php
/**
 * Demos Dao
 *
 * @category   Demos
 * @package    Demos_Dao_Core
 * @author     linwei
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

require_once 'Demos/Dao/Core.php';

/**
 * @package Demos_Dao_Core
 */
class Core_Eiotype extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'eiotype';

	/**
	 * @static
	 */
	const TABLE_PRIM = 'id';

	/**
	 * Initialize
	 */
	public function __init ()
	{
		$this->t1 = self::TABLE_NAME;
		$this->k1 = self::TABLE_PRIM;
		$this->_bindTable($this->t1, $this->k1);
	}
	
	public function getName($id)
	{
		$eiotype = $this->read($id);
		return $eiotype['typename'];
	}
}