<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\http;

use \php\Boot;
use \tink\streams\StreamObject;

class OutgoingRequest extends Message {
	/**
	 * @param OutgoingRequestHeader $header
	 * @param StreamObject $body
	 * 
	 * @return void
	 */
	public function __construct ($header, $body) {
		parent::__construct($header, $body);
	}
}

Boot::registerClass(OutgoingRequest::class, 'tink.http.OutgoingRequest');