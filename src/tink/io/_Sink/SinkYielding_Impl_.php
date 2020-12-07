<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\io\_Sink;

use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \tink\io\SinkObject;
use \php\Boot;
use \haxe\io\Output;
use \tink\io\_Source\Source_Impl_;
use \tink\core\TypedError;
use \tink\io\_Worker\Worker_Impl_;
use \tink\core\Outcome;
use \tink\io\std\OutputSink;
use \tink\core\_Lazy\LazyConst;
use \tink\core\FutureObject;

final class SinkYielding_Impl_ {
	/**
	 * @var SinkObject
	 */
	static public $BLACKHOLE;

	/**
	 * @param SinkObject $this
	 * 
	 * @return SinkObject
	 */
	public static function dirty ($this1) {
		return $this1;
	}

	/**
	 * @param SinkObject $this
	 * 
	 * @return FutureObject
	 */
	public static function end ($this1) {
		if ($this1->get_sealed()) {
			return new SyncFuture(new LazyConst(Outcome::Success(false)));
		} else {
			return $this1->consume(Source_Impl_::$EMPTY, new HxAnon(["end" => true]))->map(function ($r) {
				$__hx__switch = ($r->index);
				if ($__hx__switch === 0) {
					return Outcome::Success(true);
				} else if ($__hx__switch === 1) {
					return Outcome::Success(true);
				} else if ($__hx__switch === 2) {
					return Outcome::Failure($r->params[0]);
				}
			})->gather();
		}
	}

	/**
	 * @param TypedError $e
	 * 
	 * @return SinkObject
	 */
	public static function ofError ($e) {
		return new ErrorSink($e);
	}

	/**
	 * @param string $name
	 * @param Output $target
	 * @param object $options
	 * 
	 * @return SinkObject
	 */
	public static function ofOutput ($name, $target, $options = null) {
		$tmp = null;
		if ($options === null) {
			$tmp = Worker_Impl_::get();
		} else {
			$_g = $options->worker;
			$tmp = ($_g === null ? Worker_Impl_::get() : $_g);
		}
		return new OutputSink($name, $target, $tmp);
	}

	/**
	 * @param FutureObject $p
	 * 
	 * @return SinkObject
	 */
	public static function ofPromised ($p) {
		return new FutureSink($p->map(function ($o) {
			$__hx__switch = ($o->index);
			if ($__hx__switch === 0) {
				return $o->params[0];
			} else if ($__hx__switch === 1) {
				return SinkYielding_Impl_::ofError($o->params[0]);
			}
		})->gather());
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;


		self::$BLACKHOLE = Blackhole::$inst;
	}
}

Boot::registerClass(SinkYielding_Impl_::class, 'tink.io._Sink.SinkYielding_Impl_');
SinkYielding_Impl_::__hx__init();