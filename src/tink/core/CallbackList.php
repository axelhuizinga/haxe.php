<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\core;

use \php\Boot;
use \tink\core\_Callback\Callback_Impl_;
use \tink\core\_Callback\ListCell;
use \php\_Boot\HxClosure;

class CallbackList {
	/**
	 * @var bool
	 */
	public $busy;
	/**
	 * @var \Array_hx
	 */
	public $cells;
	/**
	 * @var \Closure
	 */
	public $ondrain;
	/**
	 * @var \Array_hx
	 */
	public $queue;
	/**
	 * @var int
	 */
	public $used;

	/**
	 * @return void
	 */
	public function __construct () {
		if (!$this->__hx__default__ondrain) {
			$this->__hx__default__ondrain = new HxClosure($this, 'ondrain');
			if ($this->ondrain === null) $this->ondrain = $this->__hx__default__ondrain;
		}
		$this->busy = false;
		$this->queue = new \Array_hx();
		$this->used = 0;
		$this->cells = new \Array_hx();
	}

	/**
	 * @param \Closure $cb
	 * 
	 * @return LinkObject
	 */
	public function add ($cb) {
		$node = new ListCell($cb, $this);
		$_this = $this->cells;
		$_this->arr[$_this->length++] = $node;
		$this->used++;
		return $node;
	}

	/**
	 * @return void
	 */
	public function clear () {
		if ($this->busy) {
			$_this = $this->queue;
			$_this->arr[$_this->length++] = Boot::getInstanceClosure($this, 'clear');
		}
		$_g = 0;
		$_g1 = $this->cells;
		while ($_g < $_g1->length) {
			$cell = ($_g1->arr[$_g] ?? null);
			++$_g;
			$cell->cb = null;
			$cell->list = null;
		}
		$this->resize(0);
	}

	/**
	 * @return void
	 */
	public function compact () {
		if ($this->busy) {
			return;
		} else if ($this->used === 0) {
			$this->resize(0);
			$this->ondrain();
		} else {
			$compacted = 0;
			$_g = 0;
			$_g1 = $this->cells->length;
			while ($_g < $_g1) {
				$i = $_g++;
				$_g2 = ($this->cells->arr[$i] ?? null);
				if ($_g2->cb !== null) {
					if ($compacted !== $i) {
						$this->cells->offsetSet($compacted, $_g2);
					}
					if (++$compacted === $this->used) {
						break;
					}
				}
			}
			$this->resize($this->used);
		}
	}

	/**
	 * @return int
	 */
	public function get_length () {
		return $this->used;
	}

	/**
	 * @param mixed $data
	 * @param bool $destructive
	 * 
	 * @return void
	 */
	public function invoke ($data, $destructive = null) {
		if ($this->busy) {
			$_this = $this->queue;
			$_g = Boot::getInstanceClosure($this, 'invoke');
			$data1 = $data;
			$destructive1 = $destructive;
			$tmp = function () use (&$data1, &$destructive1, &$_g) {
				$_g($data1, $destructive1);
			};
			$_this->arr[$_this->length++] = $tmp;
		} else {
			$this->busy = true;
			$length = $this->cells->length;
			$_g1 = 0;
			while ($_g1 < $length) {
				$_this = ($this->cells->arr[$_g1++] ?? null);
				if ($_this->list !== null) {
					Callback_Impl_::invoke($_this->cb, $data);
				}
			}
			$this->busy = false;
			if ($destructive) {
				$added = $this->cells->length - $length;
				$_g1 = 0;
				while ($_g1 < $length) {
					$_this = ($this->cells->arr[$_g1++] ?? null);
					$_this->cb = null;
					$_this->list = null;
				}
				$_g1 = 0;
				while ($_g1 < $added) {
					$i = $_g1++;
					$this->cells->offsetSet($i, ($this->cells->arr[$length + $i] ?? null));
				}
				$this->resize($added);
			} else if ($this->used < $this->cells->length) {
				$this->compact();
			}
			if ($this->queue->length > 0) {
				$_this = $this->queue;
				if ($_this->length > 0) {
					$_this->length--;
				}
				array_shift($_this->arr)();
			}
		}
	}

	/**
	 * @return void
	 */
	public function ondrain ()
	{
		if ($this->ondrain !== $this->__hx__default__ondrain) return call_user_func_array($this->ondrain, func_get_args());
	}
	protected $__hx__default__ondrain;

	/**
	 * @return void
	 */
	public function release () {
		if (--$this->used < ($this->used >> 1)) {
			$this->compact();
		}
	}

	/**
	 * @param int $length
	 * 
	 * @return void
	 */
	public function resize ($length) {
		$this->cells->resize($length);
	}
}

Boot::registerClass(CallbackList::class, 'tink.core.CallbackList');
Boot::registerGetters('tink\\core\\CallbackList', [
	'length' => true
]);
