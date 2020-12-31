<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace sys\net;

use \php\_Boot\HxAnon;
use \sys\io\FileInput;
use \php\Boot;
use \haxe\Exception;
use \haxe\io\Output;
use \haxe\io\Error;
use \sys\io\FileOutput;
use \haxe\io\Input;
use \haxe\ds\IntMap;

/**
 * A TCP socket class : allow you to both connect to a given server and exchange messages or start your own server and wait for connections.
 */
class Socket {
	/**
	 * @var mixed
	 */
	public $__s;
	/**
	 * @var mixed
	 * A custom value that can be associated with the socket. Can be used to retrieve your custom infos after a `select`.
	 *
	 */
	public $custom;
	/**
	 * @var Input
	 * The stream on which you can read available data. By default the stream is blocking until the requested data is available,
	 * use `setBlocking(false)` or `setTimeout` to prevent infinite waiting.
	 */
	public $input;
	/**
	 * @var Output
	 * The stream on which you can send data. Please note that in case the output buffer you will block while writing the data, use `setBlocking(false)` or `setTimeout` to prevent that.
	 */
	public $output;
	/**
	 * @var string
	 */
	public $protocol;
	/**
	 * @var mixed
	 */
	public $stream;

	/**
	 * @param bool $r
	 * @param int $code
	 * @param string $msg
	 * 
	 * @return void
	 */
	public static function checkError ($r, $code, $msg) {
		if ($r !== false) {
			return;
		}
		throw Exception::thrown(Error::Custom("Error [" . ($code??'null') . "]: " . ($msg??'null')));
	}

	/**
	 * Since PHP 8 sockets are represented as instances of class \Socket
	 * TODO:
	 * rewrite without `cast` after resolving https://github.com/HaxeFoundation/haxe/issues/9964
	 * 
	 * @param mixed $s
	 * 
	 * @return int
	 */
	public static function getSocketId ($s) {
		if (\PHP_VERSION_ID < 80000) {
			return (int)($s);
		} else {
			return \spl_object_id($s);
		}
	}

