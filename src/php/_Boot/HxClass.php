<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace php\_Boot;

use \php\Boot;

/**
 * Class<T> implementation for Haxe->PHP internals.
 */
class HxClass {
	/**
	 * @var string
	 */
	public $phpClassName;

	/**
	 * @param string $phpClassName
	 * 
	 * @return void
	 */
	public function __construct ($phpClassName) {
		$this->phpClassName = $phpClassName;
	}

	/**
	 * Magic method to call static methods of this class, when `HxClass` instance is in a `Dynamic` variable.
	 * 
	 * @param string $method
	 * @param mixed $args
	 * 
	 * @return mixed
	 */
	public function __call ($method, $args) {
		return \call_user_func_array(((($this->phpClassName === "String" ? HxString::class : $this->phpClassName))??'null') . "::" . ($method??'null'), $args);
	}

	/**
	 * Magic method to get static vars of this class, when `HxClass` instance is in a `Dynamic` variable.
	 * 
	 * @param string $property
	 * 
	 * @return mixed
	 */
	public function __get ($property) {
		if (\defined("" . ($this->phpClassName??'null') . "::" . ($property??'null'))) {
			return \constant("" . ($this->phpClassName??'null') . "::" . ($property??'null'));
		} else if (Boot::hasGetter($this->phpClassName, $property)) {
			$tmp = $this->phpClassName;
			return $tmp::{"get_" . ($property??'null')}();
		} else if (\method_exists($this->phpClassName, $property)) {
			return Boot::getStaticClosure($this->phpClassName, $property);
		} else {
			$tmp = $this->phpClassName;
			return $tmp::${$property};
		}
	}

	/**
	 * Magic method to set static vars of this class, when `HxClass` instance is in a `Dynamic` variable.
	 * 
	 * @param string $property
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function __set ($property, $value) {
		if (Boot::hasSetter($this->phpClassName, $property)) {
			$tmp = $this->phpClassName;
			$tmp::{"set_" . ($property??'null')}($value);
		} else {
			$tmp = $this->phpClassName;
			$tmp::${$property} = $value;
		}
	}
}

Boot::registerClass(HxClass::class, 'php._Boot.HxClass');
