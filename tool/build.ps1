#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

haxe build.hxml
foreach ($item in "index.php", "src/Main.php") {
	if (Test-Path $item) { Remove-Item $item }
}
