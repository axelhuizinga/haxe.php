<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe;

use \php\Boot;
use \haxe\ds\ObjectMap;
use \haxe\ds\IntMap;
use \haxe\ds\List_hx;
use \haxe\ds\StringMap;
use \haxe\io\Bytes;

/**
 * The Serializer class can be used to encode values and objects into a `String`,
 * from which the `Unserializer` class can recreate the original representation.
 * This class can be used in two ways:
 * - create a `new Serializer()` instance, call its `serialize()` method with
 * any argument and finally retrieve the String representation from
 * `toString()`
 * - call `Serializer.run()` to obtain the serialized representation of a
 * single argument
 * Serialization is guaranteed to work for all haxe-defined classes, but may
 * or may not work for instances of external/native classes.
 * The specification of the serialization format can be found here:
 * <https://haxe.org/manual/std-serialization-format.html>
 */
class Serializer {
	/**
	 * @var string
	 */
	static public $BASE64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789%:";
	/**
	 * @var mixed
	 */
	static public $BASE64_CODES = null;
	/**
	 * @var bool
	 * If the values you are serializing can contain circular references or
	 * objects repetitions, you should set `USE_CACHE` to true to prevent
	 * infinite loops.
	 * This may also reduce the size of serialization Strings at the expense of
	 * performance.
	 * This value can be changed for individual instances of `Serializer` by
	 * setting their `useCache` field.
	 */
	static public $USE_CACHE = false;
	/**
	 * @var bool
	 * Use constructor indexes for enums instead of names.
	 * This may reduce the size of serialization Strings, but makes them less
	 * suited for long-term storage: If constructors are removed or added from
	 * the enum, the indices may no longer match.
	 * This value can be changed for individual instances of `Serializer` by
	 * setting their `useEnumIndex` field.
	 */
	static public $USE_ENUM_INDEX = false;

	/**
	 * @var \StringBuf
	 */
	public $buf;
	/**
	 * @var \Array_hx
	 */
	public $cache;
	/**
	 * @var int
	 */
	public $scount;
	/**
	 * @var StringMap
	 */
	public $shash;
	/**
	 * @var bool
	 * The individual cache setting for `this` Serializer instance.
	 * See `USE_CACHE` for a complete description.
	 */
	public $useCache;
	/**
	 * @var bool
	 * The individual enum index setting for `this` Serializer instance.
	 * See `USE_ENUM_INDEX` for a complete description.
	 */
	public $useEnumIndex;

	/**
	 * Serializes `v` and returns the String representation.
	 * This is a convenience function for creating a new instance of
	 * Serializer, serialize `v` into it and obtain the result through a call
	 * to `toString()`.
	 * 
	 * @param mixed $v
	 * 
	 * @return string
	 */
	public static function run ($v) {
		$s = new Serializer();
		$s->serialize($v);
		return $s->toString();
	}

	/**
	 * Creates a new Serializer instance.
	 * Subsequent calls to `this.serialize` will append values to the
	 * internal buffer of this String. Once complete, the contents can be
	 * retrieved through a call to `this.toString`.
	 * Each `Serializer` instance maintains its own cache if `this.useCache` is
	 * `true`.
	 * 
	 * @return void
	 */
	public function __construct () {
		$this->buf = new \StringBuf();
		$this->cache = new \Array_hx();
		$this->useCache = Serializer::$USE_CACHE;
		$this->useEnumIndex = Serializer::$USE_ENUM_INDEX;
		$this->shash = new StringMap();
		$this->scount = 0;
	}

