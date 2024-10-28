<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MedicineLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineLogController extends Controller
{
    public function getAll()
    {
        $foodIntakes = MedicineLog::with('medicine')->where('user_id', auth()->user()->id)->get();
        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all medicine logs',
            data: $foodIntakes
        );

        return response()->json($response->toArray(), 200);
    }

    public function getById($id)
    {
        $foodIntake = MedicineLog::with('medicine')->where('user_id', auth()->user()->id)->find($id);

        if (!$foodIntake) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Drink log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get medicine log by ID',
            data: $foodIntake
        );

        return response()->json($response->toArray(), 200);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);

        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|exists:m_user,id',
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|numeric',
            'datetime' => 'required|date',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: $validator->errors()->first()
            );

            return response()->json($response->toArray(), 400);
        }

        $medicineLog = MedicineLog::create($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Success create medicine log',
            data: $medicineLog
        );

        return response()->json($response->toArray(), 201);
    }

    public function update(Request $request, $id)
    {
        $medicineLog = MedicineLog::where('user_id', auth()->user()->id)->find($id);

        if (!$medicineLog) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Medicine log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $validator = Validator::make($request->all(), [
            'medicine_id' => 'exists:medicines,id',
            'quantity' => 'numeric',
            'datetime' => 'date',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: $validator->errors()->first()
            );

            return response()->json($response->toArray(), 400);
        }

        $medicineLog->update($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success update medicine log',
            data: $medicineLog
        );

        return response()->json($response->toArray(), 200);
    }

    public function delete($id)
    {
        $medicineLog = MedicineLog::where('user_id', auth()->user()->id)->find($id);

        if (!$medicineLog) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Medicine log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $medicineLog->delete();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success delete medicine log'
        );

        return response()->json($response->toArray(), 200);
    }
}
