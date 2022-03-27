#!/bin/bash

WD=`pwd`
PORT=8080

php=php
if [[ -x /usr/bin/php8 ]]; then php=php8; fi

cd www
echo "this application is available at http://localhost:$PORT"
$php -S localhost:$PORT _mvp.php
cd $WD
