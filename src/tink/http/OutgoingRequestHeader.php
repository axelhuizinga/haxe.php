<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http;

use \php\Boot;

class OutgoingRequestHeader extends RequestHeader {
	/**
	 * @param string $method
	 * @param object $url
	 * @param string $protocol
	 * @param \Array_hx $fields
	 * 
	 * @return void
	 */
	public function __construct ($method, $url, $protocol, $fields) {
		parent::__construct($method, $url, $protocol, $fields);
	}

	/**
	 * @param \Array_hx $fields
	 * 
	 * @return OutgoingRequestHeader
	 */
	public function concat ($fields) {
		$tmp = $this->method;
		$tmp1 = $this->url;
		$tmp2 = $this->protocol;
		return new OutgoingRequestHeader($tmp, $tmp1, $tmp2, $this->fields->concat($fields));
	}
}

Boot::registerClass(OutgoingRequestHeader::class, 'tink.http.OutgoingRequestHeader');
