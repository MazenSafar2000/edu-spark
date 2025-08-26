# run corn in background
Start-Job -ScriptBlock {
    while ($true) {
        php artisan schedule:run
        Start-Sleep -Seconds 60
    }
}

# run local server
php artisan serve
