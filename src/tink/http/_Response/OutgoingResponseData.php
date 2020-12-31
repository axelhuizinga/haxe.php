<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http\_Response;

use \php\Boot;
use \tink\streams\StreamObject;
use \tink\http\ResponseHeaderBase;
use \tink\http\Message;

class OutgoingResponseData extends Message {
	/**
	 * @param ResponseHeaderBase $header
	 * @param StreamObject $body
	 * 
	 * @return void
	 */
	public function __construct ($header, $body) {
		parent::__construct($header, $body);
	}
}

Boot::registerClass(OutgoingResponseData::class, 'tink.http._Response.OutgoingResponseData');
