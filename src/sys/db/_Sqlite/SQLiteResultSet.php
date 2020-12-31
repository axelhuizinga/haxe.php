<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace sys\db\_Sqlite;

use \php\_Boot\HxAnon;
use \php\Boot;
use \sys\db\ResultSet;
use \haxe\ds\List_hx;

class SQLiteResultSet implements ResultSet {
	/**
	 * @var int
	 */
	public $_length;
	/**
	 * @var int
	 */
	public $_nfields;
	/**
	 * @var int
	 */
	public $currentIndex;
	/**
	 * @var mixed
	 */
	public $fetchedRow;
	/**
	 * @var mixed
	 */
	public $fieldsInfo;
	/**
	 * @var int
	 */
	public $length;
	/**
	 * @var bool
	 */
	public $loaded;
	/**
	 * @var int
	 */
	public $nfields;
	/**
	 * @var \SQLite3Result
	 */
	public $result;
	/**
	 * @var mixed
	 */
	public $rows;

	/**
	 * @param \SQLite3Result $result
	 * 
	 * @return void
	 */
	public function __construct ($result) {
		$this->currentIndex = 0;
		$this->loaded = false;
		$this->_nfields = 0;
		$this->_length = 0;
		$this->result = $result;
	}

	/**
	 * @param mixed $row
	 * 
	 * @return mixed
	 */
	public function correctArrayTypes ($row) {
		$_gthis = $this;
		if ($this->fieldsInfo === null) {
			$this->fieldsInfo = [];
			$_g = 0;
			$_g1 = $this->get_nfields();
			while ($_g < $_g1) {
				$i = $_g++;
				$key = $this->result->columnName($i);
				$val = $this->result->columnType($i);
				$this->fieldsInfo[$key] = $val;
			}
		}
		$fieldsInfo = $this->fieldsInfo;
		foreach ($row as $key => $value) {
			$row[$key] = $_gthis->correctType($value, $fieldsInfo[$key]);
		}
		return $row;
	}

	/**
	 * @param string $value
	 * @param int $type
	 * 
	 * @return mixed
	 */
	public function correctType ($value, $type) {
		if ($value === null) {
			return null;
		}
		if ($type === \SQLITE3_INTEGER) {
			return (int)($value);
		}
		if ($type === \SQLITE3_FLOAT) {
			return (float)($value);
		}
		return $value;
	}

	/**
	 * @return void
	 */
	public function fetchAll () {
		$this->rows = [];
		$index = 0;
		$row = $this->result->fetchArray(\SQLITE3_ASSOC);
		while ($row !== false) {
			$val = $this->correctArrayTypes($row);
			$this->rows[$index] = $val;
			$row = $this->result->fetchArray(\SQLITE3_ASSOC);
			++$index;
		}
		$this->_length = $index;
	}

	/**
	 * @return mixed
	 */
	public function getFieldsInfo () {
		if ($this->fieldsInfo === null) {
			$this->fieldsInfo = [];
			$_g = 0;
			$_g1 = $this->get_nfields();
			while ($_g < $_g1) {
				$i = $_g++;
				$key = $this->result->columnName($i);
				$val = $this->result->columnType($i);
				$this->fieldsInfo[$key] = $val;
			}
		}
		return $this->fieldsInfo;
	}

	/**
	 * @return \Array_hx
	 */
	public function getFieldsNames () {
		if ($this->fieldsInfo === null) {
			$this->fieldsInfo = [];
			$_g = 0;
			$_g1 = $this->get_nfields();
			while ($_g < $_g1) {
				$i = $_g++;
				$key = $this->result->columnName($i);
				$val = $this->result->columnType($i);
				$this->fieldsInfo[$key] = $val;
			}
		}
		return \Array_hx::wrap(\array_keys($this->fieldsInfo));
	}

	/**
	 * @param int $n
	 * 
	 * @return float
	 */
	public function getFloatResult ($n) {
		return (float)($this->getResult($n));
	}

	/**
	 * @param int $n
	 * 
	 * @return int
	 */
	public function getIntResult ($n) {
		return (int)($this->getResult($n));
	}

	/**
	 * @param int $n
	 * 
	 * @return string
	 */
	public function getResult ($n) {
		if (!$this->loaded) {
			$this->load();
		}
		if (!$this->hasNext()) {
			return null;
		}
		return \array_values($this->rows[$this->currentIndex])[$n];
	}

	/**
	 * @return int
	 */
	public function get_length () {
		return $this->_length;
	}

	/**
	 * @return int
	 */
	public function get_nfields () {
		return $this->_nfields;
	}

	/**
	 * @return bool
	 */
	public function hasNext () {
		if (!$this->loaded) {
			$this->load();
		}
		return $this->currentIndex < $this->_length;
	}

	/**
	 * @return void
	 */
	public function load () {
		$this->loaded = true;
		$this->_nfields = $this->result->numColumns();
		if ($this->fieldsInfo === null) {
			$this->fieldsInfo = [];
			$_g = 0;
			$_g1 = $this->get_nfields();
			while ($_g < $_g1) {
				$i = $_g++;
				$key = $this->result->columnName($i);
				$val = $this->result->columnType($i);
				$this->fieldsInfo[$key] = $val;
			}
		}
		$this->fetchAll();
	}

	/**
	 * @return mixed
	 */
	public function next () {
		if (!$this->loaded) {
			$this->load();
		}
		return new HxAnon($this->correctArrayTypes($this->rows[$this->currentIndex++]));
	}

	/**
	 * @return List_hx
	 */
	public function results () {
		$_gthis = $this;
		if (!$this->loaded) {
			$this->load();
		}
		$list = new List_hx();
		$collection = $this->rows;
		foreach ($collection as $key => $value) {
			$list->add(new HxAnon($_gthis->correctArrayTypes($value)));
		}
		return $list;
	}
}

Boot::registerClass(SQLiteResultSet::class, 'sys.db._Sqlite.SQLiteResultSet');
Boot::registerGetters('sys\\db\\_Sqlite\\SQLiteResultSet', [
	'nfields' => true,
	'length' => true
]);