	/**
	 * Wait until one of the sockets group is ready for the given operation:
	 * - `read` contains sockets on which we want to wait for available data to be read,
	 * - `write` contains sockets on which we want to wait until we are allowed to write some data to their output buffers,
	 * - `others` contains sockets on which we want to wait for exceptional conditions.
	 * - `select` will block until one of the condition is met, in which case it will return the sockets for which the condition was true.
	 * In case a `timeout` (in seconds) is specified, select might wait at worst until the timeout expires.
	 * 
	 * @param \Array_hx $read
	 * @param \Array_hx $write
	 * @param \Array_hx $others
	 * @param float $timeout
	 * 
	 * @return object
	 */
	public static function select ($read, $write, $others, $timeout = null) {
		$map = new IntMap();
		if ($read !== null) {
			$_g = 0;
			while ($_g < $read->length) {
				$s = ($read->arr[$_g] ?? null);
				++$_g;
				$s1 = $s->__s;
				$k = (\PHP_VERSION_ID < 80000 ? (int)($s1) : \spl_object_id($s1));
				$map->data[$k] = $s;
			}
		}
		if ($write !== null) {
			$_g = 0;
			while ($_g < $write->length) {
				$s = ($write->arr[$_g] ?? null);
				++$_g;
				$s1 = $s->__s;
				$k = (\PHP_VERSION_ID < 80000 ? (int)($s1) : \spl_object_id($s1));
				$map->data[$k] = $s;
			}
		}
		if ($others !== null) {
			$_g = 0;
			while ($_g < $others->length) {
				$s = ($others->arr[$_g] ?? null);
				++$_g;
				$s1 = $s->__s;
				$k = (\PHP_VERSION_ID < 80000 ? (int)($s1) : \spl_object_id($s1));
				$map->data[$k] = $s;
			}
		}
		$a = null;
		if ($read === null) {
			$a = new \Array_hx();
		} else {
			$_g = new \Array_hx();
			$_g1 = 0;
			while ($_g1 < $read->length) {
				$s = ($read->arr[$_g1++] ?? null);
				$_g->arr[$_g->length++] = $s->__s;
			}
			$a = $_g;
		}
		$rawRead = $a->arr;
		$a = null;
		if ($write === null) {
			$a = new \Array_hx();
		} else {
			$_g = new \Array_hx();
			$_g1 = 0;
			while ($_g1 < $write->length) {
				$s = ($write->arr[$_g1++] ?? null);
				$_g->arr[$_g->length++] = $s->__s;
			}
			$a = $_g;
		}
		$rawWrite = $a->arr;
		$a = null;
		if ($others === null) {
			$a = new \Array_hx();
		} else {
			$_g = new \Array_hx();
			$_g1 = 0;
			while ($_g1 < $others->length) {
				$s = ($others->arr[$_g1++] ?? null);
				$_g->arr[$_g->length++] = $s->__s;
			}
			$a = $_g;
		}
		$rawOthers = $a->arr;
		Socket::checkError(\socket_select($rawRead, $rawWrite, $rawOthers, ($timeout === null ? null : (int)($timeout)), ($timeout === null ? 0 : (int)((fmod($timeout, 1) * 1000000)))), 0, "Error during select call");
		$result = \Array_hx::wrap($rawRead);
		$_g = new \Array_hx();
		$_g1 = 0;
		while ($_g1 < $result->length) {
			$r = ($result->arr[$_g1] ?? null);
			++$_g1;
			$key = (\PHP_VERSION_ID < 80000 ? (int)($r) : \spl_object_id($r));
			$x = ($map->data[$key] ?? null);
			$_g->arr[$_g->length++] = $x;
		}
		$result = \Array_hx::wrap($rawWrite);
		$_g1 = new \Array_hx();
		$_g2 = 0;
		while ($_g2 < $result->length) {
			$r = ($result->arr[$_g2] ?? null);
			++$_g2;
			$key = (\PHP_VERSION_ID < 80000 ? (int)($r) : \spl_object_id($r));
			$x = ($map->data[$key] ?? null);
			$_g1->arr[$_g1->length++] = $x;
		}
		$result = \Array_hx::wrap($rawOthers);
		$_g2 = new \Array_hx();
		$_g3 = 0;
		while ($_g3 < $result->length) {
			$r = ($result->arr[$_g3] ?? null);
			++$_g3;
			$key = (\PHP_VERSION_ID < 80000 ? (int)($r) : \spl_object_id($r));
			$x = ($map->data[$key] ?? null);
			$_g2->arr[$_g2->length++] = $x;
		}
		return new HxAnon([
			"read" => $_g,
			"write" => $_g1,
			"others" => $_g2,
		]);
	}

	/**
	 * Creates a new unconnected socket.
	 * 
	 * @return void
	 */
	public function __construct () {
		$this->input = new FileInput(null);
		$this->output = new FileOutput(null);
		$this->initSocket();
		$this->protocol = "tcp";
	}

	/**
	 * Accept a new connected client. This will return a connected socket on which you can read/write some data.
	 * 
	 * @return Socket
	 */
	public function accept () {
		$r = \socket_accept($this->__s);
		Socket::checkError($r, 0, "Unable to accept connections on socket");
		$s = new Socket();
		$s->__s = $r;
		$s->assignHandler();
		return $s;
	}

	/**
	 * @return void
	 */
	public function assignHandler () {
		$this->stream = \socket_export_stream($this->__s);
		$this->input->__f = $this->stream;
		$this->output->__f = $this->stream;
	}

	/**
	 * Bind the socket to the given host/port so it can afterwards listen for connections there.
	 * 
	 * @param Host $host
	 * @param int $port
	 * 
	 * @return void
	 */
	public function bind ($host, $port) {
		Socket::checkError(\socket_bind($this->__s, $host->host, $port), 0, "Unable to bind socket");
	}

	/**
	 * Closes the socket : make sure to properly close all your sockets or you will crash when you run out of file descriptors.
	 * 
	 * @return void
	 */
	public function close () {
		\socket_close($this->__s);
		$this->input->__f = null;
		$this->output->__f = null;
		$this->input->close();
		$this->output->close();
	}

	/**
	 * Connect to the given server host/port. Throw an exception in case we couldn't successfully connect.
	 * 
	 * @param Host $host
	 * @param int $port
	 * 
	 * @return void
	 */
	public function connect ($host, $port) {
		Socket::checkError(\socket_connect($this->__s, $host->host, $port), 0, "Unable to connect");
		$this->assignHandler();
	}

