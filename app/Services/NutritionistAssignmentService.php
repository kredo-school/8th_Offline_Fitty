<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\NutritionistAssign;
use Illuminate\Support\Facades\DB;

class NutritionistAssignmentService
{
    public function assignNutritionist()
    {
        DB::beginTransaction();
        try {
            // 最後に割り当てた栄養士のIDを取得（NULLのときは0にする）
            $lastAssigned = NutritionistAssign::latest()->value('last_assigned_nutritionist_id') ?: 0;
        
            // 次の栄養士を取得 (ラウンドロビン)
            $nextNutritionist = User::where('role', 'N')
                ->where('id', '>', $lastAssigned) // NULLのときに id > NULL にならないよう修正
                ->orderBy('id')
                ->first();
        
            // すべての栄養士が割り当てられた場合、最初の栄養士に戻る
            if (!$nextNutritionist) {
                $nextNutritionist = User::where('role', 'N')->orderBy('id')->first();
            }
        
            if (!$nextNutritionist) {
                throw new \Exception("No nutritionists found.");
            }
        
            // 割り当て情報を nutritionist_assign_tbl に保存
            NutritionistAssign::updateOrCreate([], ['last_assigned_nutritionist_id' => $nextNutritionist->id]);
        
            DB::commit();
            return $nextNutritionist->id;
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
        
    }
}
