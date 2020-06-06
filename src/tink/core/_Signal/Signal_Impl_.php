<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\core\_Signal;

use \tink\core\_Callback\LinkPair;
use \php\Boot;
use \tink\core\Noise;
use \tink\core\LinkObject;
use \tink\core\_Callback\Callback_Impl_;
use \tink\core\FutureTrigger;
use \tink\core\SimpleLink;
use \tink\core\SignalTrigger;
use \tink\core\SignalObject;
use \tink\core\_Callback\CallbackLink_Impl_;
use \tink\core\FutureObject;

final class Signal_Impl_ {
	/**
	 * @param \Closure $f
	 * 
	 * @return SignalObject
	 */
	public static function _new ($f) {
		return new SimpleSignal($f);
	}

	/**
	 * @param \Closure $create
	 * 
	 * @return SignalObject
	 */
	public static function create ($create) {
		return new Suspendable($create);
	}

	/**
	 *  Creates a new signal whose values will only be emitted when the filter function evalutes to `true`
	 * 
	 * @param SignalObject $this
	 * @param \Closure $f
	 * @param bool $gather
	 * 
	 * @return SignalObject
	 */
	public static function filter ($this1, $f, $gather = true) {
		if ($gather === null) {
			$gather = true;
		}
		$ret = new SimpleSignal(function ($cb) use (&$f, &$this1) {
			return $this1->listen(function ($result) use (&$f, &$cb) {
				if ($f($result)) {
					Callback_Impl_::invoke($cb, $result);
				}
			});
		});
		if ($gather) {
			return Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}

	/**
	 *  Creates a new signal by applying a transform function to the result.
	 *  Different from `map`, the transform function of `flatMap` returns a `Future`
	 * 
	 * @param SignalObject $this
	 * @param \Closure $f
	 * @param bool $gather
	 * 
	 * @return SignalObject
	 */
	public static function flatMap ($this1, $f, $gather = true) {
		if ($gather === null) {
			$gather = true;
		}
		$ret = new SimpleSignal(function ($cb) use (&$f, &$this1) {
			return $this1->listen(function ($result) use (&$f, &$cb) {
				$f($result)->handle($cb);
			});
		});
		if ($gather) {
			return Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}

	/**
	 *  Creates a new signal which stores the result internally.
	 *  Useful for tranformed signals, such as product of `map` and `flatMap`,
	 *  so that the transformation function will not be invoked for every callback
	 * 
	 * @param SignalObject $this
	 * 
	 * @return SignalObject
	 */
	public static function gather ($this1) {
		$ret = Signal_Impl_::trigger();
		$this1->listen(function ($x) use (&$ret) {
			$ret->handlers->invoke($x);
		});
		return $ret;
	}

	/**
	 * @param \Closure $generator
	 * 
	 * @return SignalObject
	 */
	public static function generate ($generator) {
		$ret = Signal_Impl_::trigger();
		$generator(Boot::getInstanceClosure($ret, 'trigger'));
		return $ret;
	}

	/**
	 * @param SignalObject $this
	 * @param \Closure $handler
	 * 
	 * @return LinkObject
	 */
	public static function handle ($this1, $handler) {
		return $this1->listen($handler);
	}

	/**
	 *  Creates a new signal by joining `this` and `other`,
	 *  the new signal will be triggered whenever either of the two triggers
	 * 
	 * @param SignalObject $this
	 * @param SignalObject $other
	 * @param bool $gather
	 * 
	 * @return SignalObject
	 */
	public static function join ($this1, $other, $gather = true) {
		if ($gather === null) {
			$gather = true;
		}
		$ret = new SimpleSignal(function ($cb) use (&$other, &$this1) {
			$a = $this1->listen($cb);
			return new LinkPair($a, $other->listen($cb));
		});
		if ($gather) {
			return Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}

	/**
	 *  Creates a new signal by applying a transform function to the result.
	 *  Different from `flatMap`, the transform function of `map` returns a sync value
	 * 
	 * @param SignalObject $this
	 * @param \Closure $f
	 * @param bool $gather
	 * 
	 * @return SignalObject
	 */
	public static function map ($this1, $f, $gather = true) {
		if ($gather === null) {
			$gather = true;
		}
		$ret = new SimpleSignal(function ($cb) use (&$f, &$this1) {
			return $this1->listen(function ($result) use (&$f, &$cb) {
				Callback_Impl_::invoke($cb, $f($result));
			});
		});
		if ($gather) {
			return Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}

	/**
	 * @param SignalObject $this
	 * @param \Closure $condition
	 * 
	 * @return FutureObject
	 */
	public static function next ($this1, $condition = null) {
		return Signal_Impl_::nextTime($this1, $condition);
	}

	/**
	 *  Gets the next emitted value as a Future
	 * 
	 * @param SignalObject $this
	 * @param \Closure $condition
	 * 
	 * @return FutureObject
	 */
	public static function nextTime ($this1, $condition = null) {
		$ret = new FutureTrigger();
		$link = null;
		$immediate = false;
		$link = $this1->listen(function ($v) use (&$immediate, &$condition, &$link, &$ret) {
			if (($condition === null) || $condition($v)) {
				$ret->trigger($v);
				if ($link === null) {
					$immediate = true;
				} else if ($link !== null) {
					$link->cancel();
				}
			}
		});
		if ($immediate) {
			if ($link !== null) {
				$link->cancel();
			}
		}
		return $ret;
	}

	/**
	 *  Transforms this signal and makes it emit `Noise`
	 * 
	 * @param SignalObject $this
	 * 
	 * @return SignalObject
	 */
	public static function noise ($this1) {
		return Signal_Impl_::map($this1, function ($_) {
			return Noise::Noise();
		});
	}

	/**
	 *  Creates a `Signal` from classic signals that has the semantics of `addListener` and `removeListener`
	 *  Example: `var signal = Signal.ofClassical(emitter.addListener.bind(eventType), emitter.removeListener.bind(eventType));`
	 * 
	 * @param \Closure $add
	 * @param \Closure $remove
	 * @param bool $gather
	 * 
	 * @return SignalObject
	 */
	public static function ofClassical ($add, $remove, $gather = true) {
		if ($gather === null) {
			$gather = true;
		}
		$ret = new SimpleSignal(function ($cb) use (&$remove, &$add) {
			$f = function ($a) use (&$cb) {
				Callback_Impl_::invoke($cb, $a);
			};
			$add($f);
			$_g = $remove;
			$a1 = $f;
			return new SimpleLink(function () use (&$_g, &$a1) {
				$_g($a1);
			});
		});
		if ($gather) {
			return Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}

	/**
	 * @param SignalObject $this
	 * @param \Closure $selector
	 * @param bool $gather
	 * 
	 * @return SignalObject
	 */
	public static function select ($this1, $selector, $gather = true) {
		if ($gather === null) {
			$gather = true;
		}
		$ret = new SimpleSignal(function ($cb) use (&$selector, &$this1) {
			return $this1->listen(function ($result) use (&$selector, &$cb) {
				$_g = $selector($result);
				$__hx__switch = ($_g->index);
				if ($__hx__switch === 0) {
					Callback_Impl_::invoke($cb, $_g->params[0]);
				} else if ($__hx__switch === 1) {
				}
			});
		});
		if ($gather) {
			return Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}

	/**
	 *  Creates a new `SignalTrigger`
	 * 
	 * @return SignalTrigger
	 */
	public static function trigger () {
		return new SignalTrigger();
	}

	/**
	 * @param SignalObject $this
	 * @param FutureObject $end
	 * 
	 * @return SignalObject
	 */
	public static function until ($this1, $end) {
		$ret = new Suspendable(function ($yield) use (&$this1) {
			$this2 = $this1->listen($yield);
			if ($this2 === null) {
				return Boot::getStaticClosure(CallbackLink_Impl_::class, 'noop');
			} else {
				return Boot::getInstanceClosure($this2, 'cancel');
			}
		});
		$end->handle(Callback_Impl_::fromNiladic(Boot::getInstanceClosure($ret, 'kill')));
		return $ret;
	}
}

Boot::registerClass(Signal_Impl_::class, 'tink.core._Signal.Signal_Impl_');