	/**
	 * Return the information about our side of a connected socket.
	 * 
	 * @return object
	 */
	public function host () {
		$host = "";
		$port = 0;
		Socket::checkError(\socket_getsockname($this->__s, $host, $port), 0, "Unable to retrieve the host name");
		return new HxAnon([
			"host" => new Host($host),
			"port" => $port,
		]);
	}

	/**
	 * @return void
	 */
	public function initSocket () {
		$this->__s = \socket_create(\AF_INET, \SOCK_STREAM, \SOL_TCP);
	}

	/**
	 * Allow the socket to listen for incoming questions. The parameter tells how many pending connections we can have until they get refused. Use `accept()` to accept incoming connections.
	 * 
	 * @param int $connections
	 * 
	 * @return void
	 */
	public function listen ($connections) {
		Socket::checkError(\socket_listen($this->__s, $connections), 0, "Unable to listen on socket");
		$this->assignHandler();
	}

	/**
	 * Return the information about the other side of a connected socket.
	 * 
	 * @return object
	 */
	public function peer () {
		$host = "";
		$port = 0;
		Socket::checkError(\socket_getpeername($this->__s, $host, $port), 0, "Unable to retrieve the peer name");
		return new HxAnon([
			"host" => new Host($host),
			"port" => $port,
		]);
	}

	/**
	 * Read the whole data available on the socket.
	 *Note*: this is **not** meant to be used together with `setBlocking(false)`,
	 * as it will always throw `haxe.io.Error.Blocked`. `input` methods should be used directly instead.
	 * 
	 * @return string
	 */
	public function read () {
		$b = "";
		while (!\feof($this->stream)) {
			$b = ($b??'null') . (\fgets($this->stream)??'null');
		}
		return $b;
	}

	/**
	 * Change the blocking mode of the socket. A blocking socket is the default behavior. A non-blocking socket will abort blocking operations immediately by throwing a haxe.io.Error.Blocked value.
	 * 
	 * @param bool $b
	 * 
	 * @return void
	 */
	public function setBlocking ($b) {
		Socket::checkError(($b ? \socket_set_block($this->__s) : \socket_set_nonblock($this->__s)), 0, "Unable to set blocking");
	}

	/**
	 * Allows the socket to immediately send the data when written to its output : this will cause less ping but might increase the number of packets / data size, especially when doing a lot of small writes.
	 * 
	 * @param bool $b
	 * 
	 * @return void
	 */
	public function setFastSend ($b) {
		Socket::checkError(\socket_set_option($this->__s, \SOL_TCP, \TCP_NODELAY, true), 0, "Unable to set TCP_NODELAY on socket");
	}

	/**
	 * Gives a timeout (in seconds) after which blocking socket operations (such as reading and writing) will abort and throw an exception.
	 * 
	 * @param float $timeout
	 * 
	 * @return void
	 */
	public function setTimeout ($timeout) {
		$s = (int)($timeout);
		$timeOut = [
			"sec" => $s,
			"usec" => (int)((($timeout - $s) * 1000000)),
		];
		$r = \socket_set_option($this->__s, \SOL_SOCKET, \SO_RCVTIMEO, $timeOut);
		Socket::checkError($r, 0, "Unable to set receive timeout");
		$r = \socket_set_option($this->__s, \SOL_SOCKET, \SO_SNDTIMEO, $timeOut);
		Socket::checkError($r, 0, "Unable to set send timeout");
	}

	/**
	 * Shutdown the socket, either for reading or writing.
	 * 
	 * @param bool $read
	 * @param bool $write
	 * 
	 * @return void
	 */
	public function shutdown ($read, $write) {
		Socket::checkError(\socket_shutdown($this->__s, ($read && $write ? 2 : ($write ? 1 : ($read ? 0 : 2)))), 0, "Unable to shutdown");
	}

	/**
	 * Block until some data is available for read on the socket.
	 * 
	 * @return void
	 */
	public function waitForRead () {
		Socket::select(\Array_hx::wrap([$this]), null, null);
	}

	/**
	 * Write the whole data to the socket output.
	 *Note*: this is **not** meant to be used together with `setBlocking(false)`, as
	 * `haxe.io.Error.Blocked` may be thrown mid-write with no indication of how many bytes have been written.
	 * `output.writeBytes()` should be used instead as it returns this information.
	 * 
	 * @param string $content
	 * 
	 * @return void
	 */
	public function write ($content) {
		\fwrite($this->stream, $content);
	}
}

Boot::registerClass(Socket::class, 'sys.net.Socket');
