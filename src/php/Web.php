<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace php;

use \haxe\io\_BytesData\Container;
use \php\_Boot\HxAnon;
use \haxe\Exception;
use \php\_Boot\HxString;
use \haxe\ds\List_hx;
use \haxe\ds\StringMap;
use \haxe\io\Bytes;
use \php\_NativeIndexedArray\NativeIndexedArrayIterator;

/**
 * This class is used for accessing the local Web server and the current
 * client request and information.
 */
class Web {
	/**
	 * @var StringMap
	 */
	static public $_clientHeaders;
	/**
	 * @var bool
	 */
	static public $isModNeko;

	/**
	 * Flush the data sent to the client. By default on Apache, outgoing data is buffered so
	 * this can be useful for displaying some long operation progress.
	 * 
	 * @return void
	 */
	public static function flush () {
		\flush();
	}

	/**
	 * Returns an object with the authorization sent by the client (Basic scheme only).
	 * 
	 * @return object
	 */
	public static function getAuthorization () {
		if (!isset($_SERVER["PHP_AUTH_USER"])) {
			return null;
		}
		$tmp = $_SERVER["PHP_AUTH_USER"];
		return new HxAnon([
			"user" => $tmp,
			"pass" => $_SERVER["PHP_AUTH_PW"],
		]);
	}

	/**
	 * Retrieve a client header value sent with the request.
	 * 
	 * @param string $k
	 * 
	 * @return string
	 */
	public static function getClientHeader ($k) {
		$this1 = Web::loadClientHeaders();
		$key = \str_replace("-", "_", \strtoupper($k));
		return ($this1->data[$key] ?? null);
	}

	/**
	 * Retrieve all the client headers.
	 * 
	 * @return List_hx
	 */
	public static function getClientHeaders () {
		$headers = Web::loadClientHeaders();
		$result = new List_hx();
		$key = new NativeIndexedArrayIterator(\array_values(\array_map("strval", \array_keys($headers->data))));
		while ($key->hasNext()) {
			$key1 = $key->next();
			$result->push(new HxAnon([
				"value" => ($headers->data[$key1] ?? null),
				"header" => $key1,
			]));
		}
		return $result;
	}

	/**
	 * Retrieve all the client headers as `haxe.ds.Map`.
	 * 
	 * @return StringMap
	 */
	public static function getClientHeadersMap () {
		return (clone Web::loadClientHeaders());
	}

	/**
	 * Surprisingly returns the client IP address.
	 * 
	 * @return string
	 */
	public static function getClientIP () {
		return $_SERVER["REMOTE_ADDR"];
	}

	/**
	 * Returns an hashtable of all Cookies sent by the client.
	 * Modifying the hashtable will not modify the cookie, use `php.Web.setCookie()`
	 * instead.
	 * 
	 * @return StringMap
	 */
	public static function getCookies () {
		return Lib::hashOfAssociativeArray($_COOKIE);
	}

	/**
	 * Get the current script directory in the local filesystem.
	 * 
	 * @return string
	 */
	public static function getCwd () {
		return (\dirname($_SERVER["SCRIPT_FILENAME"])??'null') . "/";
	}

	/**
	 * Returns the local server host name.
	 * 
	 * @return string
	 */
	public static function getHostName () {
		return $_SERVER["SERVER_NAME"];
	}

	/**
	 * Get the HTTP method used by the client.
	 * 
	 * @return string
	 */
	public static function getMethod () {
		if (isset($_SERVER["REQUEST_METHOD"])) {
			return $_SERVER["REQUEST_METHOD"];
		} else {
			return null;
		}
	}

	/**
	 * Get the multipart parameters as an hashtable. The data
	 * cannot exceed the maximum size specified.
	 * 
	 * @param int $maxSize
	 * 
	 * @return StringMap
	 */
	public static function getMultipart ($maxSize) {
		$h = new StringMap();
		$buf = null;
		$curname = null;
		Web::parseMultipart(function ($p, $_) use (&$buf, &$maxSize, &$curname, &$h) {
			if ($curname !== null) {
				$h->data[$curname] = $buf->b;
			}
			$curname = $p;
			$buf = new \StringBuf();
			$maxSize = $maxSize - \strlen($p);
			if ($maxSize < 0) {
				throw Exception::thrown("Maximum size reached");
			}
		}, function ($str, $pos, $len) use (&$buf, &$maxSize) {
			$maxSize -= $len;
			if ($maxSize < 0) {
				throw Exception::thrown("Maximum size reached");
			}
			$s = $str->toString();
			$buf1 = $buf;
			$buf1->b = ($buf1->b??'null') . (\mb_substr($s, $pos, $len)??'null');
		});
		if ($curname !== null) {
			$h->data[$curname] = $buf->b;
		}
		return $h;
	}

