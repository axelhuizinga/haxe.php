<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\io;

use \php\Boot;
use \haxe\Exception;

class BufferInput extends Input {
	/**
	 * @var int
	 */
	public $available;
	/**
	 * @var Bytes
	 */
	public $buf;
	/**
	 * @var Input
	 */
	public $i;
	/**
	 * @var int
	 */
	public $pos;

	/**
	 * @param Input $i
	 * @param Bytes $buf
	 * @param int $pos
	 * @param int $available
	 * 
	 * @return void
	 */
	public function __construct ($i, $buf, $pos = 0, $available = 0) {
		if ($pos === null) {
			$pos = 0;
		}
		if ($available === null) {
			$available = 0;
		}
		$this->i = $i;
		$this->buf = $buf;
		$this->pos = $pos;
		$this->available = $available;
	}

	/**
	 * @return int
	 */
	public function readByte () {
		if ($this->available === 0) {
			$this->refill();
		}
		$c = \ord($this->buf->b->s[$this->pos]);
		$this->pos++;
		$this->available--;
		return $c;
	}

	/**
	 * @param Bytes $buf
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return int
	 */
	public function readBytes ($buf, $pos, $len) {
		if ($this->available === 0) {
			$this->refill();
		}
		$size = ($len > $this->available ? $this->available : $len);
		$src = $this->buf;
		$srcpos = $this->pos;
		if (($pos < 0) || ($srcpos < 0) || ($size < 0) || (($pos + $size) > $buf->length) || (($srcpos + $size) > $src->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			$this1 = $buf->b;
			$src1 = $src->b;
			$this1->s = ((\substr($this1->s, 0, $pos) . \substr($src1->s, $srcpos, $size)) . \substr($this1->s, $pos + $size));
		}
		$this->pos += $size;
		$this->available -= $size;
		return $size;
	}

	/**
	 * @return void
	 */
	public function refill () {
		if ($this->pos > 0) {
			$_this = $this->buf;
			$src = $this->buf;
			$srcpos = $this->pos;
			$len = $this->available;
			if (($srcpos < 0) || ($len < 0) || ($len > $_this->length) || (($srcpos + $len) > $src->length)) {
				throw Exception::thrown(Error::OutsideBounds());
			} else {
				$this1 = $_this->b;
				$src1 = $src->b;
				$this1->s = ((\substr($this1->s, 0, 0) . \substr($src1->s, $srcpos, $len)) . \substr($this1->s, $len));
			}
			$this->pos = 0;
		}
		$tmp = $this;
		$tmp->available = $tmp->available + $this->i->readBytes($this->buf, $this->available, $this->buf->length - $this->available);
	}
}

Boot::registerClass(BufferInput::class, 'haxe.io.BufferInput');
