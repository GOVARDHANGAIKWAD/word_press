@echo off
title Coalition Technologies Skills Test - Server Runner
cd /d "%~dp0"

echo ================================================================
echo   Coalition Technologies - WordPress Skills Test Local Server
echo ================================================================
echo.

:: 1. Check & start MySQL 8.0 on port 3307 if not already listening
netstat -ano | findstr "3307" | findstr "LISTENING" >nul
if %errorLevel% == 0 (
    echo [OK] MySQL daemon is already running on port 3307.
) else (
    echo [..] Starting MySQL daemon on port 3307...
    start "CT-MySQL" /b "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqld.exe" --datadir="%~dp0mysql-data" --port=3307 --mysqlx=0 --console
    timeout /t 3 /nobreak >nul
)

:: 2. Find PHP executable & set multi-threaded workers
set PHP_CLI_SERVER_WORKERS=8
set PHP_BIN=C:\Users\ASUS\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe
if not exist "%PHP_BIN%" (
    set PHP_BIN=php
)

echo.
echo [OK] Document root: %~dp0site
echo [OK] Starting web server on http://coalitiontest.local (http://127.0.0.1:80)...
echo [INFO] Press Ctrl+C anytime to stop the server.
echo.

:: Try opening the browser
start "" "http://localhost"

:: 3. Launch PHP Built-in Server on port 80 with router
"%PHP_BIN%" -S 127.0.0.1:80 -t "%~dp0site" "%~dp0site\router.php"
if %errorLevel% neq 0 (
    echo [NOTICE] Port 80 busy, falling back to port 8080...
    start "" "http://localhost:8080"
    "%PHP_BIN%" -S 127.0.0.1:8080 -t "%~dp0site" "%~dp0site\router.php"
)

pause

