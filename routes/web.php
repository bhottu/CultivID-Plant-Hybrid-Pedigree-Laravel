<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Admin\GoogleSettingController;
use App\Http\Controllers\GoogleAdsenseClientController;
use App\Http\Controllers\Admin\MembaraSettingController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantSubmissionAppealController;
use App\Http\Controllers\PlantSubmissionPublicController;
use App\Http\Controllers\PlantSubmissionController;
use App\Http\Controllers\UserTransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Admin\WithdrawalController;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NotificationController;


Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/discuss', [HomeController::class, 'index'])->name('index.sosmed');
Route::get('/debug-images', function() { return view('debug-images'); });
Route::get('discuss/load', [HomeController::class, 'loadMore'])->name('load.more');
Route::get('discuss/{user}/load', [ProfileController::class, 'loadMore'])->name('load.more-profile');
//Route::get('/profile/{user}/plant-submissions/load', [ProfileController::class, 'loadMorePlantSubmissions'])->name('load.more-plant-submissions-profile');
Route::get('/profile/{user}/plant-submissions/load', [ProfileController::class, 'loadMorePlants'])->name('profile.plant-submissions.load');
Route::get('profile/{user}', [ProfileController::class, 'show'])->name('profile')->middleware('auth');

Route::get('/discuss/@{username}', [HomeController::class, 'postsByUsername'])->name('posts.by.username');

Route::get('/mail-preview', function () {
    // Pastikan ada minimal satu user di database agar tidak error
    $user = App\Models\User::first();
    
    if (!$user) {
        return "Belum ada user di database. Silakan register satu user dulu.";
    }

    return (new ResetPassword('token-dummy'))->toMail($user);
});

Route::middleware(['auth'])->group(function () {
    Route::get('settings/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');

 // Halaman wallet utama
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    // Halaman withdraw
    Route::get('/wallet/withdraw', [WalletController::class, 'withdrawForm'])->name('wallet.withdraw');
    Route::post('/wallet/withdraw', [WalletController::class, 'submitWithdrawal'])->name('wallet.withdraw.submit');


    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');

    // Rute untuk menampilkan form input data tanaman, hanya bisa diakses oleh pengguna yang sudah login
    Route::get('plants/create', [PlantController::class, 'create'])->name('plants.create');
    Route::post('plants', [PlantController::class, 'store'])->name('plants.store');
    Route::get('plants/{id}/edit', [PlantController::class, 'edit'])->name('plants.edit');
    Route::put('plants/{id}', [PlantController::class, 'update'])->name('plants.update');
    Route::delete('plants/{id}', [PlantController::class, 'destroy'])->name('plants.destroy');

    // Plant Submission (member & admin)
    Route::get('plant-submissions', [PlantSubmissionController::class, 'index'])->name('plant-submissions.index');
    Route::get('plant-submissions/create', [PlantSubmissionController::class, 'create'])->name('plant-submissions.create');
    Route::post('plant-submissions', [PlantSubmissionController::class, 'store'])->name('plant-submissions.store');
    Route::get('plant-submissions/{plantSubmission}/edit', [PlantSubmissionController::class, 'edit'])->name('plant-submissions.edit');
    Route::put('plant-submissions/{plantSubmission}', [PlantSubmissionController::class, 'update'])->name('plant-submissions.update');
    Route::post('plant-submissions/{plantSubmission}/review', [PlantSubmissionController::class, 'review'])->name('plant-submissions.review');
    Route::delete('plant-submissions/{plantSubmission}', [PlantSubmissionController::class, 'destroy'])->name('plant-submissions.destroy');

    // Banding Plant Submission (hanya untuk user login)
    Route::get('plant-submissions/{plantSubmission}/appeal', [PlantSubmissionAppealController::class, 'create'])->name('plant-submissions.appeal.create');
    Route::post('plant-submissions/{plantSubmission}/appeal', [PlantSubmissionAppealController::class, 'store'])->name('plant-submissions.appeal.store');
    Route::put('/plant-submissions/appeals/{plantSubmission}',[PlantSubmissionAppealController::class, 'update'])->name('plant-submissions.appeals.update');

  Route::get(
    '/plant-submissions/pedigree/{plantSubmission}',
    [\App\Http\Controllers\PlantSubmissionPublicController::class, 'downloadPedigreePdf']
)->name('plant-submissions.pedigree.pdf');

Route::get(
    'plant-submissions/pedigree-preview/{plantSubmission}',
    [PlantSubmissionPublicController::class, 'previewPedigree']
)->name('plant-submissions.pedigree.preview');

Route::post('/certificate/buy', [UserTransactionController::class, 'buyCertificate'])
    ->name('certificate.buy');

    Route::get('/payment/certificate/return', 
    [PaymentController::class, 'certificateReturn']
)->name('payment.certificate.return');

   
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout');

Route::delete('/cart/item/{id}', [CheckoutController::class, 'remove'])
    ->name('cart.remove');

Route::post('/checkout/pay', [CheckoutController::class, 'pay'])
    ->name('checkout.pay');

Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])
    ->name('checkout.buyNow');

