# Coalition Technologies Skills Test - PowerShell Server Runner
$ErrorActionPreference = 'Stop'
$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path

Write-Host "================================================================" -ForegroundColor Cyan
Write-Host "  Coalition Technologies - WordPress Skills Test Local Server" -ForegroundColor Cyan
Write-Host "================================================================" -ForegroundColor Cyan

# 1. Start MySQL daemon if not running
$mysqlPortOpen = Get-NetTCPConnection -LocalPort 3307 -ErrorAction SilentlyContinue
if (-not $mysqlPortOpen) {
    Write-Host "[..] Starting MySQL daemon on port 3307..." -ForegroundColor Yellow
    $mysqldPath = "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqld.exe"
    $dataDir = Join-Path $ScriptDir "mysql-data"
    Start-Process -FilePath $mysqldPath -ArgumentList "--datadir=`"$dataDir`" --port=3307 --mysqlx=0 --console" -WindowStyle Hidden
    Start-Sleep -Seconds 2
} else {
    Write-Host "[OK] MySQL daemon running on port 3307." -ForegroundColor Green
}

# 2. Identify PHP & enable concurrent workers
$env:PHP_CLI_SERVER_WORKERS = "8"
$phpPath = "C:\Users\ASUS\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
if (-not (Test-Path $phpPath)) {
    $phpPath = "php"
}

$siteDir = Join-Path $ScriptDir "site"
$router = Join-Path $siteDir "router.php"

Write-Host "[OK] Starting PHP Web Server on http://coalitiontest.local (http://127.0.0.1:80)..." -ForegroundColor Green
Write-Host "[INFO] Press Ctrl+C to terminate server." -ForegroundColor Gray

# Try binding port 80
try {
    Start-Process "http://localhost"
    & $phpPath -S 127.0.0.1:80 -t "$siteDir" "$router"
} catch {
    Write-Host "[NOTICE] Port 80 unavailable, running on port 8080..." -ForegroundColor Yellow
    Start-Process "http://localhost:8080"
    & $phpPath -S 127.0.0.1:8080 -t "$siteDir" "$router"
}

