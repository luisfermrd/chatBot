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

            if (strpos($message, '/') === 0) {
                // Si el mensaje comienza con "/", es un comando
                $command = strtolower(explode(' ', $message)[0]); // Obtenemos el comando en minúsculas

                switch ($command) {
                    case '/start':
                        $this->handleStartCommand($chatId);
                        break;
                    case '/ayuda':
                        $this->handleAyudaCommand($chatId);
                        break;
                        // Agrega más comandos y casos según tus necesidades
                    default:
                        $this->handleUnknownCommand($chatId);
                        break;
                }
            } else {
                // No es un comando, respuesta por defecto
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
            }
        } catch (\Exception $e) {
            log::error('Error en el webhook: ' . $e->getMessage());
        }
    }

    private function handleStartCommand($chatId)
    {
        // Lógica para el comando /start
        $response = "¡Bienvenido al bot! Puedes empezar por aquí.";
        $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        $telebot->sendMessage([
            'chat_id' => $chatId,
            'text' => $response,
        ]);
    }

    private function handleAyudaCommand($chatId)
    {
        // Lógica para el comando /ayuda
        $response = "Aquí tienes una lista de comandos disponibles:\n/start - Iniciar el bot\n/ayuda - Mostrar ayuda";
        $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        $telebot->sendMessage([
            'chat_id' => $chatId,
            'text' => $response,
        ]);
    }

    private function handleUnknownCommand($chatId)
    {
        // Lógica para comandos desconocidos
        $response = "No entiendo ese comando. Puedes usar /ayuda para obtener una lista de comandos disponibles.";
        $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        $telebot->sendMessage([
            'chat_id' => $chatId,
            'text' => $response,
        ]);
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendMessage($chatId)
    {
        $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        $message = $telebot->sendMessage([
            'chat_id'      => $chatId,
            'text'         => 'Welcome To Code-180 Youtube Channel',
            'reply_markup' => [
                'inline_keyboard' => [[[
                    'text' => '@code-180',
                    'url'  => 'https://www.youtube.com/@code-180/videos',
                ]]],
            ],
        ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendPhoto($chatId)
    {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // 1. https://anyurl/640
        // 2. fopen('local/file/path', 'r')
        // 3. fopen('https://picsum.photos/640', 'r'),
        // 4. new InputFile(fopen('https://picsum.photos/640', 'r'), 'test-image.jpg')
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        $message = $telebot->sendPhoto([
            'chat_id' => $chatId,
            'photo'   => [
                'file'     => fopen(asset('public/upload/img.jpg'), 'r'),
                'filename' => 'demoImg.jpg',
            ],
        ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendAudio($chatId)
    {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // 1. https://picsum.photos/640
        // 2. fopen('local/file/path', 'r')
        // 3. fopen('https://picsum.photos/640', 'r'),
        // 4. new InputFile(fopen('https://picsum.photos/640', 'r'), 'test-image.jpg')
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        $message = $telebot->sendAudio([
            'chat_id' => $chatId,
            'audio'   => fopen(asset('public/upload/demo.mp3'), 'r'),
            'caption' => "Demo Audio File",
        ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendVideo($chatId)
    {
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            // 1. https://picsum.photos/640
            // 2. fopen('local/file/path', 'r')
            // 3. fopen('https://picsum.photos/640', 'r'),
            // 4. new InputFile(fopen('https://picsum.photos/640', 'r'), 'test-image.jpg')
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
            $message = $telebot->sendVideo([
                'chat_id' => $chatId,
                'video'   => fopen(asset('public/upload/Password.mp4'), 'r'),
            ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendVoice($chatId)
    {
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            // 1. https://picsum.photos/640
            // 2. fopen('local/file/path', 'r')
            // 3. fopen('https://picsum.photos/640', 'r'),
            // 4. new InputFile(fopen('https://picsum.photos/640', 'r'), 'test-image.jpg')
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
            $message = $telebot->sendVoice([
                'chat_id' => $chatId,
                'voice'   => fopen(asset('public/upload/demo.mp3'), 'r'),
            ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendDocument($chatId)
    {
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            // 1. https://picsum.photos/640
            // 2. fopen('local/file/path', 'r')
            // 3. fopen('https://picsum.photos/640', 'r'),
            // 4. new InputFile(fopen('https://picsum.photos/640', 'r'), 'test-image.jpg')
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
            $message = $telebot->sendDocument([
                'chat_id'  => $chatId,
                'document' => fopen(asset('public/upload/Test_Doc.pdf'), 'r'),
            ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendLocation($chatId)
    {
            $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
            $message = $telebot->sendLocation([
                'chat_id'   => $chatId,
                'latitude'  => 19.6840852,
                'longitude' => 60.972437,
            ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendVenue($chatId)
    {
            $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
            $message = $telebot->sendVenue([
                'chat_id'   => $chatId,
                'latitude'  => 19.6840852,
                'longitude' => 60.972437,
                'title'     => 'The New Word Of Code',
                'address'   => 'Address For The Place',
            ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendContact($chatId)
    {
            $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
            $message = $telebot->sendContact([
                'chat_id'      => $chatId,
                'photo'        => 'https://picsum.photos/640',
                'phone_number' => '1234567890',
                'first_name'   => 'Code-180',
            ]);
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    private function sendPoll($chatId)
    {
            $telebot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
            $message = $telebot->sendPoll([
                'chat_id'  => $chatId,
                'question' => 'What is best coding language for 2023',
                'options'  => ['python', 'javascript', 'typescript', 'php', 'java'],
            ]);
    }
}
