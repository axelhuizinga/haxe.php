<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe;

use \haxe\io\_BytesData\Container;
use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\ds\ObjectMap;
use \haxe\_Unserializer\NullResolver;
use \haxe\_Unserializer\DefaultResolver;
use \haxe\ds\IntMap;
use \haxe\ds\List_hx;
use \haxe\ds\StringMap;
use \haxe\io\Bytes;

/**
 * The `Unserializer` class is the complement to the `Serializer` class. It parses
 * a serialization `String` and creates objects from the contained data.
 * This class can be used in two ways:
 * - create a `new Unserializer()` instance with a given serialization
 * String, then call its `unserialize()` method until all values are
 * extracted
 * - call `Unserializer.run()`  to unserialize a single value from a given
 * String
 * The specification of the serialization format can be found here:
 * <https://haxe.org/manual/serialization/format>
 */
class Unserializer {
	/**
	 * @var string
	 */
	static public $BASE64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789%:";
	/**
	 * @var mixed
	 */
	static public $CODES = null;
	/**
	 * @var object
	 * This value can be set to use custom type resolvers.
	 * A type resolver finds a `Class` or `Enum` instance from a given `String`.
	 * By default, the Haxe `Type` Api is used.
	 * A type resolver must provide two methods:
	 * 1. `resolveClass(name:String):Class<Dynamic>` is called to determine a
	 * `Class` from a class name
	 * 2. `resolveEnum(name:String):Enum<Dynamic>` is called to determine an
	 * `Enum` from an enum name
	 * This value is applied when a new `Unserializer` instance is created.
	 * Changing it afterwards has no effect on previously created instances.
	 */
	static public $DEFAULT_RESOLVER;

	/**
	 * @var string
	 */
	public $buf;
	/**
	 * @var \Array_hx
	 */
	public $cache;
	/**
	 * @var int
	 */
	public $length;
	/**
	 * @var int
	 */
	public $pos;
	/**
	 * @var object
	 */
	public $resolver;
	/**
	 * @var \Array_hx
	 */
	public $scache;

	/**
	 * @return \Array_hx
	 */
	public static function initCodes () {
		$codes = new \Array_hx();
		$_g = 0;
		$_g1 = mb_strlen(Unserializer::$BASE64);
		while ($_g < $_g1) {
			$i = $_g++;
			$codes->offsetSet(\StringTools::fastCodeAt(Unserializer::$BASE64, $i), $i);
		}
		return $codes;
	}

	/**
	 * Unserializes `v` and returns the according value.
	 * This is a convenience function for creating a new instance of
	 * Unserializer with `v` as buffer and calling its `unserialize()` method
	 * once.
	 * 
	 * @param string $v
	 * 
	 * @return mixed
	 */
	public static function run ($v) {
		return (new Unserializer($v))->unserialize();
	}

	/**
	 * Creates a new Unserializer instance, with its internal buffer
	 * initialized to `buf`.
	 * This does not parse `buf` immediately. It is parsed only when calls to
	 * `this.unserialize` are made.
	 * Each Unserializer instance maintains its own cache.
	 * 
	 * @param string $buf
	 * 
	 * @return void
	 */
	public function __construct ($buf) {
		$this->buf = $buf;
		$this->length = mb_strlen($buf);
		$this->pos = 0;
		$this->scache = new \Array_hx();
		$this->cache = new \Array_hx();
		$r = Unserializer::$DEFAULT_RESOLVER;
		if ($r === null) {
			$r = new DefaultResolver();
			Unserializer::$DEFAULT_RESOLVER = $r;
		}
		$this->resolver = $r;
	}

	/**
	 * @param int $p
	 * 
	 * @return int
	 */
	public function get ($p) {
		return \StringTools::fastCodeAt($this->buf, $p);
	}

	/**
	 * Gets the type resolver of `this` Unserializer instance.
	 * See `DEFAULT_RESOLVER` for more information on type resolvers.
	 * 
	 * @return object
	 */
	public function getResolver () {
		return $this->resolver;
	}

