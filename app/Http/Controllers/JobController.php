<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function failedJob()
    {
        $failedJobs = DB::table('failed_jobs')->get();
        if ($failedJobs->isEmpty()) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Failed job not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all failed jobs',
            data: $failedJobs
        );

        return response()->json($response->toArray(), 200);
    }

    public function index()
    {
        $successJobs = DB::table('jobs')->get();
        if ($successJobs->isEmpty()) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'job not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all jobs',
            data: $successJobs
        );

        return response()->json($response->toArray(), 200);
    }
}