	/**
	 * Returns an Array of Strings built using GET / POST values.
	 * If you have in your URL the parameters `a[]=foo;a[]=hello;a[5]=bar;a[3]=baz` then
	 * `php.Web.getParamValues("a")` will return `["foo","hello",null,"baz",null,"bar"]`.
	 * 
	 * @param string $param
	 * 
	 * @return \Array_hx
	 */
	public static function getParamValues ($param) {
		$reg = new \EReg("^" . ($param??'null') . "(\\[|%5B)([0-9]*?)(\\]|%5D)=(.*?)\$", "");
		$res = new \Array_hx();
		$explore = function ($data) use (&$reg, &$res) {
			if (($data === null) || (\strlen($data) === 0)) {
				return;
			}
			$_g = 0;
			$_g1 = HxString::split($data, "&");
			while ($_g < $_g1->length) {
				if ($reg->match(($_g1->arr[$_g++] ?? null))) {
					$idx = $reg->matched(2);
					$val = \urldecode($reg->matched(4));
					if ($idx === "") {
						$res->arr[$res->length++] = $val;
					} else {
						$res->offsetSet(\Std::parseInt($idx), $val);
					}
				}
			}
		};
		$explore(\StringTools::replace(Web::getParamsString(), ";", "&"));
		$explore(Web::getPostData());
		if ($res->length === 0) {
			$data = (Lib::hashOfAssociativeArray($_POST)->data[$param] ?? null);
			if (\is_array($data)) {
				$collection = $data;
				foreach ($collection as $key => $value) {
					$res->offsetSet($key, $value);
				}
			}
		}
		if ($res->length === 0) {
			return null;
		}
		return $res;
	}

	/**
	 * Returns the GET and POST parameters.
	 * 
	 * @return StringMap
	 */
	public static function getParams () {
		return Lib::hashOfAssociativeArray(\array_merge($_GET, $_POST));
	}

	/**
	 * Returns all the GET parameters `String`
	 * 
	 * @return string
	 */
	public static function getParamsString () {
		if (isset($_SERVER["QUERY_STRING"])) {
			return $_SERVER["QUERY_STRING"];
		} else {
			return "";
		}
	}

	/**
	 * Returns all the POST data. POST Data is always parsed as
	 * being application/x-www-form-urlencoded and is stored into
	 * the getParams hashtable. POST Data is maximimized to 256K
	 * unless the content type is multipart/form-data. In that
	 * case, you will have to use `php.Web.getMultipart()` or
	 * `php.Web.parseMultipart()` methods.
	 * 
	 * @return string
	 */
	public static function getPostData () {
		$h = \fopen("php://input", "r");
		$data = null;
		$counter = 0;
		while (!\feof($h) && ($counter < 32)) {
			$data = ($data . \fread($h, 8192));
			++$counter;
		}
		\fclose($h);
		return $data;
	}

	/**
	 * Returns the original request URL (before any server internal redirections).
	 * 
	 * @return string
	 */
	public static function getURI () {
		return (HxString::split($_SERVER["REQUEST_URI"], "?")->arr[0] ?? null);
	}

