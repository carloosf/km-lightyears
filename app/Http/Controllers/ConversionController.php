<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class ConversionController extends Controller
{
    public function convertToLightYears(Request $request)
    {
        try {
            $request->validate([
                'quilometros' => 'required|numeric|min:0',
            ]);

            $kilometers = $request->quilometros;
            $lightYears = $kilometers / 9460730472580.8;

            $lightYears = round($lightYears, 4);

            return response()->json([
                'anosLuz' => $lightYears
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 400);
        }
    }

    public function convertToKilometers(Request $request)
    {
        try {
            $request->validate([
                'anosLuz' => 'required|numeric|min:0',
            ]);

            $lightYears = $request->anosLuz;
            $kilometers = $lightYears * 9460730472580.8;

            $kilometers = round($kilometers, 4);

            return response()->json([
                'quilometros' => $kilometers
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 400);
        }
    }
}
