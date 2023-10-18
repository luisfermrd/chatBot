<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use WeStacks\TeleBot\Laravel\TeleBot;

class BotController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Obtén la actualización desde Telegram
            $update = $request->all();

            // Procesa la actualización y realiza acciones según tus necesidades
            // Ejemplo: responder a un mensaje
            $message = $update['message']['text'];
            $chatId = $update['message']['chat']['id'];

            $response = "Has dicho: " . $message;
            Log::info('Mensaje ' . $message . ' Chat id:' . $chatId);

            // Tu código actual aquí
        } catch (\Exception $e) {
            Log::error('Error en el webhook: ' . $e->getMessage());
        }
    }

    public function hola(){
        return 'Hola';
    }
}