	/**
	 * Serializes `v`.
	 * All haxe-defined values and objects with the exception of functions can
	 * be serialized. Serialization of external/native objects is not
	 * guaranteed to work.
	 * The values of `this.useCache` and `this.useEnumIndex` may affect
	 * serialization output.
	 * 
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public function serialize ($v) {
		$_g = \Type::typeof($v);
		$__hx__switch = ($_g->index);
		if ($__hx__switch === 0) {
			$this->buf->add("n");
		} else if ($__hx__switch === 1) {
			$v1 = $v;
			if ($v1 === 0) {
				$this->buf->add("z");
				return;
			}
			$this->buf->add("i");
			$this->buf->add($v1);
		} else if ($__hx__switch === 2) {
			$v1 = $v;
			if (is_nan($v1)) {
				$this->buf->add("k");
			} else if (!is_finite($v1)) {
				$this->buf->add(($v1 < 0 ? "m" : "p"));
			} else {
				$this->buf->add("d");
				$this->buf->add($v1);
			}
		} else if ($__hx__switch === 3) {
			$this->buf->add(($v ? "t" : "f"));
		} else if ($__hx__switch === 4) {
			if (Boot::isOfType($v, Boot::getClass('Class'))) {
				$className = \Type::getClassName($v);
				$this->buf->add("A");
				$this->serializeString($className);
			} else if (Boot::isOfType($v, Boot::getClass('Enum'))) {
				$this->buf->add("B");
				$this->serializeString(\Type::getEnumName($v));
			} else {
				if ($this->useCache && $this->serializeRef($v)) {
					return;
				}
				$this->buf->add("o");
				$this->serializeFields($v);
			}
		} else if ($__hx__switch === 5) {
			throw Exception::thrown("Cannot serialize function");
		} else if ($__hx__switch === 6) {
			$_g1 = $_g->params[0];
			if ($_g1 === Boot::getClass('String')) {
				$this->serializeString($v);
				return;
			}
			if ($this->useCache && $this->serializeRef($v)) {
				return;
			}
			if ($_g1 === Boot::getClass(\Array_hx::class)) {
				$ucount = 0;
				$this->buf->add("a");
				$l = Boot::dynamicField($v, 'length');
				$_g2 = 0;
				while ($_g2 < $l) {
					$i = $_g2++;
					if ($v[$i] === null) {
						++$ucount;
					} else {
						if ($ucount > 0) {
							if ($ucount === 1) {
								$this->buf->add("n");
							} else {
								$this->buf->add("u");
								$this->buf->add($ucount);
							}
							$ucount = 0;
						}
						$this->serialize($v[$i]);
					}
				}
				if ($ucount > 0) {
					if ($ucount === 1) {
						$this->buf->add("n");
					} else {
						$this->buf->add("u");
						$this->buf->add($ucount);
					}
				}
				$this->buf->add("h");
			} else if ($_g1 === Boot::getClass(\Date::class)) {
				$this->buf->add("v");
				$this->buf->add($v->getTime());
			} else if ($_g1 === Boot::getClass(IntMap::class)) {
				$this->buf->add("q");
				$v1 = $v;
				$data = array_keys($v1->data);
				$_g_current = 0;
				$_g_length = count($data);
				while ($_g_current < $_g_length) {
					$k = $data[$_g_current++];
					$this->buf->add(":");
					$this->buf->add($k);
					$this->serialize(($v1->data[$k] ?? null));
				}
				$this->buf->add("h");
			} else if ($_g1 === Boot::getClass(List_hx::class)) {
				$this->buf->add("l");
				$_g_head = $v->h;
				while ($_g_head !== null) {
					$val = $_g_head->item;
					$_g_head = $_g_head->next;
					$this->serialize($val);
				}
				$this->buf->add("h");
			} else if ($_g1 === Boot::getClass(ObjectMap::class)) {
				$this->buf->add("M");
				$v1 = $v;
				$data = array_values($v1->_keys);
				$_g_current = 0;
				$_g_length = count($data);
				while ($_g_current < $_g_length) {
					$k = $data[$_g_current++];
					$this->serialize($k);
					$this->serialize($v1->get($k));
				}
				$this->buf->add("h");
			} else if ($_g1 === Boot::getClass(StringMap::class)) {
				$this->buf->add("b");
				$v1 = $v;
				$data = array_values(array_map("strval", array_keys($v1->data)));
				$_g_current = 0;
				$_g_length = count($data);
				while ($_g_current < $_g_length) {
					$k = $data[$_g_current++];
					$this->serializeString($k);
					$this->serialize(($v1->data[$k] ?? null));
				}
				$this->buf->add("h");
			} else if ($_g1 === Boot::getClass(Bytes::class)) {
				$chars = base64_encode($v->b->s);
				$chars = strtr($chars, "+/", "%:");
				$this->buf->add("s");
				$this->buf->add(mb_strlen($chars));
				$this->buf->add(":");
				$this->buf->add($chars);
			} else {
				if ($this->useCache) {
					$_this = $this->cache;
					if ($_this->length > 0) {
						$_this->length--;
					}
					array_pop($_this->arr);
				}
				if (method_exists($v, "hxSerialize")) {
					$this->buf->add("C");
					$this->serializeString(\Type::getClassName($_g1));
					if ($this->useCache) {
						$_this = $this->cache;
						$_this->arr[$_this->length++] = $v;
					}
					$v->hxSerialize($this);
					$this->buf->add("g");
				} else {
					$this->buf->add("c");
					$this->serializeString(\Type::getClassName($_g1));
					if ($this->useCache) {
						$_this = $this->cache;
						$_this->arr[$_this->length++] = $v;
					}
					$this->serializeFields($v);
				}
			}
		} else if ($__hx__switch === 7) {
			if ($this->useCache) {
				if ($this->serializeRef($v)) {
					return;
				}
				$_this = $this->cache;
				if ($_this->length > 0) {
					$_this->length--;
				}
				array_pop($_this->arr);
			}
			$this->buf->add(($this->useEnumIndex ? "j" : "w"));
			$this->serializeString(\Type::getEnumName($_g->params[0]));
			if ($this->useEnumIndex) {
				$this->buf->add(":");
				$this->buf->add(Boot::dynamicField($v, 'index'));
			} else {
				$this->serializeString(Boot::dynamicField($v, 'tag'));
			}
			$this->buf->add(":");
			$l = count(Boot::dynamicField($v, 'params'));
			if (($l === 0) || (Boot::dynamicField($v, 'params') === null)) {
				$this->buf->add(0);
			} else {
				$this->buf->add($l);
				$_g = 0;
				while ($_g < $l) {
					$this->serialize(Boot::dynamicField($v, 'params')[$_g++]);
				}
			}
			if ($this->useCache) {
				$_this = $this->cache;
				$_this->arr[$_this->length++] = $v;
			}
		} else {
			throw Exception::thrown("Cannot serialize " . (\Std::string($v)??'null'));
		}
	}

	/**
	 * @param mixed $e
	 * 
	 * @return void
	 */
	public function serializeException ($e) {
		$this->buf->add("x");
		$this->serialize($e);
	}

