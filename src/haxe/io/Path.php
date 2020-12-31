<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\io;

use \php\Boot;
use \php\_Boot\HxString;

/**
 * This class provides a convenient way of working with paths. It supports the
 * common path formats:
 * - `directory1/directory2/filename.extension`
 * - `directory1\directory2\filename.extension`
 */
class Path {
	/**
	 * @var bool
	 * `true` if the last directory separator is a backslash, `false` otherwise.
	 */
	public $backslash;
	/**
	 * @var string
	 * The directory.
	 * This is the leading part of the path that is not part of the file name
	 * and the extension.
	 * Does not end with a `/` or `\` separator.
	 * If the path has no directory, the value is `null`.
	 */
	public $dir;
	/**
	 * @var string
	 * The file extension.
	 * It is separated from the file name by a dot. This dot is not part of
	 * the extension.
	 * If the path has no extension, the value is `null`.
	 */
	public $ext;
	/**
	 * @var string
	 * The file name.
	 * This is the part of the part between the directory and the extension.
	 * If there is no file name, e.g. for `".htaccess"` or `"/dir/"`, the value
	 * is the empty String `""`.
	 */
	public $file;

	/**
	 * Adds a trailing slash to `path`, if it does not have one already.
	 * If the last slash in `path` is a backslash, a backslash is appended to
	 * `path`.
	 * If the last slash in `path` is a slash, or if no slash is found, a slash
	 * is appended to `path`. In particular, this applies to the empty String
	 * `""`.
	 * If `path` is `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function addTrailingSlash ($path) {
		if (mb_strlen($path) === 0) {
			return "/";
		}
		$c1 = HxString::lastIndexOf($path, "/");
		$c2 = HxString::lastIndexOf($path, "\\");
		if ($c1 < $c2) {
			if ($c2 !== (mb_strlen($path) - 1)) {
				return ($path??'null') . "\\";
			} else {
				return $path;
			}
		} else if ($c1 !== (mb_strlen($path) - 1)) {
			return ($path??'null') . "/";
		} else {
			return $path;
		}
	}

	/**
	 * Returns the directory of `path`.
	 * If the directory is `null`, the empty String `""` is returned.
	 * If `path` is `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function directory ($path) {
		$s = new Path($path);
		if ($s->dir === null) {
			return "";
		}
		return $s->dir;
	}

	/**
	 * @param string $path
	 * @param bool $allowSlashes
	 * 
	 * @return string
	 */
	public static function escape ($path, $allowSlashes = false) {
		if ($allowSlashes === null) {
			$allowSlashes = false;
		}
		return Boot::deref((($allowSlashes ? new \EReg("[^A-Za-z0-9_/\\\\\\.]", "g") : new \EReg("[^A-Za-z0-9_\\.]", "g"))))->map($path, function ($v) {
			return "-x" . (HxString::charCodeAt($v->matched(0), 0)??'null');
		});
	}

	/**
	 * Returns the extension of `path`.
	 * If `path` has no extension, the empty String `""` is returned.
	 * If `path` is `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function extension ($path) {
		$s = new Path($path);
		if ($s->ext === null) {
			return "";
		}
		return $s->ext;
	}

	/**
	 * Returns `true` if the path is an absolute path, and `false` otherwise.
	 * 
	 * @param string $path
	 * 
	 * @return bool
	 */
	public static function isAbsolute ($path) {
		if (\StringTools::startsWith($path, "/")) {
			return true;
		}
		if (\mb_substr($path, 1, 1) === ":") {
			return true;
		}
		if (\StringTools::startsWith($path, "\\\\")) {
			return true;
		}
		return false;
	}

	/**
	 * Joins all paths in `paths` together.
	 * If `paths` is empty, the empty String `""` is returned. Otherwise the
	 * paths are joined with a slash between them.
	 * If `paths` is `null`, the result is unspecified.
	 * 
	 * @param \Array_hx $paths
	 * 
	 * @return string
	 */
	public static function join ($paths) {
		$result = [];
		$data = $paths->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		while ($_g_current < $_g_length) {
			$item = $data[$_g_current++];
			if (($item !== null) && ($item !== "")) {
				$result[] = $item;
			}
		}
		$paths = \Array_hx::wrap($result);
		if ($paths->length === 0) {
			return "";
		}
		$path = ($paths->arr[0] ?? null);
		$_g = 1;
		$_g1 = $paths->length;
		while ($_g < $_g1) {
			$path = Path::addTrailingSlash($path);
			$path = ($path??'null') . (($paths->arr[$_g++] ?? null)??'null');
		}
		return Path::normalize($path);
	}

