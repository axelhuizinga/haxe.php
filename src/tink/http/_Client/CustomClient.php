<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\http\_Client;

use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\core\Outcome;
use \tink\core\_Lazy\LazyConst;
use \tink\http\ClientObject;
use \tink\core\_Promise\Promise_Impl_;
use \tink\http\OutgoingRequest;
use \tink\core\FutureObject;

class CustomClient implements ClientObject {
	/**
	 * @var \Array_hx
	 */
	public $postprocessors;
	/**
	 * @var \Array_hx
	 */
	public $preprocessors;
	/**
	 * @var ClientObject
	 */
	public $real;

	/**
	 * @param \Array_hx $a
	 * @param \Array_hx $b
	 * 
	 * @return \Array_hx
	 */
	public static function concat ($a, $b) {
		if ($a === null) {
			return $b;
		} else if ($b === null) {
			return $a;
		} else {
			return $a->concat($b);
		}
	}

	/**
	 * @param ClientObject $c
	 * @param \Array_hx $preprocessors
	 * @param \Array_hx $postprocessors
	 * 
	 * @return CustomClient
	 */
	public static function create ($c, $preprocessors, $postprocessors) {
		$_g = (($c instanceof CustomClient) ? $c : null);
		if ($_g === null) {
			return new CustomClient($preprocessors, $postprocessors, $c);
		} else {
			$v = $_g;
			$tmp = CustomClient::concat($preprocessors, $v->preprocessors);
			$tmp1 = CustomClient::concat($v->postprocessors, $postprocessors);
			return new CustomClient($tmp, $tmp1, $v->real);
		}
	}

	/**
	 * @param \Array_hx $preprocessors
	 * @param \Array_hx $postprocessors
	 * @param ClientObject $real
	 * 
	 * @return void
	 */
	public function __construct ($preprocessors, $postprocessors, $real) {
		$this->preprocessors = $preprocessors;
		$this->postprocessors = $postprocessors;
		$this->real = $real;
	}

	/**
	 * @param mixed $value
	 * @param \Array_hx $transforms
	 * @param int $index
	 * 
	 * @return FutureObject
	 */
	public function pipe ($value, $transforms, $index = 0) {
		if ($index === null) {
			$index = 0;
		}
		if (($transforms !== null) && ($index < $transforms->length)) {
			$_g = Boot::getInstanceClosure($this, 'pipe');
			$transforms1 = $transforms;
			$index1 = $index + 1;
			$tmp = function ($value) use (&$transforms1, &$index1, &$_g) {
				return $_g($value, $transforms1, $index1);
			};
			return Promise_Impl_::next(($transforms->arr[$index] ?? null)($value), $tmp);
		} else {
			return new SyncFuture(new LazyConst(Outcome::Success($value)));
		}
	}

	/**
	 * @param OutgoingRequest $req
	 * 
	 * @return FutureObject
	 */
	public function request ($req) {
		$_gthis = $this;
		return Promise_Impl_::next($this->pipe($req, $this->preprocessors), function ($req) use (&$_gthis) {
			$tmp = $_gthis->real->request($req);
			$_g = Boot::getInstanceClosure($_gthis, 'pipe');
			$transforms = null;
			if ($_gthis->postprocessors === null) {
				$transforms = null;
			} else {
				$_g1 = new \Array_hx();
				$_g2 = 0;
				$_g3 = $_gthis->postprocessors;
				while ($_g2 < $_g3->length) {
					$x = ($_g3->arr[$_g2++] ?? null)($req);
					$_g1->arr[$_g1->length++] = $x;
				}
				$transforms = $_g1;
			}
			return Promise_Impl_::next($tmp, function ($value) use (&$transforms, &$_g) {
				return $_g($value, $transforms);
			});
		});
	}
}

Boot::registerClass(CustomClient::class, 'tink.http._Client.CustomClient');