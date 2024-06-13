#!/bin/bash
log=/var/script-sh/restart.log load=cut -d ' ' -f1 /proc/loadavg load=${load%.*} 
echo $load; if [ $load -gt 50 ] ; then
    cd ./ && docker compose down && docker compose up -d
        echo "[date] Valor do load: $load | Apache reiniciado por load superior a 
        50" >> $log
else echo "Load abaixo de 50, não reinicia apache"
fi
