<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\cli\prompt;

use \php\_Boot\HxAnon;
use \tink\core\_Lazy\LazyFunc;
use \php\Boot;
use \tink\core\Noise;
use \tink\cli\Prompt;
use \tink\cli\PromptTypeBase;
use \tink\core\TypedError;
use \tink\io\_Worker\Worker_Impl_;
use \tink\core\Outcome;
use \tink\io\WorkerObject;
use \php\_Boot\HxString;
use \tink\core\_Promise\Promise_Impl_;
use \tink\core\FutureObject;

class SysPrompt implements Prompt {
	/**
	 * @var WorkerObject
	 */
	public $worker;

	/**
	 * @param WorkerObject $worker
	 * 
	 * @return void
	 */
	public function __construct ($worker = null) {
		$this->worker = Worker_Impl_::ensure($worker);
	}

	/**
	 * @param string $v
	 * 
	 * @return FutureObject
	 */
	public function print ($v) {
		return Worker_Impl_::work($this->worker, new LazyFunc(function () use (&$v) {
			echo(\Std::string($v));
			return Outcome::Success(Noise::Noise());
		}));
	}

	/**
	 * @param string $v
	 * 
	 * @return FutureObject
	 */
	public function println ($v) {
		return Worker_Impl_::work($this->worker, new LazyFunc(function () use (&$v) {
			echo((\Std::string($v)??'null') . \PHP_EOL);
			return Outcome::Success(Noise::Noise());
		}));
	}

	/**
	 * @param PromptTypeBase $type
	 * 
	 * @return FutureObject
	 */
	public function prompt ($type) {
		return Promise_Impl_::ofSpecific(Worker_Impl_::work($this->worker, new LazyFunc(function () use (&$type) {
			$__hx__switch = ($type->index);
			if ($__hx__switch === 0) {
				echo(\Std::string("" . ($type->params[0]??'null') . ": "));
				return Outcome::Success(\Sys::stdin()->readLine());
			} else if ($__hx__switch === 1) {
				echo(\Std::string("" . ($type->params[0]??'null') . " [" . ($type->params[1]->join("/")??'null') . "]: "));
				return Outcome::Success(\Sys::stdin()->readLine());
			} else if ($__hx__switch === 2) {
				echo(\Std::string("" . ($type->params[0]??'null') . ": "));
				$s = new \Array_hx();
				while (true) {
					$_g = \Sys::getChar(false);
					if ($_g === 3 || $_g === 4) {
						echo("" . \PHP_EOL);
						exit(1);
					} else if ($_g === 10 || $_g === 13) {
						echo("" . \PHP_EOL);
						break;
					} else if ($_g === 127) {
						if ($s->length > 0) {
							$s->length--;
						}
						\array_pop($s->arr);
					} else {
						if ($_g >= 32) {
							$s->arr[$s->length++] = $_g;
						} else {
							echo("" . \PHP_EOL);
							return Outcome::Failure(new TypedError(null, "Invalid char " . ($_g??'null'), new HxAnon([
								"fileName" => "tink/cli/prompt/SysPrompt.hx",
								"lineNumber" => 54,
								"className" => "tink.cli.prompt.SysPrompt",
								"methodName" => "prompt",
							])));
						}
					}
				};
				$f = Boot::getStaticClosure(HxString::class, 'fromCharCode');
				$result = [];
				$data = $s->arr;
				$_g_current = 0;
				$_g_length = \count($data);
				while ($_g_current < $_g_length) {
					$result[] = $f($data[$_g_current++]);
				}
				return Outcome::Success(\Array_hx::wrap($result)->join(""));
			}
		})));
	}
}

Boot::registerClass(SysPrompt::class, 'tink.cli.prompt.SysPrompt');
