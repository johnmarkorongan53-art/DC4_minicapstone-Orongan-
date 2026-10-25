$ErrorActionPreference = 'Stop'
$workspaceRoot = Split-Path -Parent $PSScriptRoot
$portablePhpRoot = Join-Path $workspaceRoot '.tools\php'
$portablePhp = Join-Path $portablePhpRoot 'php.exe'

if (Test-Path -LiteralPath $portablePhp) {
    $phpExecutable = $portablePhp
    $env:PHPRC = $portablePhpRoot
} else {
    $systemPhp = Get-Command php -ErrorAction SilentlyContinue
    if (-not $systemPhp) { throw 'PHP 8.2+ is required. Install PHP, or place php.exe under .tools/php.' }
    $phpExecutable = $systemPhp.Source
}

if (-not (Test-Path -LiteralPath (Join-Path $PSScriptRoot '.env'))) {
    Copy-Item (Join-Path $PSScriptRoot '.env.example') (Join-Path $PSScriptRoot '.env')
    Write-Host 'Created backend/.env. Configure MySQL credentials and run php artisan key:generate and php artisan migrate --seed before starting.'
    exit 1
}

Push-Location $PSScriptRoot
try { & $phpExecutable artisan serve --host=127.0.0.1 --port=8000 }
finally { Pop-Location }
