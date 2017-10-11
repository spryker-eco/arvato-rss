#!/usr/bin/env bash

echo "Moving module to a subfolder..."
mkdir module
if [ `mv * module/` = 0 ]; then
    echo 'copied'
fi
echo 'copied'
