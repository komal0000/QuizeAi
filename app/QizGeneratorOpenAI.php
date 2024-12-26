<?php
namespace App;

use Illuminate\Support\Facades\Http;

class QizGeneratorOpenAI {
    private $apiKey;
    private $apiUrl;

    public function __construct() {
        $this->apiKey = getenv('OPEN_AI_API_KEY');
        if (!$this->apiKey) {
            throw new \Exception('API key not found in environment variables.');
        }
        $this->apiUrl = 'https://api.openai.com/v1/chat/completions';
    }

    /**
     * Generate a quiz for a given topic and age group.
     *
     * @param string $topic The topic for the quiz.
     * @param string $ageGroup The target age group for the quiz.
     * @param int $numberOfQuestions The number of quiz questions to generate.
     * @return string JSON response containing the quiz.
     */
    public function generateQuiz($topic, $ageGroup, $numberOfQuestions = 5) {
        $prompt = "Create unique quiz everytime we call api with $numberOfQuestions questions on the topic '$topic' suitable for the age group '$ageGroup' with 4 multiple-choice options and make right answer. Return as JSON with format {
                    \"title\": \"\",
                    \"questions\": []
                }";

        $response = $this->callOpenAI($prompt);

        if (isset( $response['choices'][0])) {
            return $this->formatQuiz( $response['choices'][0]['message']['content'] );

        } else {
            return json_encode(['status' => 'error', 'message' => 'Failed to generate quiz.'], JSON_PRETTY_PRINT);
        }
    }

    /**
     * Call the OpenAI API with the given prompt.
     *
     * @param string $prompt The prompt to send to OpenAI.
     * @return array The decoded JSON response from the API.
     */
    private function callOpenAI($prompt) {
        $data = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                  'role' => "system",
                  'content' => "assume you are a teacher no:".time(),
                ],
                [
                  'role' => "user",
                  'content' => $prompt,
                ],
              ],
              'temperature' => 1.5,
              'top_p' => 0.9,
            'n' => 1,
        ];

        try {
            $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post($this->apiUrl, $data);

            if ($response->successful()) {
                return $response->json();
            } else {
            throw new \Exception('Error from OpenAI API: ' . $response->body());
            }
        } catch (\Exception $e) {
            dd($e);
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Format the raw response text into a structured quiz format.
     *
     * @param string $rawText The raw text response from OpenAI.
     * @return array Formatted quiz data.
     */
    private function formatQuiz($content) {

        $quiz=[
            'title'=>"",
            'quesitions'=>[]
        ];

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
        return $quiz;
    }
}

