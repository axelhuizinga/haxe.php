import tink.*;
import tink.cli.*;
import tink.http.*;
import tink.semver.*;

using thenshim.PromiseTools;
using tink.CoreApi;

/** The main class. **/
@:keep class Main {

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

		// "tink_cli" package.
		Cli.process(Sys.args(), program).handle(Cli.exit);

		// "tink_http" package.
		Client.fetch(program.url).all().next(response -> response.body.toString());
	}

	/** A dummy "tink_cli" command. **/
	@:defaultCommand
	public function run(rest: Rest<String>) Cli.getDoc(this);
}
