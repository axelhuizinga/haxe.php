<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\core\_Callback;

use \haxe\Timer;
use \php\Boot;
use \tink\core\Noise;

final class Callback_Impl_ {
	/**
	 * @var int
	 */
	const MAX_DEPTH = 500;

	/**
	 * @var int
	 */
	static public $depth = 0;

	/**
	 * @param \Closure $f
	 * 
	 * @return \Closure
	 */
	public static function _new ($f) {
		return $f;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public static function defer ($f) {
		Timer::delay($f, 0);
	}

	/**
	 * @param \Array_hx $callbacks
	 * 
	 * @return \Closure
	 */
	public static function fromMany ($callbacks) {
		return function ($v) use (&$callbacks) {
			$_g = 0;
			while ($_g < $callbacks->length) {
				Callback_Impl_::invoke(($callbacks->arr[$_g++] ?? null), $v);
			}
		};
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return \Closure
	 */
	public static function fromNiladic ($f) {
		return function ($_) use (&$f) {
			$f();
		};
	}

	/**
	 * @param \Closure $cb
	 * 
	 * @return \Closure
	 */
	public static function ignore ($cb) {
		return function ($_) use (&$cb) {
			Callback_Impl_::invoke($cb, Noise::Noise());
		};
	}

	/**
	 * @param \Closure $this
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public static function invoke ($this1, $data) {
		if (Callback_Impl_::$depth < 500) {
			Callback_Impl_::$depth++;
			$this1($data);
			Callback_Impl_::$depth--;
		} else {
			$_e = $this1;
			$_g = function ($data) use (&$_e) {
				Callback_Impl_::invoke($_e, $data);
			};
			$data1 = $data;
			Callback_Impl_::defer(function () use (&$data1, &$_g) {
				$_g($data1);
			});
		}
	}

	/**
	 * @param \Closure $this
	 * 
	 * @return \Closure
	 */
	public static function toFunction ($this1) {
		return $this1;
	}
}

Boot::registerClass(Callback_Impl_::class, 'tink.core._Callback.Callback_Impl_');