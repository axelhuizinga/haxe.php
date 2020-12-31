<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace thenshim;

use \php\Boot;

/**
 * Common signature for this library to specify objects that provide a `then`
 * method.
 */
interface Thenable {
	/**
	 * Calls the given callbacks when this promise is settled.
	 *
	 * Note that unlike the JavaScript `then`, the return type parameter
	 * is only `R` where as JavaScript `then` has possible parameter types of
	 * `T`, `R1`, and `R2`.
	 *
	 * @param onFulfilled A callback that will be called with the value `T`
	 *     when the promise is fulfilled. The callback returns a promise
	 *     or value.
	 * @param onRejected A callback that will be called with the reason `Any`
	 *     when the promise is rejected. The callback returns a promise
	 *     or value.
	 * 
	 * @param \Closure $onFulfilled
	 * @param \Closure $onRejected
	 * 
	 * @return Thenable
	 */
	public function then ($onFulfilled, $onRejected = null) ;
}

Boot::registerClass(Thenable::class, 'thenshim.Thenable');
