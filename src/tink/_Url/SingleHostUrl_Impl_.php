<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\_Url;

use \php\_Boot\HxAnon;
use \php\Boot;

final class SingleHostUrl_Impl_ {
	/**
	 * @param object $v
	 * 
	 * @return object
	 */
	public static function _new ($v) {
		return $v;
	}

	/**
	 * @param string $s
	 * 
	 * @return object
	 */
	public static function ofString ($s) {
		return SingleHostUrl_Impl_::ofUrl(Url_Impl_::fromString($s));
	}

	/**
	 * @param object $u
	 * 
	 * @return object
	 */
	public static function ofUrl ($u) {
		$v = null;
		$__hx__switch = ($u->hosts->length);
		if ($__hx__switch === 0) {
			$v = $u;
		} else if ($__hx__switch === 1) {
			$v = $u;
		} else {
			$v = Url_Impl_::make(new HxAnon([
				"path" => $u->path,
				"query" => $u->query,
				"hosts" => \Array_hx::wrap([($u->hosts->arr[0] ?? null)]),
				"auth" => $u->auth,
				"scheme" => $u->scheme,
				"hash" => $u->hash,
			]));
		}
		return $v;
	}
}

Boot::registerClass(SingleHostUrl_Impl_::class, 'tink._Url.SingleHostUrl_Impl_');
