@echo off
echo ============================================
echo   AutoGit Push naar TransIP
echo   automationsequre.nl
echo ============================================
echo.

REM Ga naar de project map
cd /d "%~dp0"

REM Stel SSH key in voor deze sessie
set GIT_SSH_COMMAND=ssh -i "%~dp0.transip_key" -o StrictHostKeyChecking=no -o UserKnownHostsFile=NUL

REM Configureer git user als dat nog niet is gedaan
git config user.email "gewoonkennethb@gmail.com" 2>nul
git config user.name "Kenneth" 2>nul

REM Initialiseer git repo als dat nog niet is gedaan
if not exist ".git" (
    echo [1/5] Git repository initialiseren...
    git init
    git checkout -b main
) else (
    echo [1/5] Git repository gevonden.
)

REM Voeg TransIP remote toe
echo [2/5] TransIP remote instellen...
git remote remove transip 2>nul
git remote add transip automationsequrenl@autp9d.ssh.transip.me:auto.git

REM Stage alle bestanden
echo [3/5] Bestanden toevoegen...
git add -A

REM Maak een commit
echo [4/5] Commit maken...
git commit -m "Deploy website met favicon naar TransIP" 2>nul || echo    (Geen nieuwe wijzigingen om te committen)

REM Push naar TransIP
echo [5/5] Pushen naar TransIP...
echo.
git push -u transip main --force

echo.
if %ERRORLEVEL% EQU 0 (
    echo ============================================
    echo   GELUKT! Website is gedeployed naar
    echo   https://automationsequre.nl
    echo ============================================
) else (
    echo ============================================
    echo   Er ging iets mis. Controleer de foutmelding
    echo   hierboven.
    echo ============================================
)

echo.
pause
