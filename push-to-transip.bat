@echo off
echo ============================================
echo   AutoGit Push naar TransIP
echo   automationsequre.nl
echo ============================================
echo.

REM Ga naar de project map
cd /d "%~dp0"

REM Stel SSH key in voor deze sessie
set KEY_PATH=%~dp0.transip_key
set GIT_SSH_COMMAND=ssh -i "%~dp0.transip_key" -o StrictHostKeyChecking=no -o UserKnownHostsFile="%TEMP%\transip_known_hosts"

echo Gebruik SSH key: %KEY_PATH%
echo.

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

REM Zorg dat we op main branch zijn
git checkout main 2>nul

REM Voeg TransIP remote toe
echo [2/5] TransIP remote instellen...
git remote remove transip 2>nul
git remote add transip automationsequrenl@autp9d.ssh.transip.me:auto.git

REM Stage alle bestanden (exclusief .bat en .transip_key bestanden)
echo [3/5] Bestanden toevoegen...
git add -A

REM Maak een commit
echo [4/5] Commit maken...
git commit -m "Deploy website met favicon naar TransIP" --allow-empty

REM Push naar TransIP
echo [5/5] Pushen naar TransIP...
echo.
git push -u transip main --force 2>&1

echo.
echo ============================================
echo   Script voltooid. Controleer hierboven
echo   of de push gelukt is.
echo ============================================
echo.
pause
