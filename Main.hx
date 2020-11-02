import datetime.*;
import tink.*;
import tink.cli.*;
import tink.semver.*;

using thenshim.PromiseTools;
using tink.CoreApi;

/** The main class. **/
@:keep class Main {

	// "thenshim" package.
	var promise: thenshim.Promise<Any> = null;

	// "tink_semver" package.
	var version: Version = null;

	// "tink_url" package.
	var url: Url = null;

	/** Creates a new program. **/
	public function new() {}

	/** Application entry point. **/
	static function main(): Void {
		// "datetime" package.
		DateTime.now();
		Timezone.local();

		// "tink_cli" package.
		Cli.process(Sys.args(), new Main()).handle(Cli.exit);
	}

	/** A dummy "tink_cli" command. **/
	@:defaultCommand
	public function run(rest: Rest<String>) Cli.getDoc(this);
}
