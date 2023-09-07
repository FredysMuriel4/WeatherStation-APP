<?php

namespace App\Http\Traits;
use App\Models\ConsultationHistory;

trait ConsultationHistoryTrait
{
    public function storeConsultationHistory($ip, $consult)
    {
        try {
            $store_history = new ConsultationHistory();

            $store_history->ip = $ip;
            $store_history->consult = json_encode($consult);

            $store_history->save();

            return [
                'state' => 201,
                'data' => $store_history,
                'error' => '',
                'message' => 'Data'
            ];
        } catch (\Exception $e) {
            return [
                'state' => 500,
                'error' => $e->getMessage(),
                'message' => 'Server error'
            ];
        }
    }
}
