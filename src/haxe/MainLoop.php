<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe;

use \php\Boot;

class MainLoop {
	/**
	 * @var MainEvent
	 */
	static public $pending;

	/**
	 * Add a pending event to be run into the main loop.
	 * 
	 * @param \Closure $f
	 * @param int $priority
	 * 
	 * @return MainEvent
	 */
	public static function add ($f, $priority = 0) {
		if ($priority === null) {
			$priority = 0;
		}
		if ($f === null) {
			throw Exception::thrown("Event function is null");
		}
		$e = new MainEvent($f, $priority);
		$head = MainLoop::$pending;
		if ($head !== null) {
			$head->prev = $e;
		}
		$e->next = $head;
		MainLoop::$pending = $e;
		return $e;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public static function addThread ($f) {
		EntryPoint::addThread($f);
	}

	/**
	 * @return int
	 */
	public static function get_threadCount () {
		return EntryPoint::$threadCount;
	}

	/**
	 * @return bool
	 */
	public static function hasEvents () {
		$p = MainLoop::$pending;
		while ($p !== null) {
			if ($p->isBlocking) {
				return true;
			}
			$p = $p->next;
		}
		return false;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public static function runInMainThread ($f) {
		EntryPoint::runInMainThread($f);
	}

	/**
	 * @return void
	 */
	public static function sortEvents () {
		$list = MainLoop::$pending;
		if ($list === null) {
			return;
		}
		$insize = 1;
		$nmerges = null;
		$psize = 0;
		$qsize = 0;
		$p = null;
		$q = null;
		$e = null;
		$tail = null;
		while (true) {
			$p = $list;
			$list = null;
			$tail = null;
			$nmerges = 0;
			while ($p !== null) {
				++$nmerges;
				$q = $p;
				$psize = 0;
				$_g = 0;
				$_g1 = $insize;
				while ($_g < $_g1) {
					$i = $_g++;
					++$psize;
					$q = $q->next;
					if ($q === null) {
						break;
					}
				}
				$qsize = $insize;
				while (($psize > 0) || (($qsize > 0) && ($q !== null))) {
					if ($psize === 0) {
						$e = $q;
						$q = $q->next;
						--$qsize;
					} else if (($qsize === 0) || ($q === null) || (($p->priority > $q->priority) || (($p->priority === $q->priority) && ($p->nextRun <= $q->nextRun)))) {
						$e = $p;
						$p = $p->next;
						--$psize;
					} else {
						$e = $q;
						$q = $q->next;
						--$qsize;
					}
					if ($tail !== null) {
						$tail->next = $e;
					} else {
						$list = $e;
					}
					$e->prev = $tail;
					$tail = $e;
				}
				$p = $q;
			}
			$tail->next = null;
			if ($nmerges <= 1) {
				break;
			}
			$insize *= 2;
		}
		$list->prev = null;
		MainLoop::$pending = $list;
	}

	/**
	 * Run the pending events. Return the time for next event.
	 * 
	 * @return float
	 */
	public static function tick () {
		MainLoop::sortEvents();
		$e = MainLoop::$pending;
		$now = microtime(true);
		$wait = 1e9;
		while ($e !== null) {
			$next = $e->next;
			$wt = $e->nextRun - $now;
			if ($wt <= 0) {
				$wait = 0;
				if ($e->f !== null) {
					($e->f)();
				}
			} else if ($wait > $wt) {
				$wait = $wt;
			}
			$e = $next;
		}
		return $wait;
	}
}

Boot::registerClass(MainLoop::class, 'haxe.MainLoop');
Boot::registerGetters('haxe\\MainLoop', [
	'threadCount' => true
]);
