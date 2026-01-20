what to do

php artisan make:model Tanaman -m
php artisan make:controller API/TanamanController --resource
php artisan make:migration create_tanamans_table --create=tanamans

Edit Model Tanaman
Edit Controller TanamanController
Edit Migration create_tanamans_table

php artisan migrate --path=/database/migrations/2024_10_21_033453_create_plants_table.php

