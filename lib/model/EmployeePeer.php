<?php


/**
 * Skeleton subclass for performing query and update operations on the 'employee' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class EmployeePeer extends BaseEmployeePeer {

	/**
	 * Retrieve a single object by sfGuard Username.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     Employee
	 */
	public static function retrieveByUsername($username)
	{

		$criteria = new Criteria();
      $criteria->addJoin(EmployeePeer::SF_GUARD_USER_ID, sfGuardUserPeer::ID);
		$criteria->add(sfGuardUserPeer::USERNAME, $username);

		$v = EmployeePeer::doSelect($criteria);

		return !empty($v) > 0 ? $v[0] : null;
	}

} // EmployeePeer