Route::get('/checkout/success', function () {
    return "Payment Success";
})->name('checkout.success');

Route::get('/checkout/failed', function () {
    return "Payment Failed";
})->name('checkout.failed');

 Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

});


Route::post('/buy-coffee', [UserTransactionController::class, 'buy'])->name('coffee.buy');
Route::get('/transaction/check/{id}', function ($id) {
    $transaction = \App\Models\UserTransaction::findOrFail($id);
    return response()->json(['status' => $transaction->status]);
})->name('transaction.check');
// Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
// pindah ke api Route::post('/xendit/callback', [UserTransactionController::class, 'callback']);


// Public detail plant submission (setelah semua route plant-submissions yang spesifik)
Route::get('plant-submissions/{plantSubmission}', [PlantSubmissionPublicController::class, 'show'])->name('plant-submissions.show');

// Rute untuk menampilkan semua tanaman, bisa diakses oleh siapa saja
Route::get('plants', [PlantController::class, 'index'])->name('plants.index');



Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('market/', [ProductController::class, 'allproducts'])->name('all.products');
Route::get('/market/@{username}', [ProductController::class, 'productsByUsername'])->name('products.by.username');
Route::get('load-more-products', [ProductController::class, 'loadMoreProducts'])->name('load-more-products');
Route::get('/market/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/discounted-products', [ProductController::class, 'discountedProducts'])->name('discounted.products');
Route::get('/discounted-products/load-more', [ProductController::class, 'loadMoreDiscountedProducts']);
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/categories/{slug}/load-more-products', [CategoryController::class, 'loadMoreProducts'])->name('categories.loadMoreProducts');
Route::post('/products/{product}/soldout', [ProductController::class, 'toggleSoldOut'])->name('products.toggle-soldout');
Route::get('plants/load-more', [PlantController::class, 'loadMore'])
    ->name('plants.load-more')
    ->middleware('auth');

Route::get('/allcategories', [CategoryController::class, 'showAll'])->name('categories.all');

Route::get('profile/{username}/products/load', [ProductController::class, 'loadMoreProfileProducts'])
    ->name('profile.products.load');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('auth');

Route::get('post/create', [PostController::class, 'create'])->name('post.create')->middleware('auth');
Route::post('post', [PostController::class, 'store'])->name('post.store');

Route::post('profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow')->middleware('auth');
Route::post('profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow')->middleware('auth');

