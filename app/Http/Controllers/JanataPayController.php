<?php
namespace App\Http\Controllers;

use App\Services\JanataPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class JanataPayController extends Controller
{
    public function callback(
        Request $request,
        JanataPayService $janataPay
    ) {
        $referenceId = $request->query('refid');

        if (!$referenceId) {
            return redirect('/payment-result?status=invalid');
        }

        try {
            // Never trust the callback alone.
            // Always verify directly with JanataPay.
            $result = $janataPay->verifyAndSave($referenceId);

            return redirect(
                '/payment-result?status=' . $result['status']
            );

        } catch (Throwable $e) {

            // Do not log tokens, AES keys, passwords or credentials.
            Log::error('JanataPay callback verification failed', [
                'reference_id' => $referenceId,
                'error' => $e->getMessage(),
            ]);

            return redirect('/payment-result?status=pending');
        }
    }
}
