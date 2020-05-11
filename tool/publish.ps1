#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

$version = (Get-Content haxelib.json | ConvertFrom-Json -AsHashTable).version
tool/version.ps1
git tag "v$version"
git push origin "v$version"