	/**
	 * Based on https://github.com/ralouphie/getallheaders
	 * 
	 * @return StringMap
	 */
	public static function loadClientHeaders () {
		if (Web::$_clientHeaders !== null) {
			return Web::$_clientHeaders;
		}
		Web::$_clientHeaders = new StringMap();
		if (\function_exists("getallheaders")) {
			$collection = \getallheaders();
			foreach ($collection as $key => $value) {
				$this1 = Web::$_clientHeaders;
				$key1 = \str_replace("-", "_", \strtoupper($key));
				$value1 = \Std::string($value);
				$this1->data[$key1] = $value1;
			}
			return Web::$_clientHeaders;
		}
		$copyServer = [
			"CONTENT_TYPE" => "Content-Type",
			"CONTENT_LENGTH" => "Content-Length",
			"CONTENT_MD5" => "Content-Md5",
		];
		$collection = $_SERVER;
		foreach ($collection as $key => $value) {
			$key1 = $key;
			if (\substr($key, 0, 5) === "HTTP_") {
				$key1 = \substr($key, 5);
				if (!isset($copyServer[$key1]) || !isset($_SERVER[$key1])) {
					$this1 = Web::$_clientHeaders;
					$v = \Std::string($value);
					$this1->data[$key1] = $v;
				}
			} else if (isset($copyServer[$key])) {
				$this2 = Web::$_clientHeaders;
				$v1 = \Std::string($value);
				$this2->data[$key] = $v1;
			}
		}
		if (!\array_key_exists("AUTHORIZATION", Web::$_clientHeaders->data)) {
			if (isset($_SERVER["REDIRECT_HTTP_AUTHORIZATION"])) {
				$this1 = Web::$_clientHeaders;
				$v = \Std::string($_SERVER["REDIRECT_HTTP_AUTHORIZATION"]);
				$this1->data["AUTHORIZATION"] = $v;
			} else if (isset($_SERVER["PHP_AUTH_USER"])) {
				$basic_pass = (isset($_SERVER["PHP_AUTH_PW"]) ? \Std::string($_SERVER["PHP_AUTH_PW"]) : "");
				$this1 = Web::$_clientHeaders;
				$v = "Basic " . (\base64_encode((\Std::string($_SERVER["PHP_AUTH_USER"])??'null') . ":" . ($basic_pass??'null'))??'null');
				$this1->data["AUTHORIZATION"] = $v;
			} else if (isset($_SERVER["PHP_AUTH_DIGEST"])) {
				$this1 = Web::$_clientHeaders;
				$v = \Std::string($_SERVER["PHP_AUTH_DIGEST"]);
				$this1->data["AUTHORIZATION"] = $v;
			}
		}
		return Web::$_clientHeaders;
	}

	/**
	 * Parse the multipart data. Call `onPart` when a new part is found
	 * with the part name and the filename if present
	 * and `onData` when some part data is readed. You can this way
	 * directly save the data on hard drive in the case of a file upload.
	 * 
	 * @param \Closure $onPart
	 * @param \Closure $onData
	 * 
	 * @return void
	 */
	public static function parseMultipart ($onPart, $onData) {
		$collection = $_POST;
		foreach ($collection as $key => $value) {
			$onPart($key, "");
			$onData1 = $onData;
			$s = $value;
			$tmp = \strlen($s);
			$onData1(new Bytes($tmp, new Container($s)), 0, \strlen($value));
		}
		if (!isset($_FILES)) {
			return;
		}
		$collection = $_FILES;
		foreach ($collection as $key => $value) {
			unset($part);
			$part = $key;
			$handleFile = function ($tmp, $file, $err) use (&$onData, &$part, &$onPart) {
				$fileUploaded = true;
				if ($err > 0) {
					if ($err === 1) {
						throw Exception::thrown("The uploaded file exceeds the max size of " . (\ini_get("upload_max_filesize")??'null'));
					} else if ($err === 2) {
						throw Exception::thrown("The uploaded file exceeds the max file size directive specified in the HTML form (max is" . (\ini_get("post_max_size")??'null') . ")");
					} else if ($err === 3) {
						throw Exception::thrown("The uploaded file was only partially uploaded");
					} else if ($err === 4) {
						$fileUploaded = false;
					} else if ($err === 6) {
						throw Exception::thrown("Missing a temporary folder");
					} else if ($err === 7) {
						throw Exception::thrown("Failed to write file to disk");
					} else if ($err === 8) {
						throw Exception::thrown("File upload stopped by extension");
					}
				}
				if ($fileUploaded) {
					$onPart($part, $file);
					if ("" !== $file) {
						$h = \fopen($tmp, "r");
						while (!\feof($h)) {
							$buf = \fread($h, 8192);
							$size = \strlen($buf);
							$onData1 = $onData;
							$handleFile = \strlen($buf);
							$onData1(new Bytes($handleFile, new Container($buf)), 0, $size);
						}
						\fclose($h);
					}
				}
			};
			if (\is_array($value["name"])) {
				$data = \array_keys($value["name"]);
				$_g_current = 0;
				$_g_length = \count($data);
				while ($_g_current < $_g_length) {
					$index = $data[$_g_current++];
					$handleFile($value["tmp_name"][$index], $value["name"][$index], $value["error"][$index]);
				}
			} else {
				$handleFile($value["tmp_name"], $value["name"], $value["error"]);
			}
		}
	}

	/**
	 * Tell the client to redirect to the given url ("Location" header).
	 * 
	 * @param string $url
	 * 
	 * @return void
	 */
	public static function redirect ($url) {
		\header("Location: " . ($url??'null'));
	}

