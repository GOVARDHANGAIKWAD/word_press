@echo off
:: Batch script to add coalitiontest.local to Windows hosts file
:: Must be run as Administrator

net session >nul 2>&1
if %errorLevel% == 0 (
    findstr /i "coalitiontest.local" "%windir%\System32\drivers\etc\hosts" >nul
    if %errorLevel% == 0 (
        echo [INFO] coalitiontest.local already exists in hosts file.
    ) else (
        echo 127.0.0.1 coalitiontest.local>> "%windir%\System32\drivers\etc\hosts"
        echo [SUCCESS] Added 127.0.0.1 coalitiontest.local to %windir%\System32\drivers\etc\hosts
    )
) else (
    echo [ERROR] Please right-click this file and choose "Run as administrator".
)
pause

