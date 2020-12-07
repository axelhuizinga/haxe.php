<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\io\std;

use \php\_Boot\HxAnon;
use \tink\io\PipeResultTools;
use \tink\core\_Lazy\LazyFunc;
use \php\Boot;
use \haxe\Exception;
use \tink\core\Noise;
use \haxe\io\Output;
use \haxe\io\Eof;
use \tink\core\TypedError;
use \tink\streams\StreamObject;
use \tink\io\_Worker\Worker_Impl_;
use \tink\chunk\ByteChunk;
use \haxe\io\Error;
use \tink\core\Outcome;
use \tink\io\WorkerObject;
use \tink\streams\Handled;
use \tink\streams\_Stream\Handler_Impl_;
use \tink\core\_Future\Future_Impl_;
use \tink\_Chunk\Chunk_Impl_;
use \haxe\NativeStackTrace;
use \tink\core\FutureObject;
use \tink\io\SinkBase;

class OutputSink extends SinkBase {
	/**
	 * @var string
	 */
	public $name;
	/**
	 * @var Output
	 */
	public $target;
	/**
	 * @var WorkerObject
	 */
	public $worker;

	/**
	 * @param string $name
	 * @param Output $target
	 * @param WorkerObject $worker
	 * 
	 * @return void
	 */
	public function __construct ($name, $target, $worker) {
		$this->name = $name;
		$this->target = $target;
		$this->worker = $worker;
	}

	/**
	 * @param StreamObject $source
	 * @param object $options
	 * 
	 * @return FutureObject
	 */
	public function consume ($source, $options) {
		$_gthis = $this;
		$rest = Chunk_Impl_::$EMPTY;
		$ret = $source->forEach(Handler_Impl_::ofUnknown(function ($c) use (&$rest, &$_gthis) {
			return Future_Impl_::async(function ($cb) use (&$c, &$rest, &$_gthis) {
				$pos = 0;
				$bytes = $c->toBytes();
				$write = null;
				$write = function () use (&$pos, &$write, &$bytes, &$rest, &$_gthis, &$cb) {
					if ($pos === $bytes->length) {
						$cb(Handled::Resume());
					} else {
						Worker_Impl_::work($_gthis->worker, new LazyFunc(function () use (&$pos, &$bytes, &$_gthis) {
							try {
								return Outcome::Success($_gthis->target->writeBytes($bytes, $pos, $bytes->length - $pos));
							} catch(\Throwable $_g) {
								NativeStackTrace::saveStack($_g);
								$_g1 = Exception::caught($_g)->unwrap();
								if (($_g1 instanceof Eof)) {
									return Outcome::Success(-1);
								} else if (Boot::isOfType($_g1, Boot::getClass(Error::class))) {
									$e = $_g1;
									if ($e->index === 0) {
										return Outcome::Success(0);
									} else {
										return Outcome::Failure(TypedError::withData(null, "Error writing to " . ($_gthis->name??'null'), $e, new HxAnon([
											"fileName" => "tink/io/std/OutputSink.hx",
											"lineNumber" => 40,
											"className" => "tink.io.std.OutputSink",
											"methodName" => "consume",
										])));
									}
								} else if (($_g1 instanceof TypedError)) {
									return Outcome::Failure($_g1);
								} else {
									return Outcome::Failure(TypedError::withData(null, "Error writing to " . ($_gthis->name??'null'), $_g1, new HxAnon([
										"fileName" => "tink/io/std/OutputSink.hx",
										"lineNumber" => 46,
										"className" => "tink.io.std.OutputSink",
										"methodName" => "consume",
									])));
								}
							}
						}))->handle(function ($o) use (&$pos, &$write, &$bytes, &$rest, &$cb) {
							$__hx__switch = ($o->index);
							if ($__hx__switch === 0) {
								$_g = $o->params[0];
								if ($_g === -1) {
									$rest = ByteChunk::of($bytes)->slice($pos, $bytes->length);
									$cb(Handled::Finish());
								} else {
									$pos += $_g;
									if ($pos === $bytes->length) {
										$cb(Handled::Resume());
									} else {
										$write();
									}
								}
							} else if ($__hx__switch === 1) {
								$cb(Handled::Clog($o->params[0]));
							}
						});
					}
				};
				$write();
			});
		}));
		if (($options !== null) && $options->end) {
			$ret->handle(function ($end) use (&$_gthis) {
				try {
					$_gthis->target->close();
				} catch(\Throwable $_g) {
					NativeStackTrace::saveStack($_g);
				}
			});
		}
		return $ret->map(function ($c) use (&$rest) {
			return PipeResultTools::toResult($c, Noise::Noise(), $rest);
		})->gather();
	}
}

Boot::registerClass(OutputSink::class, 'tink.io.std.OutputSink');