	/**
	 * @return int
	 */
	public function readDigits () {
		$k = 0;
		$s = false;
		$fpos = $this->pos;
		while (true) {
			$c = \StringTools::fastCodeAt($this->buf, $this->pos);
			if ($c === 0) {
				break;
			}
			if ($c === 45) {
				if ($this->pos !== $fpos) {
					break;
				}
				$s = true;
				$this->pos++;
				continue;
			}
			if (($c < 48) || ($c > 57)) {
				break;
			}
			$k = $k * 10 + ($c - 48);
			$this->pos++;
		}
		if ($s) {
			$k *= -1;
		}
		return $k;
	}

	/**
	 * @return float
	 */
	public function readFloat () {
		$p1 = $this->pos;
		while (true) {
			$c = \StringTools::fastCodeAt($this->buf, $this->pos);
			if ($c === 0) {
				break;
			}
			if ((($c >= 43) && ($c < 58)) || ($c === 101) || ($c === 69)) {
				$this->pos++;
			} else {
				break;
			}
		}
		return \Std::parseFloat(mb_substr($this->buf, $p1, $this->pos - $p1));
	}

	/**
	 * Sets the type resolver of `this` Unserializer instance to `r`.
	 * If `r` is `null`, a special resolver is used which returns `null` for all
	 * input values.
	 * See `DEFAULT_RESOLVER` for more information on type resolvers.
	 * 
	 * @param object $r
	 * 
	 * @return void
	 */
	public function setResolver ($r) {
		if ($r === null) {
			if (NullResolver::$instance === null) {
				NullResolver::$instance = new NullResolver();
			}
			$this->resolver = NullResolver::$instance;
		} else {
			$this->resolver = $r;
		}
	}

