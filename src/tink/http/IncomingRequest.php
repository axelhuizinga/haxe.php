<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http;

use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \tink\io\RealSourceTools;
use \php\Boot;
use \tink\io\_Source\Source_Impl_;
use \tink\core\TypedError;
use \tink\streams\StreamObject;
use \tink\core\Outcome;
use \tink\core\_Lazy\LazyConst;
use \php\_Boot\HxString;
use \tink\core\_Promise\Promise_Impl_;
use \tink\core\FutureObject;

class IncomingRequest extends Message {
	/**
	 * @var string
	 */
	public $clientIp;

	/**
	 * @param string $clientIp
	 * @param StreamObject $source
	 * 
	 * @return FutureObject
	 */
	public static function parse ($clientIp, $source) {
		return Promise_Impl_::next(RealSourceTools::parse($source, IncomingRequestHeader::parser()), function ($parts) use (&$clientIp) {
			$clientIp1 = $clientIp;
			$parts1 = $parts->a;
			$_g = $parts->a->getContentLength();
			$d = null;
			$__hx__switch = ($_g->index);
			if ($__hx__switch === 0) {
				$d = Source_Impl_::limit($parts->b, $_g->params[0]);
			} else if ($__hx__switch === 1) {
				$_g = $parts->a->byName("transfer-encoding");
				$__hx__switch = ($parts->a->method);
				if ($__hx__switch === "GET" || $__hx__switch === "OPTIONS") {
					$d = Source_Impl_::$EMPTY;
				} else {
					if ($_g->index === 0) {
						$_this = HxString::split($_g->params[0], ",");
						$f = Boot::getStaticClosure(\StringTools::class, 'trim');
						$result = [];
						$data = $_this->arr;
						$_g_current = 0;
						$_g_length = \count($data);
						while ($_g_current < $_g_length) {
							$result[] = $f($data[$_g_current++]);
						}
						if (\Array_hx::wrap($result)->indexOf("chunked") !== -1) {
							$source = $parts->b;
							$d = Chunked::decoder()->transform($source);
						} else {
							return new SyncFuture(new LazyConst(Outcome::Failure(new TypedError(411, "Content-Length header missing", new HxAnon([
								"fileName" => "tink/http/Request.hx",
								"lineNumber" => 142,
								"className" => "tink.http.IncomingRequest",
								"methodName" => "parse",
							])))));
						}
					} else {
						return new SyncFuture(new LazyConst(Outcome::Failure(new TypedError(411, "Content-Length header missing", new HxAnon([
							"fileName" => "tink/http/Request.hx",
							"lineNumber" => 142,
							"className" => "tink.http.IncomingRequest",
							"methodName" => "parse",
						])))));
					}
				}
			}
			return new SyncFuture(new LazyConst(Outcome::Success(new IncomingRequest($clientIp1, $parts1, IncomingRequestBody::Plain($d)))));
		});
	}

	/**
	 * @param string $clientIp
	 * @param IncomingRequestHeader $header
	 * @param IncomingRequestBody $body
	 * 
	 * @return void
	 */
	public function __construct ($clientIp, $header, $body) {
		$this->clientIp = $clientIp;
		parent::__construct($header, $body);
	}
}

Boot::registerClass(IncomingRequest::class, 'tink.http.IncomingRequest');
