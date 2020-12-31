<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\chunk;

use \php\Boot;
use \haxe\io\Bytes;
use \tink\_Chunk\Chunk_Impl_;

class CompoundChunk extends ChunkBase implements ChunkObject {
	/**
	 * @var \Array_hx
	 */
	public $chunks;
	/**
	 * @var int
	 */
	public $depth;
	/**
	 * @var int
	 */
	public $length;
	/**
	 * @var \Array_hx
	 */
	public $offsets;

	/**
	 * @param ChunkObject $c
	 * 
	 * @return CompoundChunk
	 */
	public static function asCompound ($c) {
		if (($c instanceof CompoundChunk)) {
			return $c;
		} else {
			return null;
		}
	}

	/**
	 * @param ChunkObject $a
	 * @param ChunkObject $b
	 * 
	 * @return ChunkObject
	 */
	public static function cons ($a, $b) {
		$_g = $b->getLength();
		if ($a->getLength() === 0) {
			if ($_g === 0) {
				return Chunk_Impl_::$EMPTY;
			} else {
				return $b;
			}
		} else if ($_g === 0) {
			return $a;
		} else {
			$_g = CompoundChunk::asCompound($b);
			$_g1 = CompoundChunk::asCompound($a);
			if ($_g1 === null) {
				if ($_g === null) {
					return CompoundChunk::create(\Array_hx::wrap([
						$a,
						$b,
					]), 2);
				} else if ($_g->depth < 100) {
					return CompoundChunk::create(\Array_hx::wrap([
						$a,
						$b,
					]), $_g->depth + 1);
				} else {
					$flat = new \Array_hx();
					$_g->flatten($flat);
					$b->flatten($flat);
					return CompoundChunk::create($flat, 2);
				}
			} else if ($_g === null) {
				if ($_g1->depth < 100) {
					return CompoundChunk::create(\Array_hx::wrap([
						$a,
						$b,
					]), $_g1->depth + 1);
				} else {
					$flat = new \Array_hx();
					$_g1->flatten($flat);
					$b->flatten($flat);
					return CompoundChunk::create($flat, 2);
				}
			} else {
				$depth = ($_g1->depth > $_g->depth ? $_g1->depth : $_g->depth);
				return CompoundChunk::create($_g1->chunks->concat($_g->chunks), $depth);
			}
		}
	}

	/**
	 * @param \Array_hx $chunks
	 * @param int $depth
	 * 
	 * @return CompoundChunk
	 */
	public static function create ($chunks, $depth) {
		$ret = new CompoundChunk();
		$offsets = \Array_hx::wrap([0]);
		$length = 0;
		$_g = 0;
		while ($_g < $chunks->length) {
			$x = $length += ($chunks->arr[$_g++] ?? null)->getLength();
			$offsets->arr[$offsets->length++] = $x;
		}
		$ret->chunks = $chunks;
		$ret->offsets = $offsets;
		$ret->length = $length;
		$ret->depth = $depth;
		return $ret;
	}

	/**
	 * @return void
	 */
	public function __construct () {
	}

	/**
	 * @param Bytes $target
	 * @param int $offset
	 * 
	 * @return void
	 */
	public function blitTo ($target, $offset) {
		$_g = 0;
		$_g1 = $this->chunks->length;
		while ($_g < $_g1) {
			$i = $_g++;
			($this->chunks->arr[$i] ?? null)->blitTo($target, $offset + ($this->offsets->arr[$i] ?? null));
		}
	}

	/**
	 * @param int $target
	 * 
	 * @return int
	 */
	public function findChunk ($target) {
		$min = 0;
		$max = $this->offsets->length - 1;
		while (($min + 1) < $max) {
			$guess = ($min + $max) >> 1;
			if (($this->offsets->arr[$guess] ?? null) > $target) {
				$max = $guess;
			} else {
				$min = $guess;
			}
		}
		return $min;
	}

	/**
	 * @param \Array_hx $into
	 * 
	 * @return void
	 */
	public function flatten ($into) {
		$_g = 0;
		$_g1 = $this->chunks;
		while ($_g < $_g1->length) {
			($_g1->arr[$_g++] ?? null)->flatten($into);
		}
	}

	/**
	 * @param int $i
	 * 
	 * @return int
	 */
	public function getByte ($i) {
		$index = $this->findChunk($i);
		return ($this->chunks->arr[$index] ?? null)->getByte($i - ($this->offsets->arr[$index] ?? null));
	}

	/**
	 * @return int
	 */
	public function getLength () {
		return $this->length;
	}

	/**
	 * @param int $from
	 * @param int $to
	 * 
	 * @return ChunkObject
	 */
	public function slice ($from, $to) {
		$idxFrom = $this->findChunk($from);
		$idxTo = $this->findChunk($to);
		if ($idxFrom === $idxTo) {
			$offset = ($this->offsets->arr[$idxFrom] ?? null);
			return ($this->chunks->arr[$idxFrom] ?? null)->slice($from - $offset, $to - $offset);
		}
		$ret = $this->chunks->slice($idxFrom, $idxTo + 1);
		$ret->offsetSet(0, ($ret->arr[0] ?? null)->slice($from - ($this->offsets->arr[$idxFrom] ?? null), ($this->offsets->arr[$idxFrom + 1] ?? null)));
		$ret->offsetSet($ret->length - 1, ($ret->arr[$ret->length - 1] ?? null)->slice(0, $to - ($this->offsets->arr[$idxTo] ?? null)));
		return CompoundChunk::create($ret, $this->depth);
	}

	/**
	 * @return Bytes
	 */
	public function toBytes () {
		$ret = Bytes::alloc($this->length);
		$this->blitTo($ret, 0);
		return $ret;
	}

	/**
	 * @return string
	 */
	public function toString () {
		return $this->toBytes()->toString();
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(CompoundChunk::class, 'tink.chunk.CompoundChunk');
