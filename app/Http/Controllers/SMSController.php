<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class SMSController extends Controller
{
    public function getAllNumbers()
    {
        if (Cache::has('numbers')) {
            Log::info('Returning cached numbers');
            return response()->json([
                'success' => true,
                'data' => Cache::get('numbers'),
            ]);
        }

        $response = Http::get('https://receive-smss.com/');
        $crawler = new Crawler($response->body());

        $numbers = $crawler->filter('.number-boxes-itemm-number')->each(function ($node) {
            return trim($node->text());
        });

        if (empty($numbers)) {
            Log::error('No numbers found');
            return response()->json([
                'success' => false,
                'message' => 'No numbers found. Please try again later.',
            ]);
        }

        Cache::put('numbers', $numbers, now()->addDay());
        Log::info('Got all numbers');

        return response()->json([
            'success' => true,
            'data' => $numbers,
        ]);
    }

    public function getMessagesForNumber(string $number)
    {
        $number = ltrim($number, '+'); // normalize number
        $cacheKey = "messages_{$number}";

        if (Cache::has($cacheKey)) {
            Log::info("Returning cached messages for {$number}");
            return response()->json([
                'success' => true,
                'data' => Cache::get($cacheKey),
            ]);
        }

        $response = Http::get("https://receive-smss.com/sms/{$number}");
        $crawler = new Crawler($response->body());

        $country = trim(str_replace(
            'mobile phone number.',
            '',
            $crawler->filter('.page-info.helper.center h3')->text()
        ));

        $messages = $crawler->filter('.row.message_details')->each(function ($node) use ($number, $country) {
            return [
                'number' => $number,
                'country' => $country,
                'message' => trim($node->filter('span')->text()),
                'sender' => trim($node->filter('a')->text()),
                'sent_time' => trim(str_replace('Time', '', $node->filter('.col-md-3.time')->text())),
            ];
        });

        $messages = array_slice($messages, 0, 10); // Limit to 10 messages
        Log::info("Fetched messages for number: {$number}");

        Cache::put($cacheKey, $messages, now()->addMinutes(1)); // Cache per number
        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }
}
