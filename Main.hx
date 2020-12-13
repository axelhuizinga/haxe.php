import asys.*;
import asys.io.*;
import asys.net.*;
import tink.*;
import tink.cli.*;
import tink.http.*;
import tink.semver.*;

using thenshim.PromiseTools;
using tink.CoreApi;

/** The main class. **/
@:keep class Main {

	// "asys" package.
	final netSocket: asys.net.Socket = null;
	final process: Process = null;
	final sslSocket: asys.ssl.Socket = null;

	// "thenshim" package.
	final promise: thenshim.Promise<Any> = null;

	// "tink_semver" package.
	final version: Version = null;

	// "tink_url" package.
	final url: Url = null;

	/** Creates a new program. **/
	public function new() {}

	/** Application entry point. **/
	static function main(): Void {
		final program = new Main();

		// "asys" package.
		File.getBytes("haxelib.json").next(bytes -> Noise);
		FileSystem.stat("haxelib.json").next(stat -> Noise);
		Host.localhost();

		// "tink_cli" package.
		Cli.process(Sys.args(), program).handle(Cli.exit);

		// "tink_http" package.
		Client.fetch(program.url).all().next(response -> response.body.toString());

		// "tink_querystring" package.
		QueryString.build({foo: "bar", baz: "qux"});
		QueryString.parse("foo=bar&baz=qux");
	}

	/** A dummy "tink_cli" command. **/
	@:defaultCommand
	public function run(rest: Rest<String>) Cli.getDoc(this);
}
