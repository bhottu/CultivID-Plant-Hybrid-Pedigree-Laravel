# Release Notes

## v1.1.0 (2023-02-17)

* Improvements
- Modified : E:\LARAVEL\sosmedku\resources\views\auth\forgot-password.blade.php
- Modified : E:\LARAVEL\sosmedku\resources\views\auth\register.blade.php
- Modified : E:\LARAVEL\sosmedku\resources\views\partials\footer.blade.php
- Modified : E:\LARAVEL\sosmedku\resources\views\layouts\app.blade.php
- Modified : E:\LARAVEL\sosmedku\resources\views\components\ImagePopupProductShow.blade.php

* Added soldout feature
- Added table : E:\LARAVEL\sosmedku\database\migrations\2024_08_13_072220_add_is_sold_out_to_products_table.php
- Modified : E:\LARAVEL\sosmedku\app\Http\Controllers\ProductController.php line 192-203
- Modified : E:\LARAVEL\sosmedku\routes\web.php line 63
- Modified : E:\LARAVEL\sosmedku\resources\views\products\show.blade.php line 61-68 & line 107-117
- Modified : E:\LARAVEL\sosmedku\resources\views\admin\items\index.blade.php line 35-44
- Modified : E:\LARAVEL\sosmedku\resources\views\admin\items\show.blade.php line 20-24

* Added slider on product page
- E:\LARAVEL\sosmedku\resources\views\products\show.blade.php

* Added image compressor (To reduce the image size stored on the server, we use a ratio 75 so that the quality still looks good.)
- E:\LARAVEL\sosmedku\app\Http\Controllers\ProductController.php

* Added fillament and replaced old dashboard with Fillament

Added sanctum for API
composer require laravel/sanctum
E:\LARAVEL\sosmedku\bootstrap\app.php
E:\LARAVEL\sosmedku\app\Http\Controllers\API\ApiAuthController.php
E:\LARAVEL\sosmedku\app\Http\Controllers\API\ApiProductController.php
E:\LARAVEL\sosmedku\routes\api.php

## v1.0.0 (2023-02-17)

* Add product feature
* Add duscuss feature
* 
