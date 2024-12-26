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

        // Normalize the quiz data for consistent naming
        $normalizedQuiz = $this->normalizeQuiz($quiz, $topic);

        return $normalizedQuiz;
    }

    private function normalizeQuiz($quiz, $topic)
    {
        // Ensure the "title" key exists and has a consistent naming convention
        if (!isset($quiz['title'])) {
            $quiz['title'] = ucfirst($topic) . ' Quiz'; // Fallback to a generated title if not provided
        }

        // Ensure questions and options have consistent naming
        if (isset($quiz['questions']) && is_array($quiz['questions'])) {
            foreach ($quiz['questions'] as &$question) {
                // Normalize question text
                if (!isset($question['question'])) {
                    $question['question'] = 'Untitled Question';
                }

                // Normalize options
                if (isset($question['options']) && is_array($question['options'])) {
                    $question['options'] = array_map('trim', $question['options']);
                } else {
                    $question['options'] = [];
                }

                // Ensure the correct answer field exists
                if (!isset($question['answer'])) {
                    $question['answer'] = null; // Or provide a default value if necessary
                }
            }
        } else {
            $quiz['questions'] = [];
        }

        return $quiz;
    }
}
