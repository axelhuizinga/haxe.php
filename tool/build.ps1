#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

haxe build.hxml
Remove-Item src/index.php
Remove-Item src/Main.php
