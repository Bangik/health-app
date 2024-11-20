<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function failedJob()
    {
        $failedJobs = DB::table('failed_jobs')->paginate(20);
        if ($failedJobs->isEmpty()) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Failed job not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $failedJobs->through(function ($job) {
            $job->failed_at = date('Y-m-d H:i:s', $job->failed_at);
            return $job;
        });

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all failed jobs',
            data: $failedJobs->items(),
            meta: [
                'total' => $failedJobs->total(),
                'per_page' => $failedJobs->perPage(),
                'current_page' => $failedJobs->currentPage(),
                'last_page' => $failedJobs->lastPage(),
            ]
        );

        return response()->json($response->toArray(), 200);
    }

    public function index()
    {
        $successJobs = DB::table('jobs')->paginate(20);
        if ($successJobs->isEmpty()) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'job not found'
            );

            return response()->json($response->toArray(), 404);
        }

        // map available and created_at timestamp to human readable date
        $successJobs->through(function ($job) {
            $job->available_at = date('Y-m-d H:i:s', $job->available_at);
            $job->created_at = date('Y-m-d H:i:s', $job->created_at);
            return $job;
        });

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all jobs',
            data: $successJobs->items(),
            meta: [
                'total' => $successJobs->total(),
                'per_page' => $successJobs->perPage(),
                'current_page' => $successJobs->currentPage(),
                'last_page' => $successJobs->lastPage(),
            ]
        );

        return response()->json($response->toArray(), 200);
    }
}
