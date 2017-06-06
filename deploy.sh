#!/bin/bash

rsync -r --exclude 'public' --exclude 'storage' . theblas4@theblankenship.com:/home2/theblas4/laravel-pv-api
