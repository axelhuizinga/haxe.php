import haxe.*;
import sys.*;
import sys.io.*;

using Lambda;
using StringTools;

/** The main class. **/
@:keep class Main {
	public var array: Array<Any> = null;
	public var boolean: Bool = false;
	public var date: Date = null;
	public var ereg: EReg = ~/.*/;
	public var integer: Int = 0;
	public var number: Float = 0.0;
	public var string: String = "";

	/** Application entry point. **/
	static function main(): Void {
		Math.abs(-1);
		Reflect.hasField({}, "foo");
		Std.isOfType("", String);
		Sys.exit(0);
	}
}
