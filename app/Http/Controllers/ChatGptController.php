<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\Subcategory;

class ChatGptController extends Controller
{
    public function handleRequest(Request $request)
    {

        //chatgptの動作確認するときは、envファイルを設定して以下の2行をコメントアウトしてください。 omori
        //$json_test = '{"Protein":"88g","Fat":"19g","Carbohydrates":"109g","Vitamins":"19mg","Minerals":"278mg","Subcategories":{"Simple Sugars":"30g","Complex Carbohydrates":"40g","Fiber":"15g","Starches":"20g","Polysaccharides":"4g","Lysine":"2.1g","Leucine":"2.0g","Isoleucine":"2.7g","Valine":"2.6g","Threonine":"1.8g","Methionine":"1.2g","Phenylalanine":"1.4g","Histidine":"1.1g","Arginine":"1.3g","Saturated Fats":"7g","Unsaturated Fats":"10g","Omega-3 Fatty Acids":"1.5g","Omega-6 Fatty Acids":"1.2g","Trans Fats":"0.3g","Vitamin A":"700µg","Vitamin B1 (Thiamine)":"1.2mg","Vitamin B2 (Riboflavin)":"1.3mg","Vitamin B6 (Pyridoxine)":"1.7mg","Vitamin B12 (Cobalamin)":"2.4µg","Vitamin C":"90mg","Vitamin D":"15µg","Vitamin E":"10mg","Vitamin K":"120µg","Calcium":"1000mg","Iron":"18mg","Magnesium":"400mg","Potassium":"3500mg","Sodium":"2300mg","Zinc":"11mg","Phosphorus":"700mg","Copper":"0.9mg","Manganese":"2.3mg","Fluoride":"4mg"}}';
        //return $json_test;
         

        $mealContent = $request->input('meal_content');

        $response = $this->accessChatgptApi($mealContent);

        if ($response) {

            
            // 必要なnutritionデータのみを返却
            $nutritionData = $response['choices'][0]['message']['content'] ?? null;

            if ($nutritionData) {

                // ```json や ``` を削除
                $cleanJson = preg_replace('/^```json\s*|\s*```$/', '', trim($nutritionData));


                return response()->json(json_decode($cleanJson, true));
            } else {
                return response()->json(['error' => 'Failed to parse nutrition data'], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to retrieve data from ChatGPT API'], 500);
        }
    }

    public function accessChatgptApi($mealContent)
    {
        // 環境変数からAPIキーを取得
        $apiKey = env('OPENAI_API_KEY');

        // ChatGPT APIエンドポイント
        $url = "https://api.openai.com/v1/chat/completions";
    
        // CategoriesとSubcategoriesをデータベースから取得
        $categories = Category::pluck('name')->toArray();
        $subcategories = Subcategory::pluck('name')->toArray();
    
        // プロンプトを生成
        $prompt = "
    You are a nutritional analysis assistant. Calculate the nutritional intake from the given meal based on the following categories and subcategories. Ensure all nutritional units are aligned with the standard units from the USDA FoodData Central. For the Vitamins and Minerals in the Major Nutrients section, calculate and output only their total amounts in mg. Do not include detailed breakdowns of individual vitamins or minerals in the Major Nutrients section. Output the results in JSON format.
    
    ### Categories:
    - " . implode(", ", $categories) . "
    
    ### Subcategories:
    - " . implode(", ", $subcategories) . "
    
    ### Meal:
    - " . $mealContent . "

    ### Important Rules:
    1. If the meal is valid (e.g., \"Grilled chicken with rice and vegetables\"), calculate the nutritional values normally.
    2. **Always include the \"Subcategories\" key in the JSON output.** If there are no subcategories, return \"Subcategories\": {} instead of omitting it.
    3. **Each category and subcategory must be included in the output.** If a nutrient is negligible, return \"0g\" or \"0mg\", but do not omit it.
    4. **Output must strictly follow the JSON format and must not contain any explanations or unnecessary text.**
    5. If the meal is meaningless, nonsensical, generic (e.g., \"test\", \"no meal\", \"unknown\", \"random\", \"nothing\", \"food\", \"meal\"), return the following JSON:
    {
        \"error\": \"Meal not recognized\"
    }
    
    ### Example Valid Output:
    {
        \"Protein\": \"30g\",
        \"Fat\": \"20g\",
        \"Carbohydrates\": \"40g\",
        \"Vitamins\": \"30mg\",
        \"Minerals\": \"50mg\",
        \"Subcategories\": {
            \"Valine\": \"2g\",
            \"Isoleucine\": \"1.5g\",
            \"Leucine\": \"1.8g\",
            \"Lysine\": \"2g\"
        }
    }
    
    ";

    \Log::info('Generated Prompt:', ['prompt' => $prompt]);
    
        try {
            // APIリクエストを送信
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($url, [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a nutritional analysis assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 2000,
                'temperature' => 0.5,
            ]);
    
            $responseData = $response->json();
    
            \Log::info('Response body:', ['body' => $response->body()]);

            // ChatGPTのレスポンスを確認
            if (isset($responseData['error']) && $responseData['error'] === "Meal not recognized") {
                return response()->json(['error' => 'Your meal is not recognized.'], 400);
            }
    
            return $responseData;
        } catch (\Exception $e) {
            // 例外をログに記録
            \Log::error('ChatGPT API exception:', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
