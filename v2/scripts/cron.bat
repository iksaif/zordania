@ECHO OFF

: recuperer la date
set mydate=%date:~6,4%%date:~3,2%%date:~0,2%_%time:~0,2%%time:~3,2%%time:~6,2%
set mydate=%mydate: =0%

: repertoire du PHP CLI
set REP_PHP=C:\ProgramData\wamp64\bin\php\php7.0.10\php.exe

cd ..
set ZPATH=%CD%

echo passage du tour %mydate% ...
%REP_PHP% -f %ZPATH%\crons\cron.php >> %ZPATH%\logs\crons\out\out_%mydate%.log
