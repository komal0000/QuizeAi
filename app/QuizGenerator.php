<?php

namespace App;

use Illuminate\Support\Facades\Http;

class QuizGenerator
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = 'https://api.mistral.ai/v1/chat/completions';
        $this->apiKey = env('AI_API_KEY');
    }

    public function extractJSON($response)
    {
        $content = $response['choices'][0]['message']['content'] ?? null;
        if ($content) {
            $pattern = '/```json\n(.*?)\n```/s';
            if (preg_match($pattern, $content, $matches)) {
                $jsonContent = $matches[1];
                try {
                    return json_decode($jsonContent, true);
                } catch (\Exception $e) {
                    return null;
                }
            } else {
                return null;
            }
        }

        return null;
    }

    public function generateQuiz($topic, $age)
    {
        $postData = [
            'model' => 'mistral-large-latest',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a quiz creator. Generate a JSON quiz based on a given topic and age group.'],
                ['role' => 'user', 'content' => "Create a quiz about $topic for age $age in JSON format."]
            ]
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)->post($this->apiUrl, $postData);

        if ($response->failed()) {
            throw new \Exception("Request failed with status code " . $response->status());
        }

        $responseBody = $response->json();
        $quiz = $this->extractJSON($responseBody);

        if (!$quiz) {
            throw new \Exception("Failed to extract JSON from response.");
        }

        return $quiz;
    }
}
