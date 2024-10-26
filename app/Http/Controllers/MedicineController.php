<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.medicine.index', compact('medicines'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validation->fails()) {
            Alert::error('Error', 'Please fill all the required fields');
            return redirect()->back()->withErrors($validation)->withInput();
        }

        Medicine::create($request->all());

        Alert::success('Success', 'Medicine added successfully');
        return redirect()->route('admin.medicine.index');
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validation->fails()) {
            Alert::error('Error', 'Please fill all the required fields');
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $medicine->update($request->all());

        Alert::success('Success', 'Medicine updated successfully');
        return redirect()->route('admin.medicine.index');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        Alert::success('Success', 'Medicine deleted successfully');
        return redirect()->route('admin.medicine.index');
    }

    public function getMedicines()
    {
        $exercises = Medicine::all();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all medicines',
            data: $exercises
        );
        
        return response()->json($response->toArray(), 200);
    }

    public function getMedicineById($id)
    {
        $medicine = Medicine::find($id);

        if (!$medicine) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Medicine not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get medicine by ID',
            data: $medicine
        );

        return response()->json($response->toArray(), 200);
    }
}
