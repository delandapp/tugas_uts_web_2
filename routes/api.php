<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\PlaceController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\PaymentWebhookController;
use App\Http\Controllers\Api\V1\MerchantOnboardingController;
use App\Http\Controllers\Api\V1\MerchantProfileController;
use App\Http\Controllers\Api\V1\MerchantPlaceController;
use App\Http\Controllers\Api\V1\PlacePhotoController;
use App\Http\Controllers\Api\V1\PromoController;
use App\Http\Controllers\Api\V1\ModerationController;

Route::prefix('v1')->name('api.v1.')->group(function () {

    /**
     * PUBLIC (Guest & User)
     * - Search Nearby
     * - View Place Detail
     * - Open WhatsApp Chat (returns wa.me link)
     * - View Merchant Promos (public)
     */
    Route::get('/nearby', [SearchController::class, 'nearby'])
        ->name('nearby'); // ?lat=&lng=&radius_km=&category_id=

    Route::get('/places/{place}', [PlaceController::class, 'show'])
        ->name('places.show'); // route model binding by UUID

    Route::get('/places/{place}/whatsapp', [PlaceController::class, 'whatsappLink'])
        ->name('places.whatsapp');

    Route::get('/merchants/{merchant}/promos', [PromoController::class, 'indexPublic'])
        ->name('promos.public.index');

    /**
     * AUTHENTICATED USER (Sanctum)
     * - Write/Update/Delete Rating & Review
     * - Pay via E-wallet / COD
     */
    Route::middleware(['auth:sanctum'])->group(function () {

        // Reviews
        Route::post('/places/{place}/reviews', [ReviewController::class, 'store'])
            ->name('reviews.store'); // body: rating, comment, photo_url?
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])
            ->name('reviews.update'); // policy: only owner/admin
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
            ->name('reviews.destroy');

        // Payments
        Route::post('/payments/charge', [PaymentController::class, 'charge'])
            ->name('payments.charge'); // body: method=ewallet|cod, place_id, amount, etc.

        /**
         * MERCHANT (role: merchant)
         * - Merchant Onboarding
         * - Manage Profile & Promo
         * - Manage Places & Photos
         */
        Route::middleware(['role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
            // Onboarding (first-time setup / KYC-lite)
            Route::post('/onboarding', [MerchantOnboardingController::class, 'store'])
                ->name('onboarding.store');

            // Profile
            Route::get('/profile', [MerchantProfileController::class, 'show'])
                ->name('profile.show');
            Route::put('/profile', [MerchantProfileController::class, 'update'])
                ->name('profile.update');

            // Own Places (CRUD minus show/index if managed elsewhere)
            Route::apiResource('places', MerchantPlaceController::class)
                ->only(['store', 'update', 'destroy']);

            // Photos under a place
            Route::post('places/{place}/photos', [PlacePhotoController::class, 'store'])
                ->name('places.photos.store'); // body: photo_url, sequence
            Route::delete('places/{place}/photos/{photo}', [PlacePhotoController::class, 'destroy'])
                ->name('places.photos.destroy');

            // Promos (private CRUD)
            Route::apiResource('promos', PromoController::class)
                ->only(['store', 'update', 'destroy']);
        });

        /**
         * OPS / MODERATOR (role: admin|moderator)
         * - Moderate Reviews / Trust
         */
        Route::middleware(['role:admin|moderator'])->prefix('moderation')->name('moderation.')->group(function () {
            Route::get('/reviews', [ModerationController::class, 'index'])
                ->name('reviews.index'); // filters: status=pending|rejected|published
            Route::post('/reviews/{review}/approve', [ModerationController::class, 'approve'])
                ->name('reviews.approve');
            Route::post('/reviews/{review}/reject', [ModerationController::class, 'reject'])
                ->name('reviews.reject');
        });
    });

    /**
     * PAYMENT WEBHOOK (no auth; custom signature middleware recommended)
     */
    Route::post('/payments/webhook', [PaymentWebhookController::class, 'handle'])
        ->name('payments.webhook')
        ->middleware(['verify.payment-signature']); // create this middleware

});

// Fallback JSON
Route::fallback(fn() => response()->json(['message' => 'Not Found'], 404));
