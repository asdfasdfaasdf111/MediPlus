@echo off
echo Starting Laravel Dev Environment...

start cmd /k php artisan serve
start cmd /k php artisan schedule:work
start cmd /k npm run dev