	/**
	 * Unserializes the next part of `this` Unserializer instance and returns
	 * the according value.
	 * This function may call `this.resolver.resolveClass` to determine a
	 * Class from a String, and `this.resolver.resolveEnum` to determine an
	 * Enum from a String.
	 * If `this` Unserializer instance contains no more or invalid data, an
	 * exception is thrown.
	 * This operation may fail on structurally valid data if a type cannot be
	 * resolved or if a field cannot be set. This can happen when unserializing
	 * Strings that were serialized on a different Haxe target, in which the
	 * serialization side has to make sure not to include platform-specific
	 * data.
	 * Classes are created from `Type.createEmptyInstance`, which means their
	 * constructors are not called.
	 * 
	 * @return mixed
	 */
	public function unserialize () {
		$__hx__switch = (\StringTools::fastCodeAt($this->buf, $this->pos++));
		if ($__hx__switch === 65) {
			$name = $this->unserialize();
			$cl = $this->resolver->resolveClass($name);
			if ($cl === null) {
				throw Exception::thrown("Class not found " . ($name??'null'));
			}
			return $cl;
		} else if ($__hx__switch === 66) {
			$name = $this->unserialize();
			$e = $this->resolver->resolveEnum($name);
			if ($e === null) {
				throw Exception::thrown("Enum not found " . ($name??'null'));
			}
			return $e;
		} else if ($__hx__switch === 67) {
			$name = $this->unserialize();
			$cl = $this->resolver->resolveClass($name);
			if ($cl === null) {
				throw Exception::thrown("Class not found " . ($name??'null'));
			}
			$o = \Type::createEmptyInstance($cl);
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $o;
			$o->hxUnserialize($this);
			if (\StringTools::fastCodeAt($this->buf, $this->pos++) !== 103) {
				throw Exception::thrown("Invalid custom data");
			}
			return $o;
		} else if ($__hx__switch === 77) {
			$h = new ObjectMap();
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $h;
			while (\StringTools::fastCodeAt($this->buf, $this->pos) !== 104) {
				$h->set($this->unserialize(), $this->unserialize());
			}
			$this->pos++;
			return $h;
		} else if ($__hx__switch === 82) {
			$n = $this->readDigits();
			if (($n < 0) || ($n >= $this->scache->length)) {
				throw Exception::thrown("Invalid string reference");
			}
			return ($this->scache->arr[$n] ?? null);
		} else if ($__hx__switch === 97) {
			$a = new \Array_hx();
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $a;
			while (true) {
				$c = \StringTools::fastCodeAt($this->buf, $this->pos);
				if ($c === 104) {
					$this->pos++;
					break;
				}
				if ($c === 117) {
					$this->pos++;
					$n = $this->readDigits();
					$a->offsetSet($a->length + $n - 1, null);
				} else {
					$x = $this->unserialize();
					$a->arr[$a->length++] = $x;
				}
			}
			return $a;
		} else if ($__hx__switch === 98) {
			$h = new StringMap();
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $h;
			while (\StringTools::fastCodeAt($this->buf, $this->pos) !== 104) {
				$s = $this->unserialize();
				$value = $this->unserialize();
				$h->data[$s] = $value;
			}
			$this->pos++;
			return $h;
		} else if ($__hx__switch === 99) {
			$name = $this->unserialize();
			$cl = $this->resolver->resolveClass($name);
			if ($cl === null) {
				throw Exception::thrown("Class not found " . ($name??'null'));
			}
			$o = \Type::createEmptyInstance($cl);
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $o;
			$this->unserializeObject($o);
			return $o;
		} else if ($__hx__switch === 100) {
			return $this->readFloat();
		} else if ($__hx__switch === 102) {
			return false;
		} else if ($__hx__switch === 105) {
			return $this->readDigits();
		} else if ($__hx__switch === 106) {
			$name = $this->unserialize();
			$edecl = $this->resolver->resolveEnum($name);
			if ($edecl === null) {
				throw Exception::thrown("Enum not found " . ($name??'null'));
			}
			$this->pos++;
			$index = $this->readDigits();
			$tag = (\Type::getEnumConstructs($edecl)->arr[$index] ?? null);
			if ($tag === null) {
				throw Exception::thrown("Unknown enum index " . ($name??'null') . "@" . ($index??'null'));
			}
			$e = $this->unserializeEnum($edecl, $tag);
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $e;
			return $e;
		} else if ($__hx__switch === 107) {
			return \Math::$NaN;
		} else if ($__hx__switch === 108) {
			$l = new List_hx();
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $l;
			while (\StringTools::fastCodeAt($this->buf, $this->pos) !== 104) {
				$l->add($this->unserialize());
			}
			$this->pos++;
			return $l;
		} else if ($__hx__switch === 109) {
			return \Math::$NEGATIVE_INFINITY;
		} else if ($__hx__switch === 110) {
			return null;
		} else if ($__hx__switch === 111) {
			$o = new HxAnon();
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $o;
			$this->unserializeObject($o);
			return $o;
		} else if ($__hx__switch === 112) {
			return \Math::$POSITIVE_INFINITY;
		} else if ($__hx__switch === 113) {
			$h = new IntMap();
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $h;
			$c = \StringTools::fastCodeAt($this->buf, $this->pos++);
			while ($c === 58) {
				$i = $this->readDigits();
				$value = $this->unserialize();
				$h->data[$i] = $value;
				$c = \StringTools::fastCodeAt($this->buf, $this->pos++);
			}
			if ($c !== 104) {
				throw Exception::thrown("Invalid IntMap format");
			}
			return $h;
		} else if ($__hx__switch === 114) {
			$n = $this->readDigits();
			if (($n < 0) || ($n >= $this->cache->length)) {
				throw Exception::thrown("Invalid reference");
			}
			return ($this->cache->arr[$n] ?? null);
		} else if ($__hx__switch === 115) {
			$len = $this->readDigits();
			$buf = $this->buf;
			if ((\StringTools::fastCodeAt($this->buf, $this->pos++) !== 58) || (($this->length - $this->pos) < $len)) {
				throw Exception::thrown("Invalid bytes length");
			}
			$b = new Container(base64_decode(strtr(mb_substr($buf, $this->pos, $len), "%:", "+/")));
			$bytes = new Bytes(strlen($b->s), $b);
			$this->pos += $len;
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $bytes;
			return $bytes;
		} else if ($__hx__switch === 116) {
			return true;
		} else if ($__hx__switch === 118) {
			$d = null;
			if ((\StringTools::fastCodeAt($this->buf, $this->pos) >= 48) && (\StringTools::fastCodeAt($this->buf, $this->pos) <= 57) && (\StringTools::fastCodeAt($this->buf, $this->pos + 1) >= 48) && (\StringTools::fastCodeAt($this->buf, $this->pos + 1) <= 57) && (\StringTools::fastCodeAt($this->buf, $this->pos + 2) >= 48) && (\StringTools::fastCodeAt($this->buf, $this->pos + 2) <= 57) && (\StringTools::fastCodeAt($this->buf, $this->pos + 3) >= 48) && (\StringTools::fastCodeAt($this->buf, $this->pos + 3) <= 57) && (\StringTools::fastCodeAt($this->buf, $this->pos + 4) === 45)) {
				$d = \Date::fromString(mb_substr($this->buf, $this->pos, 19));
				$this->pos += 19;
			} else {
				$d = \Date::fromTime($this->readFloat());
			}
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $d;
			return $d;
		} else if ($__hx__switch === 119) {
			$name = $this->unserialize();
			$edecl = $this->resolver->resolveEnum($name);
			if ($edecl === null) {
				throw Exception::thrown("Enum not found " . ($name??'null'));
			}
			$e = $this->unserializeEnum($edecl, $this->unserialize());
			$_this = $this->cache;
			$_this->arr[$_this->length++] = $e;
			return $e;
		} else if ($__hx__switch === 120) {
			throw Exception::thrown($this->unserialize());
		} else if ($__hx__switch === 121) {
			$len = $this->readDigits();
			if ((\StringTools::fastCodeAt($this->buf, $this->pos++) !== 58) || (($this->length - $this->pos) < $len)) {
				throw Exception::thrown("Invalid string length");
			}
			$s = mb_substr($this->buf, $this->pos, $len);
			$this->pos += $len;
			$s = urldecode($s);
			$_this = $this->scache;
			$_this->arr[$_this->length++] = $s;
			return $s;
		} else if ($__hx__switch === 122) {
			return 0;
		} else {
		}
		$this->pos--;
		$index = $this->pos;
		throw Exception::thrown("Invalid char " . ((($index < 0 ? "" : mb_substr($this->buf, $index, 1)))??'null') . " at position " . ($this->pos??'null'));
	}

