<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace php\net;

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Exception;
use \sys\net\Socket as NetSocket;
use \php\_Boot\HxString;
use \sys\net\Host;

class Socket extends NetSocket {
	/**
	 * @var bool
	 */
	public $connected;
	/**
	 * @var float
	 */
	public $timeout;

	/**
	 * @param bool $r
	 * @param int $code
	 * @param string $msg
	 * 
	 * @return void
	 */
	public static function checkError ($r, $code, $msg) {
		NetSocket::checkError($r, $code, $msg);
	}

	/**
	 * @param string $protocol
	 * 
	 * @return int
	 */
	public static function getProtocol ($protocol) {
		return getprotobyname($protocol);
	}

	/**
	 * @param bool $isUdp
	 * 
	 * @return int
	 */
	public static function getType ($isUdp) {
		if ($isUdp) {
			return SOCK_DGRAM;
		} else {
			return SOCK_STREAM;
		}
	}

	/**
	 * @param \Array_hx $read
	 * @param \Array_hx $write
	 * @param \Array_hx $others
	 * @param float $timeout
	 * 
	 * @return object
	 */
	public static function select ($read, $write, $others, $timeout = null) {
		throw Exception::thrown("Not implemented");
	}

	/**
	 * @return void
	 */
	public function __construct () {
		$this->timeout = null;
		$this->connected = false;
		parent::__construct();
		$this->protocol = "tcp";
	}

	/**
	 * @return Socket
	 */
	public function accept () {
		$r = stream_socket_accept($this->__s);
		NetSocket::checkError($r, 0, "Unable to accept connections on socket");
		$s = new Socket();
		$s->__s = $r;
		$s->assignHandler();
		return $s;
	}

	/**
	 * @return void
	 */
	public function assignHandler () {
		$this->input->__f = $this->__s;
		$this->output->__f = $this->__s;
		$this->connected = true;
		if ($this->timeout !== null) {
			$this->setTimeout($this->timeout);
		}
	}

	/**
	 * @param Host $host
	 * @param int $port
	 * 
	 * @return void
	 */
	public function bind ($host, $port) {
		$errs = Boot::deref(null);
		$errn = Boot::deref(null);
		$r = stream_socket_server(($this->protocol??'null') . "://" . ($host->host??'null') . ":" . ($port??'null'), $errn, $errs, ($this->protocol === "udp" ? STREAM_SERVER_BIND : STREAM_SERVER_BIND | STREAM_SERVER_LISTEN));
		NetSocket::checkError($r, $errn, $errs);
		$this->__s = $r;
		$this->assignHandler();
	}

	/**
	 * @return void
	 */
	public function close () {
		$this->connected = false;
		fclose($this->__s);
		$this->input->__f = null;
		$this->output->__f = null;
		$this->input->close();
		$this->output->close();
	}

	/**
	 * @param Host $host
	 * @param int $port
	 * 
	 * @return void
	 */
	public function connect ($host, $port) {
		$errs = null;
		$errn = null;
		$r = stream_socket_client(($this->protocol??'null') . "://" . ($host->host??'null') . ":" . ($port??'null'), $errn, $errs);
		NetSocket::checkError($r, $errn, $errs);
		$this->__s = $r;
		$this->assignHandler();
	}

	/**
	 * @return object
	 */
	public function host () {
		$r = stream_socket_get_name($this->__s, false);
		NetSocket::checkError($r, 0, "Unable to retrieve the host name");
		return $this->hpOfString($r);
	}

	/**
	 * @param string $s
	 * 
	 * @return object
	 */
	public function hpOfString ($s) {
		$parts = HxString::split($s, ":");
		if ($parts->length === 2) {
			$tmp = new Host(($parts->arr[0] ?? null));
			return new HxAnon([
				"host" => $tmp,
				"port" => \Std::parseInt(($parts->arr[1] ?? null)),
			]);
		} else {
			$tmp = new Host(mb_substr(($parts->arr[1] ?? null), 2, null));
			return new HxAnon([
				"host" => $tmp,
				"port" => \Std::parseInt(($parts->arr[2] ?? null)),
			]);
		}
	}

	/**
	 * @return void
	 */
	public function initSocket () {
	}

	/**
	 * @param int $connections
	 * 
	 * @return void
	 */
	public function listen ($connections) {
		throw Exception::thrown("Not implemented");
	}

	/**
	 * @return object
	 */
	public function peer () {
		$r = stream_socket_get_name($this->__s, true);
		NetSocket::checkError($r, 0, "Unable to retrieve the peer name");
		return $this->hpOfString($r);
	}

	/**
	 * @return string
	 */
	public function read () {
		$b = "";
		while (!feof($this->__s)) {
			$b = ($b??'null') . (fgets($this->__s)??'null');
		}
		return $b;
	}

	/**
	 * @param float $timeout
	 * 
	 * @return void
	 */
	public function setTimeout ($timeout) {
		if (!$this->connected) {
			$this->timeout = $timeout;
			return;
		}
		$s = (int)($timeout);
		$ms = (int)((($timeout - $s) * 1000000));
		NetSocket::checkError(stream_set_timeout($this->__s, $s, $ms), 0, "Unable to set timeout");
	}

	/**
	 * @param bool $read
	 * @param bool $write
	 * 
	 * @return void
	 */
	public function shutdown ($read, $write) {
		NetSocket::checkError(stream_socket_shutdown($this->__s, ($read && $write ? 2 : ($write ? 1 : ($read ? 0 : 2)))), 0, "Unable to Shutdown");
	}

	/**
	 * @param string $content
	 * 
	 * @return void
	 */
	public function write ($content) {
		fwrite($this->__s, $content);
	}
}

Boot::registerClass(Socket::class, 'php.net.Socket');