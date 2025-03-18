<?php

declare(strict_types=1);

namespace App\Http\Controllers\Credit;

use App\Http\Requests\Credit\CreditRequest;
use App\Models\Credit\Credit;
use App\Models\Quota\Quota;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CreditController extends Controller
{
    /**
     * Store a newly created credit and generate associated quotas.
     */
    public function store(CreditRequest $request): JsonResponse
    {
        // Crear el crédito
        $credit = Credit::create([
            'id'          => Str::uuid(),
            'userId'      => $request->input('userId'),
            'amount'      => $request->input('amount'),
            'installments' => $request->input('installments'),
        ]);

        // Calcular el monto de cada cuota
        $installments = $credit->installments;
        $quotaAmount = round($credit->amount / $installments, 2);

        // Crear las cuotas asociadas
        $quotas = [];
        $dueDate = Carbon::now()->addMonth(); // Primera cuota en un mes

        for ($i = 0; $i < $installments; $i++) {
            $quota = Quota::create([
                'id'        => Str::uuid(),
                'creditId'  => $credit->id,
                'amount'    => $quotaAmount,
                'dueDate'   => $dueDate,
                'status'    => 'Pendiente',
            ]);

            $quotas[] = $quota;
            $dueDate->addMonth(); // Sumar un mes para la siguiente cuota
        }

        return response()->json([
            'message' => 'Credit and quotas created successfully',
            'credit'  => $credit,
            'quotas'  => $quotas,
        ])->setStatusCode(Response::HTTP_OK);
    }

    public function update(CreditRequest $request, string $id): JsonResponse
    {
        $credit = Credit::with('quotas')->findOrFail($id);

        $oldAmount = $credit->amount;
        $oldInstallments = $credit->installments;

        // Verificar si hay cuotas pagadas
        if ($credit->quotas()->where('status', 'Pagado')->exists()) {
            return response()->json([
                'message' => 'No se puede actualizar el crédito porque tiene cuotas pagadas.',
            ], Response::HTTP_BAD_REQUEST);
        }

    
        $credit->update([
            'amount'      => $request->input('amount', $credit->amount),
            'installments' => $request->input('installments', $credit->installments),
        ]);

        if ($oldAmount != $credit->amount || $oldInstallments != $credit->installments) {

            
            $credit->quotas()->delete();

            $installments = $credit->installments;
            $quotaAmount = round($credit->amount / $installments, 2);

            $quotas = [];
            $dueDate = Carbon::now()->addMonth(); 

            for ($i = 0; $i < $installments; $i++) {
                $quota = Quota::create([
                    'id'        => Str::uuid(),
                    'creditId'  => $credit->id,
                    'amount'    => $quotaAmount,
                    'dueDate'   => $dueDate,
                    'status'    => 'Pendiente',
                ]);

                $quotas[] = $quota;
                $dueDate->addMonth(); 
            }
        } else {
            $quotas = $credit->quotas;
        }

        return response()->json([
            'message' => 'Credit updated successfully',
            'credit'  => $credit,
            'quotas'  => $quotas,
        ], Response::HTTP_OK);
    }
}
