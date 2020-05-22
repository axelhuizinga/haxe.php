import haxe.*;
import haxe.ds.*;
import sys.*;
import sys.io.*;
import sys.net.*;

// Root package.
using DateTools;
using Lambda;
using StringTools;

// "haxe" package.
using haxe.EnumTools;

/** The main class. **/
@:keep class Main {

	// Root package.
	var array: Array<Any> = null;
	var boolean: Bool = false;
	var date: Date = null;
	var ereg: EReg = ~/.*/;
	var integer: Int = 0;
	var number: Float = 0.0;
	var string: String = "";
	var stringBuffer: StringBuf = null;
	var unsignedInteger: UInt = 0;
	var unicodeString: UnicodeString = "";
	var xml: Xml = null;

	// "haxe" package.
	var exception: Exception = null;
	var serializer: Serializer = null;
	var template: Template = null;
	var timer: Timer = null;
	var unserializer: Unserializer = null;
	var valueException: ValueException = null;

	// "haxe.ds" package.
	var either: Either<Any, Any> = Left(0);
	var genericStack: GenericStack<Any> = null;
	var intMap: IntMap<Any> = null;
	var list: List<Any> = null;
	var objectMap: ObjectMap<String, Any> = null;
	var option: Option<Any> = Some(0);
	var stringMap: StringMap<Any> = null;
	var vector: Vector<Any> = null;
	var weakMap: WeakMap<String, Any> = null;

	// "sys" package.
	var http: Http = null;

	// "sys.io" package.
	var process: Process = null;

	// "sys.net" package.
	var address: Address = null;
	var host: Host = null;

	/** Application entry point. **/
	static function main(): Void {
		// Root package.
		Math.abs(-1);
		Reflect.hasField({}, "foo");
		Std.isOfType("", String);
		Sys.exit(0);

		// "haxe" package.
		Json.stringify(123);
		Resource.listNames();
		SysTools.quoteUnixArg("foo");

		// "sys" package.
		FileSystem.exists("build.hxml");

		// "sys.io" package.
		File.getContent("build.hxml");
	}
}