	/**
	 * Normalize a given `path` (e.g. turn `'/usr/local/../lib'` into `'/usr/lib'`).
	 * Also replaces backslashes `\` with slashes `/` and afterwards turns
	 * multiple slashes into a single one.
	 * If `path` is `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function normalize ($path) {
		$path = HxString::split($path, "\\")->join("/");
		if ($path === "/") {
			return "/";
		}
		$target = new \Array_hx();
		$_g = 0;
		$_g1 = HxString::split($path, "/");
		while ($_g < $_g1->length) {
			$token = ($_g1->arr[$_g] ?? null);
			++$_g;
			if (($token === "..") && ($target->length > 0) && (($target->arr[$target->length - 1] ?? null) !== "..")) {
				if ($target->length > 0) {
					$target->length--;
				}
				\array_pop($target->arr);
			} else if ($token === "") {
				if (($target->length > 0) || (HxString::charCodeAt($path, 0) === 47)) {
					$target->arr[$target->length++] = $token;
				}
			} else if ($token !== ".") {
				$target->arr[$target->length++] = $token;
			}
		}
		$tmp = $target->join("/");
		$acc = new \StringBuf();
		$colon = false;
		$slashes = false;
		$_g = 0;
		$_g1 = mb_strlen($tmp);
		while ($_g < $_g1) {
			$_g2 = \StringTools::fastCodeAt($tmp, $_g++);
			if ($_g2 === 47) {
				if (!$colon) {
					$slashes = true;
				} else {
					$colon = false;
					if ($slashes) {
						$acc->add("/");
						$slashes = false;
					}
					$acc->b = ($acc->b??'null') . (\mb_chr($_g2)??'null');
				}
			} else if ($_g2 === 58) {
				$acc->add(":");
				$colon = true;
			} else {
				$colon = false;
				if ($slashes) {
					$acc->add("/");
					$slashes = false;
				}
				$acc->b = ($acc->b??'null') . (\mb_chr($_g2)??'null');
			}
		}
		return $acc->b;
	}

	/**
	 * Removes trailing slashes from `path`.
	 * If `path` does not end with a `/` or `\`, `path` is returned unchanged.
	 * Otherwise the substring of `path` excluding the trailing slashes or
	 * backslashes is returned.
	 * If `path` is `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function removeTrailingSlashes ($path) {
		while (true) {
			$_g = HxString::charCodeAt($path, mb_strlen($path) - 1);
			if ($_g === null) {
				break;
			} else {
				if ($_g === 47 || $_g === 92) {
					$path = \mb_substr($path, 0, -1);
				} else {
					break;
				}
			}
		};
		return $path;
	}

	/**
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function unescape ($path) {
		return (new \EReg("-x([0-9][0-9])", "g"))->map($path, function ($regex) {
			return \mb_chr(\Std::parseInt($regex->matched(1)));
		});
	}

	/**
	 * Returns a String representation of `path` where the extension is `ext`.
	 * If `path` has no extension, `ext` is added as extension.
	 * If `path` or `ext` are `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * @param string $ext
	 * 
	 * @return string
	 */
	public static function withExtension ($path, $ext) {
		$s = new Path($path);
		$s->ext = $ext;
		return $s->toString();
	}

	/**
	 * Returns the String representation of `path` without the directory.
	 * If `path` is `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function withoutDirectory ($path) {
		$s = new Path($path);
		$s->dir = null;
		return $s->toString();
	}

	/**
	 * Returns the String representation of `path` without the file extension.
	 * If `path` is `null`, the result is unspecified.
	 * 
	 * @param string $path
	 * 
	 * @return string
	 */
	public static function withoutExtension ($path) {
		$s = new Path($path);
		$s->ext = null;
		return $s->toString();
	}

	/**
	 * Creates a new `Path` instance by parsing `path`.
	 * Path information can be retrieved by accessing the `dir`, `file` and `ext`
	 * properties.
	 * 
	 * @param string $path
	 * 
	 * @return void
	 */
	public function __construct ($path) {
		if ($path === "." || $path === "..") {
			$this->dir = $path;
			$this->file = "";
			return;
		}
		$c1 = HxString::lastIndexOf($path, "/");
		$c2 = HxString::lastIndexOf($path, "\\");
		if ($c1 < $c2) {
			$this->dir = \mb_substr($path, 0, $c2);
			$path = \mb_substr($path, $c2 + 1, null);
			$this->backslash = true;
		} else if ($c2 < $c1) {
			$this->dir = \mb_substr($path, 0, $c1);
			$path = \mb_substr($path, $c1 + 1, null);
		} else {
			$this->dir = null;
		}
		$cp = HxString::lastIndexOf($path, ".");
		if ($cp !== -1) {
			$this->ext = \mb_substr($path, $cp + 1, null);
			$this->file = \mb_substr($path, 0, $cp);
		} else {
			$this->ext = null;
			$this->file = $path;
		}
	}

	/**
	 * Returns a String representation of `this` path.
	 * If `this.backslash` is `true`, backslash is used as directory separator,
	 * otherwise slash is used. This only affects the separator between
	 * `this.dir` and `this.file`.
	 * If `this.directory` or `this.extension` is `null`, their representation
	 * is the empty String `""`.
	 * 
	 * @return string
	 */
	public function toString () {
		return ((($this->dir === null ? "" : ($this->dir??'null') . ((($this->backslash ? "\\" : "/"))??'null')))??'null') . ($this->file??'null') . ((($this->ext === null ? "" : "." . ($this->ext??'null')))??'null');
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Path::class, 'haxe.io.Path');
