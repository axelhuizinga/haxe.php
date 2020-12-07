<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams;

use \php\Boot;
use \tink\core\_Future\Future_Impl_;
use \tink\core\FutureObject;

class FutureStream extends StreamBase {
	/**
	 * @var FutureObject
	 */
	public $f;

	/**
	 * @param FutureObject $f
	 * 
	 * @return void
	 */
	public function __construct ($f) {
		parent::__construct();
		$this->f = $f;
	}

	/**
	 * @param \Closure $handler
	 * 
	 * @return FutureObject
	 */
	public function forEach ($handler) {
		$_gthis = $this;
		return Future_Impl_::async(function ($cb) use (&$_gthis, &$handler) {
			$_gthis->f->handle(function ($s) use (&$handler, &$cb) {
				$s->forEach($handler)->handle($cb);
			});
		});
	}

	/**
	 * @return FutureObject
	 */
	public function next () {
		return $this->f->flatMap(function ($s) {
			return $s->next();
		})->gather();
	}
}

Boot::registerClass(FutureStream::class, 'tink.streams.FutureStream');