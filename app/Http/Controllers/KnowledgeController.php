<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MKnowledge;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    // Get all knowledge records
    public function getAll()
    {
        $knowledge = MKnowledge::all();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all knowledge',
            data: $knowledge
        );

        return response()->json($response->toArray(), 200);
    }

    // Get a specific knowledge record by ID
    public function getById($id)
    {
        $knowledge = MKnowledge::find($id);

        if (!$knowledge) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Knowledge not found'
            );
            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get knowledge by ID',
            data: $knowledge
        );

        return response()->json($response->toArray(), 200);
    }
}

