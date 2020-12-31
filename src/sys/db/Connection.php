<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace sys\db;

use \php\Boot;

interface Connection {
	/**
	 * @param \StringBuf $s
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public function addValue ($s, $v) ;

	/**
	 * @return void
	 */
	public function close () ;

	/**
	 * @return void
	 */
	public function commit () ;

	/**
	 * @return string
	 */
	public function dbName () ;

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public function escape ($s) ;

	/**
	 * @return int
	 */
	public function lastInsertId () ;

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public function quote ($s) ;

	/**
	 * @param string $s
	 * 
	 * @return ResultSet
	 */
	public function request ($s) ;

	/**
	 * @return void
	 */
	public function rollback () ;

	/**
	 * @return void
	 */
	public function startTransaction () ;
}

Boot::registerClass(Connection::class, 'sys.db.Connection');