Route::get('post/{id}', [PostController::class, 'show'])->name('post.show')->middleware('auth');
Route::get('posts/{post}', 'PostController@show')->name('posts.show');
Route::post('post/{postId}/like', [LikeController::class, 'addLike'])->name('post.like')->middleware('auth');
Route::post('post/{post}/share', [PostController::class, 'addShare'])->name('post.share')->middleware('auth');
Route::post('post/{post}/comment', [PostController::class, 'addComment'])->name('post.comment')->middleware('auth');

Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit')->middleware('auth');
Route::put('post/{post}', [PostController::class, 'update'])->name('post.update')->middleware('auth');
Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy')->middleware('auth');
Route::delete('/profile/posts/{share}', [PostController::class, 'sharedestroy'])->name('profile.posts.destroy')->middleware('auth');
Route::get('comments/{postId}', [PostController::class, 'fetchComments'])->name('comments.fetch');
Route::get('search', [SearchController::class, 'search'])->name('search');

Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    Route::get('/admin', [ProfileController::class, 'adminDashboardStatistic'])->name('admin.home');

    Route::get('/admin/plant-submissions/search', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'search'])->name('admin.plant-submissions.search');

    // Admin Plant Submissions index (uses admin controller)
    Route::get('/admin/plant-submissions', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'index'])->name('admin.plant-submissions.index');
    Route::get('/admin/plant-submissions/create', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'create'])->name('admin.plant-submissions.create');
    Route::post('/admin/plant-submissions', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'store'])->name('admin.plant-submissions.store');
    Route::get('/admin/plant-submissions/{plantSubmission}', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'show'])->name('admin.plant-submissions.show');
    Route::get('/admin/plant-submissions/{plantSubmission}/edit', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'edit'])->name('admin.plant-submissions.edit');
    Route::put('/admin/plant-submissions/{plantSubmission}', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'update'])->name('admin.plant-submissions.update');
    Route::post('/admin/plant-submissions/{plantSubmission}/review', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'review'])->name('admin.plant-submissions.review');
    Route::delete('/admin/plant-submissions/{plantSubmission}', [\App\Http\Controllers\Admin\PlantSubmissionController::class, 'adminDestroy'])->name('admin.plant-submissions.destroy');
    

   // Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    //Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.items.categories');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
   
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [SettingController::class, 'store'])->name('admin.settings.store');
    
    Route::get('/admin/items', [ProductController::class, 'adminIndex'])->name('admin.items.index');
    Route::get('/admin/items/{product}', [ProductController::class, 'adminShow'])->name('admin.items.show');
    Route::delete('/admin/items/{product}', [ProductController::class, 'adminDestroy'])->name('admin.items.destroy');

    Route::get('/admin/payment', [UserTransactionController::class, 'adminPayment'])->name('admin.payment.index');
    Route::delete('/admin/payment/{transaction}',[UserTransactionController::class, 'destroy'])->name('admin.payment.destroy');
    Route::get('/admin/payment/{transaction}/edit',[UserTransactionController::class, 'edit'])->name('admin.payment.edit');
    Route::put('/admin/payment/{transaction}',[UserTransactionController::class, 'update'])->name('admin.payment.update');


    Route::get('/admin/list-currencies', [CurrencyController::class, 'index'])->name('currencies.index');
    Route::post('/admin/store-currency', [CurrencyController::class, 'store'])->name('currencies.store');
    Route::get('/admin/edit-currency/{currency}', [CurrencyController::class, 'edit'])->name('currencies.edit');
    Route::put('/admin/update-currency/{currency}', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::delete('/admin/delete-currency/{currency}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');
    
    Route::get('/admin/discuss', [PostController::class, 'discuss'])->name('admin.discuss');
    Route::delete('/admin/posts/{id}', [PostController::class, 'admindestroy'])->name('admin.posts.destroy');
    
    Route::get('/admin/users', [ProfileController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{id}', [ProfileController::class, 'adminShowUsers'])->name('admin.users.show');
    Route::delete('/admin/users/{id}', [ProfileController::class, 'adminDestroy'])->name('admin.users.destroy');

    Route::get('admin/google-settings', [SettingController::class, 'googleSettings'])->name('google.settings');
    Route::post('admin/google-settings', [SettingController::class, 'updateGoogleSettings'])->name('google.settings.update');
    
    Route::get('admin/google-adsense', [GoogleAdsenseClientController::class, 'edit'])->name('google.adsense.edit');
    Route::post('admin/google-adsense/update', [GoogleAdsenseClientController::class, 'update'])->name('google.adsense.update');

    Route::get('admin/api-settings', [MembaraSettingController::class, 'edit'])->name('admin.membara-settings.edit');
    Route::post('admin/api-settings', [MembaraSettingController::class, 'update'])->name('admin.membara-settings.update');
    Route::post('admin/verify-license', [MembaraSettingController::class, 'verifyLicense'])->name('admin.verify-license');

    Route::get('/admin/misc/faq', function () {
        return view('admin.misc.faq');
    })->name('admin.misc.faq');

    Route::get('admin/withdrawals', [WithdrawalController::class, 'index'])->name('admin.withdrawals.index');
    Route::post('admin/withdrawals/{withdrawal}/update', [WithdrawalController::class, 'update'])->name('admin.withdrawals.update');

  

});

Route::get('/check-gd', function () {
    return extension_loaded('gd') ? 'GD OK' : 'GD NOT FOUND';
});

// Public About Us page (moved Company & Shop content here)
//Route::view('/about-us', 'about')->name('admin.settings.about');
Route::get('/about-us', [SettingController::class, 'showAbout'])->name('admin.settings.about');
Route::get('/contact-us', [SettingController::class, 'showContact'])->name('admin.settings.contact');
Route::get('/terms-conditions', [SettingController::class, 'showTerms'])->name('admin.settings.terms');
Route::get('/privacy-policy', [SettingController::class, 'showPrivacyPolicy'])->name('admin.settings.privacy');

// Route for payment page
Route::get('/pay-{plantSubmission}', [UserTransactionController::class, 'showPaymentPage'])->name('pay.show');

Route::get('/become-partner', [SettingController::class, 'showBecomePartner'])->name('become.partner');

