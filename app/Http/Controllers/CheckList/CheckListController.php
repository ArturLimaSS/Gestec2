<?php

namespace App\Http\Controllers\CheckList;

use App\Http\Controllers\Controller;
use App\Models\CheckListModel;
use Illuminate\Http\Request;

class CheckListController extends Controller
{
    public function create(Request $request)
    {
        try {
            $checkList = CheckListModel::create($request->all());
            return response()->json($checkList, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $checkList = CheckListModel::find($request->checklist_id);
            if ($checkList) {
                $checkList->update($request->all());
                return response()->json($checkList, 200);
            } else {
                return response()->json(['error' => 'CheckList não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCheckList(Request $request)
    {
        try {
            $checkList = CheckListModel::where('empresa_id', $request->empresa_id)
                ->where('status', 'pendente')
                ->latest()
                ->first();

            if (!$checkList) {
                $checkList = CheckListModel::create(['empresa_id' => $request->empresa_id]);
                return response()->json(['questionario' => $checkList], 201);
            } else {
                return response()->json(['questionario' => $checkList], 200); // Retorna o resultado encontrado
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
