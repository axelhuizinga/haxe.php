<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\io\_Sink;

use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\core\TypedError;
use \tink\streams\StreamObject;
use \tink\core\_Lazy\LazyConst;
use \tink\io\PipeResult;
use \tink\core\FutureObject;
use \tink\io\SinkBase;

class ErrorSink extends SinkBase {
	/**
	 * @var TypedError
	 */
	public $error;

	/**
	 * @param TypedError $error
	 * 
	 * @return void
	 */
	public function __construct ($error) {
		$this->error = $error;
	}

	/**
	 * @param StreamObject $source
	 * @param object $options
	 * 
	 * @return FutureObject
	 */
	public function consume ($source, $options) {
		return new SyncFuture(new LazyConst(PipeResult::SinkFailed($this->error, $source)));
	}

	/**
	 * @return bool
	 */
	public function get_sealed () {
		return false;
	}
}

Boot::registerClass(ErrorSink::class, 'tink.io._Sink.ErrorSink');