	/**
	 * Set a Cookie value in the HTTP headers. Same remark as `php.Web.setHeader()`.
	 * 
	 * @param string $key
	 * @param string $value
	 * @param \Date $expire
	 * @param string $domain
	 * @param string $path
	 * @param bool $secure
	 * @param bool $httpOnly
	 * 
	 * @return void
	 */
	public static function setCookie ($key, $value, $expire = null, $domain = null, $path = null, $secure = null, $httpOnly = null) {
		$t = ($expire === null ? 0 : (int)(($expire->getTime() / 1000.0)));
		if ($path === null) {
			$path = "/";
		}
		if ($domain === null) {
			$domain = "";
		}
		if ($secure === null) {
			$secure = false;
		}
		if ($httpOnly === null) {
			$httpOnly = false;
		}
		\setcookie($key, $value, $t, $path, $domain, $secure, $httpOnly);
	}

	/**
	 * Set an output header value. If some data have been printed, the headers have
	 * already been sent so this will raise an exception.
	 * 
	 * @param string $h
	 * @param string $v
	 * 
	 * @return void
	 */
	public static function setHeader ($h, $v) {
		\header("" . ($h??'null') . ": " . ($v??'null'));
	}

	/**
	 * Set the HTTP return code. Same remark as `php.Web.setHeader()`.
	 * See status code explanation here: http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	 * 
	 * @param int $r
	 * 
	 * @return void
	 */
	public static function setReturnCode ($r) {
		$code = null;
		if ($r === 100) {
			$code = "100 Continue";
		} else if ($r === 101) {
			$code = "101 Switching Protocols";
		} else if ($r === 200) {
			$code = "200 OK";
		} else if ($r === 201) {
			$code = "201 Created";
		} else if ($r === 202) {
			$code = "202 Accepted";
		} else if ($r === 203) {
			$code = "203 Non-Authoritative Information";
		} else if ($r === 204) {
			$code = "204 No Content";
		} else if ($r === 205) {
			$code = "205 Reset Content";
		} else if ($r === 206) {
			$code = "206 Partial Content";
		} else if ($r === 300) {
			$code = "300 Multiple Choices";
		} else if ($r === 301) {
			$code = "301 Moved Permanently";
		} else if ($r === 302) {
			$code = "302 Found";
		} else if ($r === 303) {
			$code = "303 See Other";
		} else if ($r === 304) {
			$code = "304 Not Modified";
		} else if ($r === 305) {
			$code = "305 Use Proxy";
		} else if ($r === 307) {
			$code = "307 Temporary Redirect";
		} else if ($r === 400) {
			$code = "400 Bad Request";
		} else if ($r === 401) {
			$code = "401 Unauthorized";
		} else if ($r === 402) {
			$code = "402 Payment Required";
		} else if ($r === 403) {
			$code = "403 Forbidden";
		} else if ($r === 404) {
			$code = "404 Not Found";
		} else if ($r === 405) {
			$code = "405 Method Not Allowed";
		} else if ($r === 406) {
			$code = "406 Not Acceptable";
		} else if ($r === 407) {
			$code = "407 Proxy Authentication Required";
		} else if ($r === 408) {
			$code = "408 Request Timeout";
		} else if ($r === 409) {
			$code = "409 Conflict";
		} else if ($r === 410) {
			$code = "410 Gone";
		} else if ($r === 411) {
			$code = "411 Length Required";
		} else if ($r === 412) {
			$code = "412 Precondition Failed";
		} else if ($r === 413) {
			$code = "413 Request Entity Too Large";
		} else if ($r === 414) {
			$code = "414 Request-URI Too Long";
		} else if ($r === 415) {
			$code = "415 Unsupported Media Type";
		} else if ($r === 416) {
			$code = "416 Requested Range Not Satisfiable";
		} else if ($r === 417) {
			$code = "417 Expectation Failed";
		} else if ($r === 500) {
			$code = "500 Internal Server Error";
		} else if ($r === 501) {
			$code = "501 Not Implemented";
		} else if ($r === 502) {
			$code = "502 Bad Gateway";
		} else if ($r === 503) {
			$code = "503 Service Unavailable";
		} else if ($r === 504) {
			$code = "504 Gateway Timeout";
		} else if ($r === 505) {
			$code = "505 HTTP Version Not Supported";
		} else {
			$code = \Std::string($r);
		}
		\header("HTTP/1.1 " . ($code??'null'), true, $r);
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;

		Web::$isModNeko = 0 !== \strncasecmp(\PHP_SAPI, "cli", 3);

	}
}

Boot::registerClass(Web::class, 'php.Web');
Web::__hx__init();