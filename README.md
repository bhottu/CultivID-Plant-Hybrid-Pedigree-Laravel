v1.0.22

New migration
database/migrations/2026_01_26_015201_create_user_transactions_table.php ✅
database/migrations/2026_01_26_015923_add_balance_to_users_table.php ✅
database/migrations/2026_01_26_020951_change_balance_to_decimal_on_users_table.php ✅
database/migrations/2026_01_26_021157_create_withdrawals_table.php
database/migrations/2026_01_26_021614_add_bank_to_users_table.php

perbaiki payment gateway saya yang tidak berfungsi

- Model : app\Models\UserTransaction.php

- Controller : app\Http\Controllers\UserTransactionController.php

- services.php :   
'duitku' => [
    'merchant_code' => env('DUITKU_MERCHANT_CODE'),
    'api_key'       => env('DUITKU_API_KEY'),
    'base_url'      => env('DUITKU_BASE_URL'),
    'callback_url'  => env('DUITKU_CALLBACK_URL'),
    'return_url'    => env('DUITKU_RETURN_URL'),
],

- env file : 
DUITKU_MERCHANT_CODE=DS27694
DUITKU_API_KEY=api key saya
DUITKU_CALLBACK_URL=https://cultiv.id/duitku/callback
DUITKU_RETURN_URL=https://cultiv.id/payment/success

DUITKU_ENV=sandbox
DUITKU_BASE_URL=https://sandbox.duitku.com/webapi/api/merchant

- routes cek pada line yang beri komen : 
 // DUITKU ROUTES (AUTHENTICATED) dan // DUITKU CALLBACK (PUBLIC)

- blade tombolnya di resources\views\plant_submissions\show.blade.php
            {{-- Buy Me a Coffee Section --}}
            <div class="border rounded p-4 mt-4">
                <h3 class="font-bold mb-2">☕ Buy Me a Coffee</h3>

                <form action="{{ route('buy.coffee') }}" method="POST">
                    @csrf

                    <input type="hidden" name="to_user_id"
                        value="{{ $plantSubmission->uploader_id }}">

                    <div class="flex gap-2 mb-2">
                        <label><input type="radio" name="amount" value="5000" checked> 5K</label>
                        <label><input type="radio" name="amount" value="10000"> 10K</label>
                        <label><input type="radio" name="amount" value="20000"> 20K</label>
                    </div>

                    <input type="number"
                        name="custom_amount"
                        min="5000"
                        placeholder="Custom nominal"
                        class="border rounded w-full p-2 mb-2">

                    <button class="bg-yellow-500 text-white px-4 py-2 rounded">
                        ☕ Buy Me a Coffee
                    </button>
                </form>
            </div>

Database migration saya :
database\migrations\2026_01_26_015201_create_user_transactions_table.php
database\migrations\2026_01_26_015923_add_balance_to_users_table.php
database\migrations\2026_01_26_020951_change_balance_to_decimal_on_users_table.php
database\migrations\2026_01_26_021157_create_withdrawals_table.php
database\migrations\2026_01_26_021614_add_bank_to_users_table.php

perbaiki agar tombol buy me a coffee berfungsi, agar callback berfungsi, transaksi tercatat di database

______________

use App\Models\Product;use Illuminate\Support\Str;Product::whereNull('slug')    ->orWhere('slug', '')    ->get()    ->each(function ($product) {        $product->slug = Str::slug($product->name) . '-' . $product->id;        $product->save();    });

Missing required parameter for [Route: products.show] [URI: market/{slug}] [Missing parameter: slug].