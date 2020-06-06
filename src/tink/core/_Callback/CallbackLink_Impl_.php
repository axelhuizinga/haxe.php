<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\core\_Callback;

use \php\Boot;
use \tink\core\LinkObject;
use \tink\core\SimpleLink;

final class CallbackLink_Impl_ {
	/**
	 * @param \Closure $link
	 * 
	 * @return LinkObject
	 */
	public static function _new ($link) {
		return new SimpleLink($link);
	}

	/**
	 * @param LinkObject $this
	 * 
	 * @return void
	 */
	public static function cancel ($this1) {
		if ($this1 !== null) {
			$this1->cancel();
		}
	}

	/**
	 * @param LinkObject $this
	 * 
	 * @return void
	 */
	public static function dissolve ($this1) {
		if ($this1 !== null) {
			$this1->cancel();
		}
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return LinkObject
	 */
	public static function fromFunction ($f) {
		return new SimpleLink($f);
	}

	/**
	 * @param \Array_hx $callbacks
	 * 
	 * @return LinkObject
	 */
	public static function fromMany ($callbacks) {
		return new SimpleLink(function () use (&$callbacks) {
			if ($callbacks !== null) {
				$_g = 0;
				while ($_g < $callbacks->length) {
					$cb = ($callbacks->arr[$_g] ?? null);
					++$_g;
					if ($cb !== null) {
						$cb->cancel();
					}
				}
			} else {
				$callbacks = null;
			}
		});
	}

	/**
	 * @param LinkObject $a
	 * @param LinkObject $b
	 * 
	 * @return LinkObject
	 */
	public static function join ($a, $b) {
		return new LinkPair($a, $b);
	}

	/**
	 * @return void
	 */
	public static function noop () {
	}

	/**
	 * @param LinkObject $this
	 * 
	 * @return \Closure
	 */
	public static function toCallback ($this1) {
		return function ($_) use (&$this1) {
			$this1->cancel();
		};
	}

	/**
	 * @param LinkObject $this
	 * 
	 * @return \Closure
	 */
	public static function toFunction ($this1) {
		if ($this1 === null) {
			return Boot::getStaticClosure(CallbackLink_Impl_::class, 'noop');
		} else {
			return Boot::getInstanceClosure($this1, 'cancel');
		}
	}
}

Boot::registerClass(CallbackLink_Impl_::class, 'tink.core._Callback.CallbackLink_Impl_');
