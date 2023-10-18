<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WeStacks\TeleBot\TeleBot;
use Illuminate\Support\Facades\Log;


class TelegramBotController extends Controller
{
    public function webhook(Request $request)
    {
        try {
        // Obtén la actualización desde Telegram
         // Obtén la actualización desde Telegram
         $update = $request->all();

         // Procesa la actualización y realiza acciones según tus necesidades
         // Ejemplo: responder a un mensaje
         $message = $update['message']['text'];
         $chatId = $update['message']['chat']['id'];

         // Define las respuestas predefinidas (sin distinción entre mayúsculas y minúsculas)
         $responses = [
            'hola' => '¡Hola! ¿En qué puedo ayudarte?',
            'adiós' => '¡Hasta luego!',
            'información' => 'Aquí tienes información relevante.',
            'gracias' => 'De nada, ¡estoy para ayudarte!',
            'tiempo' => 'Lo siento, no puedo proporcionar información sobre el tiempo.',
            'ayuda' => '¿En qué necesitas ayuda?',
            'nombre' => 'Mi nombre es ChatBot.',
            'edad' => 'Soy un programa de computadora, así que no tengo edad.',
            '¿cómo estás?' => 'Estoy bien, gracias por preguntar.',
            'bien' => 'Me alegra saber que estás bien.',
            'mal' => 'Lamento escuchar eso. ¿En qué puedo ayudarte?',
            'chiste' => '¿Por qué los pájaros no usan Facebook? Porque ya tienen Twitter.',
            'significado de la vida' => 'El significado de la vida es una pregunta filosófica profunda y puede variar según la perspectiva de cada persona.',
            'ubicación' => 'No puedo proporcionar mi ubicación, soy un programa en línea.',
            'rutina diaria' => 'No tengo una rutina diaria, estoy siempre listo para responder tus preguntas.',
            'te amo' => 'También te aprecio. ¿En qué más puedo ayudarte?',
            'cuál es tu color favorito' => 'No tengo preferencias de color, pero el azul es agradable.',
            'dame un consejo' => 'Un consejo: ¡siempre mantén una mente abierta!',
            'canción favorita' => 'No puedo escuchar música, pero sé que a mucha gente le gusta "Imagine" de John Lennon.',
            'cómo se hace un pastel' => 'Para hacer un pastel, necesitas ingredientes como harina, huevos, azúcar, etc. ¿Necesitas una receta específica?',
        ];

         // Limpia y convierte el mensaje en minúsculas para hacer la comparación
         $messageLower = strtolower(trim($message));

         // Verifica si el mensaje coincide con una respuesta predefinida
         if (array_key_exists($messageLower, $responses)) {
             $response = $responses[$messageLower];
         } else {
             // Mensaje predeterminado si el mensaje no se reconoce
             $response = 'Lo siento, no entiendo tu mensaje. Puedes preguntarme sobre algo específico.';
         }

         // Envía la respuesta al chat
         $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
         $telebot->sendMessage([
             'chat_id' => $chatId,
             'text' => $response,
         ]);

            // Tu código actual aquí
        } catch (\Exception $e) {
            log::error('Error en el webhook: ' . $e->getMessage());
        }
    }
}
