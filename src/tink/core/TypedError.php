<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\core;

use \php\Boot;
use \haxe\Exception;
use \haxe\NativeStackTrace;

class TypedError {
	/**
	 * @var \Array_hx
	 */
	public $callStack;
	/**
	 * @var int
	 */
	public $code;
	/**
	 * @var mixed
	 */
	public $data;
	/**
	 * @var \Array_hx
	 */
	public $exceptionStack;
	/**
	 * @var bool
	 */
	public $isTinkError;
	/**
	 * @var string
	 */
	public $message;
	/**
	 * @var object
	 */
	public $pos;

	/**
	 * @param mixed $v
	 * 
	 * @return TypedError
	 */
	public static function asError ($v) {
		if (($v instanceof TypedError)) {
			return $v;
		} else {
			return null;
		}
	}

	/**
	 * @param \Closure $f
	 * @param \Closure $report
	 * @param object $pos
	 * 
	 * @return Outcome
	 */
	public static function catchExceptions ($f, $report = null, $pos = null) {
		try {
			return Outcome::Success($f());
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$_g1 = Exception::caught($_g)->unwrap();
			$_g = TypedError::asError($_g1);
			return Outcome::Failure(($_g === null ? ($report === null ? TypedError::withData(null, "Unexpected Error", $_g1, $pos) : $report($_g1)) : $_g));
		}
	}

	/**
	 * @param int $code
	 * @param string $message
	 * @param object $pos
	 * 
	 * @return \Closure
	 */
	public static function reporter ($code = null, $message, $pos = null) {
		return function ($e) use (&$pos, &$message, &$code) {
			return TypedError::withData($code, $message, $e, $pos);
		};
	}

	/**
	 * @param mixed $any
	 * 
	 * @return mixed
	 */
	public static function rethrow ($any) {
		if (isset($__hx__caught_e, $__hx__real_e) && Boot::equal($any, $__hx__real_e)) {
			throw $__hx__caught_e;
		}
		throw Exception::thrown($any);
	}

	/**
	 * @param \Closure $f
	 * @param \Closure $cleanup
	 * 
	 * @return mixed
	 */
	public static function tryFinally ($f, $cleanup) {
		try {
			$ret = $f();
			$cleanup();
			return $ret;
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$_g1 = Exception::caught($_g)->unwrap();
			$cleanup();
			if (isset($__hx__caught_e, $__hx__real_e) && Boot::equal($_g1, $__hx__real_e)) {
				throw $__hx__caught_e;
			}
			throw Exception::thrown($_g1);
		}
	}

	/**
	 * @param int $code
	 * @param string $message
	 * @param mixed $data
	 * @param object $pos
	 * 
	 * @return TypedError
	 */
	public static function typed ($code = null, $message, $data, $pos = null) {
		$ret = new TypedError($code, $message, $pos);
		$ret->data = $data;
		return $ret;
	}

	/**
	 * @param int $code
	 * @param string $message
	 * @param mixed $data
	 * @param object $pos
	 * 
	 * @return TypedError
	 */
	public static function withData ($code = null, $message, $data, $pos = null) {
		return TypedError::typed($code, $message, $data, $pos);
	}

	/**
	 * @param int $code
	 * @param string $message
	 * @param object $pos
	 * 
	 * @return void
	 */
	public function __construct ($code = 500, $message, $pos = null) {
		if ($code === null) {
			$code = 500;
		}
		$this->isTinkError = true;
		$this->code = $code;
		$this->message = $message;
		$this->pos = $pos;
		$this->exceptionStack = new \Array_hx();
		$this->callStack = new \Array_hx();
	}

	/**
	 * @return string
	 */
	public function printPos () {
		return ($this->pos->className??'null') . "." . ($this->pos->methodName??'null') . ":" . ($this->pos->lineNumber??'null');
	}

	/**
	 * @return mixed
	 */
	public function throwSelf () {
		$any = $this;
		if (isset($__hx__caught_e, $__hx__real_e) && Boot::equal($any, $__hx__real_e)) {
			throw $__hx__caught_e;
		}
		throw Exception::thrown($any);
	}

	/**
	 * @return string
	 */
	public function toString () {
		$ret = "Error#" . ($this->code??'null') . ": " . ($this->message??'null');
		if ($this->pos !== null) {
			$ret = ($ret??'null') . " @ " . ($this->printPos()??'null');
		}
		return $ret;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(TypedError::class, 'tink.core.TypedError');