	/**
	 * @param object $v
	 * 
	 * @return void
	 */
	public function serializeFields ($v) {
		$_g = 0;
		$_g1 = \Reflect::fields($v);
		while ($_g < $_g1->length) {
			$f = ($_g1->arr[$_g] ?? null);
			++$_g;
			$this->serializeString($f);
			$this->serialize(\Reflect::field($v, $f));
		}
		$this->buf->add("g");
	}

	/**
	 * @param mixed $v
	 * 
	 * @return bool
	 */
	public function serializeRef ($v) {
		$_g = 0;
		$_g1 = $this->cache->length;
		while ($_g < $_g1) {
			$i = $_g++;
			if (Boot::equal(($this->cache->arr[$i] ?? null), $v)) {
				$this->buf->add("r");
				$this->buf->add($i);
				return true;
			}
		}
		$_this = $this->cache;
		$_this->arr[$_this->length++] = $v;
		return false;
	}

	/**
	 * @param string $s
	 * 
	 * @return void
	 */
	public function serializeString ($s) {
		$x = ($this->shash->data[$s] ?? null);
		if ($x !== null) {
			$this->buf->add("R");
			$this->buf->add($x);
			return;
		}
		$this->shash->data[$s] = $this->scount++;
		$this->buf->add("y");
		$s = rawurlencode($s);
		$this->buf->add(mb_strlen($s));
		$this->buf->add(":");
		$this->buf->add($s);
	}

	/**
	 * Return the String representation of `this` Serializer.
	 * The exact format specification can be found here:
	 * https://haxe.org/manual/serialization/format
	 * 
	 * @return string
	 */
	public function toString () {
		return $this->buf->b;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Serializer::class, 'haxe.Serializer');
