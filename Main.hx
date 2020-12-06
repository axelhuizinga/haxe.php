import tink.*;
import tink.cli.*;
import tink.http.*;
import tink.semver.*;

using tink.CoreApi;

/** The main class. **/
@:keep class Main {

	// "tink_semver" package.
	var version: Version = null;

	// "tink_url" package.
	var url: Url = null;

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
