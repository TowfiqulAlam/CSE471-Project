<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class OpenAIController extends Controller
{
    public function getJobSuggestion()
    {
        $question = 'Suggest suitable job roles based on a typical job seeker profile.';


        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'Job Suggestion Assistant',
            ])
            ->timeout(120) // Set timeout to 60 seconds
            ->retry(3, 2000) // Retry 3 times, waiting 2 seconds between each
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-r1:free',
                'messages' => [
                    ['role' => 'user', 'content' => $question]
                ],
            ]);


            if ($response->failed()) {
                return back()->withErrors(['api_error' => 'API request failed. Please try again later.']);
            }


            $answer = $response->json('choices.0.message.content');


            return view('openai.suggestion', compact('question', 'answer'));
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return back()->withErrors(['api_error' => 'Connection timed out. Please try again later.']);
        } catch (\Exception $e) {
            return back()->withErrors(['api_error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }


}
