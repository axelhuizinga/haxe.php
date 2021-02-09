#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
Set-Location (Split-Path $PSScriptRoot)

composer update
lix download
