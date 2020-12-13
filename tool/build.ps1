#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

if (Test-Path src) { Remove-Item src -Recurse }
haxe build.hxml

foreach ($item in "index.php", "src/Main.php", "src/tink/cli/*0.php", "src/tink/querystring/*0.php") {
	if (Test-Path $item) { Remove-Item $item }
}
