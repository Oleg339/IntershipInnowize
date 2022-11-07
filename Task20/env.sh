#!/bin/bash
if [ "$1" == "up" ] || [ $# -eq 0 ]
then
service mysql stop;
vendor/bin/sail up -d;
pm2 start "npm run dev" --name cssLoader;
sleep 0.5;
firefox --new-window localhost:80;
fi
if [ "$1" == "down" ]
then
pkill firefox;
vendor/bin/sail down;
pm2 delete all;
fi
