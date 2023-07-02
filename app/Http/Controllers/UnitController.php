<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\unit;
use Ramsey\Uuid\Type\Integer;

class UnitController extends Controller
{
    public function getAllUnit(Request $request)
    {
        $unit = unit::all();
        return response()->json(["status" => "ok", "data" => $unit], 200);
    }

    public function getAllUnitQuestions(Request $request, string $id)
    {
        $unit = unit::find($id)->questions;
        return response()->json(["status" => "ok", "data" => $unit], 200);
    }
}
