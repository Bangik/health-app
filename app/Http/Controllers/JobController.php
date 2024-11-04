<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index()
    {
        $failedJobs = DB::table('failed_jobs')->get();

        if (!$failedJobs) {
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
    }
}
