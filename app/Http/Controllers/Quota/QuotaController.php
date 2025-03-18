<?php

declare(strict_types=1);

namespace App\Http\Controllers\Quota;

use App\Http\Requests\Quota\QuotaRequest;
use App\Models\Quota\Quota;
use App\Models\Credit\Credit;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class QuotaController extends Controller
{
    /**
     * Store a newly created quota.
     */
    public function store(QuotaRequest $request): JsonResponse
    {
        $credit = Credit::findOrFail($request->input('creditId'));

        // Verificar que no haya más cuotas de las permitidas
        if ($credit->quotas()->count() >= $credit->installments) {
            return response()->json(['message' => 'No se pueden agregar más cuotas que las establecidas en el crédito.'], Response::HTTP_BAD_REQUEST);
        }

        // Verificar que el monto no exceda el saldo del crédito
        $remainingAmount = $credit->amount - $credit->quotas()->sum('amount');
        if ($request->input('amount') > $remainingAmount) {
            return response()->json(['message' => 'El monto de la cuota excede el saldo restante del crédito.'], Response::HTTP_BAD_REQUEST);
        }

        $quota = Quota::create([
            'id'        => Str::uuid(),
            'creditId'  => $credit->id,
            'amount'    => $request->input('amount'),
            'dueDate'   => $request->input('dueDate'),
            'status'    => 'Pendiente',
        ]);

        return response()->json(['message' => 'Quota created successfully', 'quota' => $quota], Response::HTTP_CREATED);
    }

    /**
     * Update an existing quota.
     */
    public function update(QuotaRequest $request, string $id): JsonResponse
    {
        $quota = Quota::findOrFail($id);
        
        // Permitir actualizar solo el estado si la cuota está pagada
        if ($quota->status === 'Pagado') {
            $quota->update($request->only(['status']));
            return response()->json(['message' => 'Quota status updated successfully', 'quota' => $quota], Response::HTTP_OK);
        }

        // Verificar que el nuevo monto no exceda el saldo restante del crédito
        $credit = $quota->credit;
        $remainingAmount = $credit->amount - $credit->quotas()->where('id', '!=', $id)->sum('amount');
        if ($request->input('amount') > $remainingAmount) {
            return response()->json(['message' => 'El nuevo monto de la cuota excede el saldo restante del crédito.'], Response::HTTP_BAD_REQUEST);
        }

        $quota->update($request->only(['amount', 'dueDate', 'status']));

        return response()->json(['message' => 'Quota updated successfully', 'quota' => $quota], Response::HTTP_OK);
    }

    /**
     * Delete a quota.qu
     */
    public function delete(string $id): JsonResponse
    {
        $quota = Quota::findOrFail($id);

        // No permitir eliminar una cuota pagada
        if ($quota->status === 'Pagado') {
            return response()->json(['message' => 'No se puede eliminar una cuota que ya ha sido pagada.'], Response::HTTP_BAD_REQUEST);
        }

        // Verificar que no sea la última cuota
        if ($quota->credit->quotas()->count() <= 1) {
            return response()->json(['message' => 'No se puede eliminar la última cuota de un crédito.'], Response::HTTP_BAD_REQUEST);
        }

        $quota->delete();

        return response()->json(['message' => 'Quota deleted successfully'], Response::HTTP_OK);
    }
}