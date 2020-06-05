#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

composer install --no-interaction
haxelib newrepo
haxelib install all --always