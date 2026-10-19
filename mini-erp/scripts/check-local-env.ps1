$ErrorActionPreference = 'Stop'

Write-Host 'Mini ERP - local environment check'
Write-Host ''

$phpPath = 'C:\Users\levic\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.WinGet.Source_8wekyb3d8bbwe\php.exe'
$mysqlPath = 'C:\Program Files\MySQL\MySQL Server 8.4\bin\mysql.exe'

if (Test-Path $phpPath) {
    & $phpPath -v
} else {
    Write-Host 'PHP not found at expected path.'
}

if (Test-Path $mysqlPath) {
    & $mysqlPath --version
} else {
    Write-Host 'MySQL client not found at expected path.'
}

$projectRoot = Split-Path -Parent $PSScriptRoot
if (Test-Path (Join-Path $projectRoot '.env')) {
    Write-Host 'Project .env exists.'
} else {
    Write-Host 'Project .env is missing.'
}

$connection = Test-NetConnection -ComputerName 127.0.0.1 -Port 3306 -WarningAction SilentlyContinue
if ($connection.TcpTestSucceeded) {
    Write-Host 'MySQL port 3306 is reachable on localhost.'
} else {
    Write-Host 'MySQL port 3306 is not reachable yet.'
}