	/**
	 * @param Enum $edecl
	 * @param string $tag
	 * 
	 * @return mixed
	 */
	public function unserializeEnum ($edecl, $tag) {
		if (\StringTools::fastCodeAt($this->buf, $this->pos++) !== 58) {
			throw Exception::thrown("Invalid enum format");
		}
		$nargs = $this->readDigits();
		if ($nargs === 0) {
			return \Type::createEnum($edecl, $tag);
		}
		$args = new \Array_hx();
		while ($nargs-- > 0) {
			$x = $this->unserialize();
			$args->arr[$args->length++] = $x;
		}
		return \Type::createEnum($edecl, $tag, $args);
	}

	/**
	 * @param object $o
	 * 
	 * @return void
	 */
	public function unserializeObject ($o) {
		while (true) {
			if ($this->pos >= $this->length) {
				throw Exception::thrown("Invalid object");
			}
			if (\StringTools::fastCodeAt($this->buf, $this->pos) === 103) {
				break;
			}
			$k = $this->unserialize();
			if (!is_string($k)) {
				throw Exception::thrown("Invalid object key");
			}
			\Reflect::setField($o, $k, $this->unserialize());
		}
		$this->pos++;
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


		self::$DEFAULT_RESOLVER = new DefaultResolver();
	}
}

Boot::registerClass(Unserializer::class, 'haxe.Unserializer');
Unserializer::__hx__init();
