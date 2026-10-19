$ErrorActionPreference = 'Stop'
$projectRoot = Split-Path -Parent $PSScriptRoot
Set-Location $projectRoot

Write-Host 'Starting Mini ERP on http://127.0.0.1:8080'
php -c .\php.ini -S 127.0.0.1:8080 -t public
