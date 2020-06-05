<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace thenshim\fallback;

use \php\Boot;
use \php\_Boot\HxClosure;

/**
 * Schedules tasks on an event loop.
 */
class TaskScheduler {
	/**
	 * @var \Closure
	 * Schedule a task to be run on the next event loop cycle.
	 *
	 * Overwrite this function with an implementation that integrates
	 * with your event loop to ensure the promise is Promise/A+ compliant.
	 *
	 * On JS, this uses `setIntermediate` or `setTimeout` for testing purposes.
	 */
	public $addNext;

	/**
	 * @return void
	 */
	public function __construct () {
		if (!$this->__hx__default__addNext) {
			$this->__hx__default__addNext = new HxClosure($this, 'addNext');
			if ($this->addNext === null) $this->addNext = $this->__hx__default__addNext;
		}
	}

	/**
	 * Schedule a task to be run on the next event loop cycle.
	 *
	 * Overwrite this function with an implementation that integrates
	 * with your event loop to ensure the promise is Promise/A+ compliant.
	 *
	 * On JS, this uses `setIntermediate` or `setTimeout` for testing purposes.
	 * 
	 * @param \Closure $task
	 * 
	 * @return void
	 */
	public function addNext ($task)
	{
		if ($this->addNext !== $this->__hx__default__addNext) return call_user_func_array($this->addNext, func_get_args());
		$task();
	}
	protected $__hx__default__addNext;
}

Boot::registerClass(TaskScheduler::class, 'thenshim.fallback.TaskScheduler');
