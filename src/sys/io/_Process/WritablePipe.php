<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace sys\io\_Process;

use \php\Boot;
use \haxe\Exception;
use \haxe\io\Output;
use \haxe\io\Eof;
use \haxe\io\Error;
use \haxe\io\Bytes;

class WritablePipe extends Output {
	/**
	 * @var mixed
	 */
	public $pipe;
	/**
	 * @var Bytes
	 */
	public $tmpBytes;

	/**
	 * @param mixed $pipe
	 * 
	 * @return void
	 */
	public function __construct ($pipe) {
		$this->pipe = $pipe;
		$this->tmpBytes = Bytes::alloc(1);
	}

	/**
	 * @return void
	 */
	public function close () {
		fclose($this->pipe);
	}

	/**
	 * @param int $c
	 * 
	 * @return void
	 */
	public function writeByte ($c) {
		$this->tmpBytes->b->s[0] = chr($c);
		$this->writeBytes($this->tmpBytes, 0, 1);
	}

	/**
	 * @param Bytes $b
	 * @param int $pos
	 * @param int $l
	 * 
	 * @return int
	 */
	public function writeBytes ($b, $pos, $l) {
		$s = null;
		if (($pos < 0) || ($l < 0) || (($pos + $l) > $b->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			$s = substr($b->b->s, $pos, $l);
		}
		if (feof($this->pipe)) {
			throw Exception::thrown(new Eof());
		}
		$result = fwrite($this->pipe, $s, $l);
		if ($result === false) {
			throw Exception::thrown(Error::Custom("Failed to write to process input"));
		}
		return $result;
	}
}

Boot::registerClass(WritablePipe::class, 'sys.io._Process.WritablePipe');