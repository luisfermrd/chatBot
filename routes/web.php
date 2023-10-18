<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\TelegramBotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/webhook', [TelegramBotController::class, 'webhook']);
Route::get('/hola', [BotController::class, 'hola']);

/*
Api_key=6224481030:AAHjSXJID69iBhF9oLaMyjqkNjl4lNrsafI
url = https://f861-201-219-194-82.ngrok-free.app/webhook/
https://api.telegram.org/bot224481030:AAHjSXJID69iBhF9oLaMyjqkNjl4lNrsafI/setWebhook
https://api.telegram.org/bot6224481030:AAHjSXJID69iBhF9oLaMyjqkNjl4lNrsafI/getWebhookInfo
 */



