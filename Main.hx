import haxe.*;
import sys.*;
import sys.io.*;

using DateTools;
using Lambda;
using StringTools;

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

	// sys.io package.
	var process: Process = null;

	/** Application entry point. **/
	static function main(): Void {
		// Root package.
		Math.abs(-1);
		Reflect.hasField({}, "foo");
		Std.isOfType("", String);
		Sys.exit(0);

		// sys.io package.
		File.getContent("build.hxml");
	}
}
