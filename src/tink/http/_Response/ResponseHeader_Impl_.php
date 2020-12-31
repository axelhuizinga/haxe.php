<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http\_Response;

use \tink\io\StreamParserObject;
use \php\Boot;
use \tink\http\ResponseHeaderBase;

final class ResponseHeader_Impl_ {
	/**
	 * @param int $statusCode
	 * @param string $reason
	 * @param \Array_hx $fields
	 * @param string $protocol
	 * 
	 * @return ResponseHeaderBase
	 */
	public static function _new ($statusCode, $reason = null, $fields = null, $protocol = "HTTP/1.1") {
		if ($protocol === null) {
			$protocol = "HTTP/1.1";
		}
		return new ResponseHeaderBase($statusCode, $reason, $fields, $protocol);
	}

	/**
	 * @param \Array_hx $fields
	 * 
	 * @return ResponseHeaderBase
	 */
	public static function fromHeaderFields ($fields) {
		return new ResponseHeaderBase(200, null, $fields, "HTTP/1.1");
	}

	/**
	 * @param int $code
	 * 
	 * @return ResponseHeaderBase
	 */
	public static function fromStatusCode ($code) {
		return new ResponseHeaderBase($code, null, null, "HTTP/1.1");
	}

	/**
	 * @return StreamParserObject
	 */
	public static function parser () {
		return ResponseHeaderBase::parser();
	}
}

Boot::registerClass(ResponseHeader_Impl_::class, 'tink.http._Response.ResponseHeader_Impl_');
