<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\DrinkLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrinkLogController extends Controller
{
    public function getAll()
    {
        $foodIntakes = DrinkLog::where('user_id', auth()->user()->id)->get();
        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all drink logs',
            data: $foodIntakes
        );

        return response()->json($response->toArray(), 200);
    }

    public function getById($id)
    {
        $foodIntake = DrinkLog::where('user_id', auth()->user()->id)->find($id);

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
            message: 'Success get drink log by ID',
            data: $foodIntake
        );

        return response()->json($response->toArray(), 200);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);

        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|exists:m_user,id',
            'drink_name'   => 'required|string',
            'amount'       => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Invalid input',
                data: $validator->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $drinkLog = DrinkLog::create($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Success store drink log',
            data: $drinkLog
        );

        return response()->json($response->toArray(), 201);
    }

    public function update(Request $request, $id)
    {
        $drinkLog = DrinkLog::where('user_id', auth()->user()->id)->find($id);

        if (!$drinkLog) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Drink log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $validator = Validator::make($request->all(), [
            'drink_name'   => 'required|string',
            'amount'       => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Invalid input',
                data: $validator->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $drinkLog->update($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success update drink log',
            data: $drinkLog
        );

        return response()->json($response->toArray(), 200);
    }

    public function delete($id)
    {
        $drinkLog = DrinkLog::where('user_id', auth()->user()->id)->find($id);

        if (!$drinkLog) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Drink log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $drinkLog->delete();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success delete drink log'
        );

        return response()->json($response->toArray(), 200);
    }
}
