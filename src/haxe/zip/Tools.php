<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\zip;

use \haxe\io\_BytesData\Container;
use \php\Boot;
use \haxe\Exception;
use \haxe\io\Error;
use \haxe\io\Bytes;

class Tools {
	/**
	 * @param object $f
	 * @param int $level
	 * 
	 * @return void
	 */
	public static function compress ($f, $level) {
		if ($f->compressed) {
			return;
		}
		$data = Compress::run($f->data, $level);
		$f->compressed = true;
		$len = $data->length - 6;
		$tmp = null;
		if (($len < 0) || ((2 + $len) > $data->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			$tmp = new Bytes($len, new Container(\substr($data->b->s, 2, $len)));
		}
		$f->data = $tmp;
		$f->dataSize = $f->data->length;
	}

	/**
	 * @param object $f
	 * 
	 * @return void
	 */
	public static function uncompress ($f) {
		if (!$f->compressed) {
			return;
		}
		$c = new Uncompress(-15);
		$s = Bytes::alloc($f->fileSize);
		$r = $c->execute($f->data, 0, $s, 0);
		$c->close();
		if (!$r->done || ($r->read !== $f->data->length) || ($r->write !== $f->fileSize)) {
			throw Exception::thrown("Invalid compressed data for " . ($f->fileName??'null'));
		}
		$f->compressed = false;
		$f->dataSize = $f->fileSize;
		$f->data = $s;
	}
}

Boot::registerClass(Tools::class, 'haxe.zip.Tools');
