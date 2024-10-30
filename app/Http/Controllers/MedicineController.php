<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'type' => 'required|string|in:tablet,capsule,syrup,injection',
            'mass' => 'required|string',
            'how_to_use' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'indications' => 'nullable|string',
            'warnings' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validation->fails()) {
            $errors = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errors);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        Medicine::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'mass' => $request->mass,
            'how_to_use' => $request->how_to_use,
            'side_effects' => $request->side_effects,
            'indications' => $request->indications,
            'warnings' => $request->warnings,
            'image' => $request->hasFile('image') ? $request->file('image')->store('images/medicine', 'public') : null,
        ]);

        Alert::success('Success', 'Medicine added successfully');
        return redirect()->route('admin.medicine.index');
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:tablet,capsule,syrup,injection',
            'mass' => 'required|string',
            'how_to_use' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'indications' => 'nullable|string',
            'warnings' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validation->fails()) {
            $errors = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errors);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if ($request->hasFile('image') && $medicine->image) {
            if ($medicine->image !== 'default.jpg') {
                Storage::disk('public')->delete($medicine->image);
            }
        }

        $medicine->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'mass' => $request->mass,
            'how_to_use' => $request->how_to_use,
            'side_effects' => $request->side_effects,
            'indications' => $request->indications,
            'warnings' => $request->warnings,
            'image' => $request->hasFile('image') ? $request->file('image')->store('images/medicine', 'public') : $medicine->image,
        ]);

        Alert::success('Success', 'Medicine updated successfully');
        return redirect()->route('admin.medicine.index');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            if ($medicine->image !== 'default.jpg') {
                Storage::disk('public')->delete($medicine->image);
            }
        }

        $medicine->delete();
        Alert::success('Success', 'Medicine deleted successfully');
        return redirect()->route('admin.medicine.index');
    }

    public function getMedicines(Request $request)
    {
        $medicinName = $request->query('name');
        $exercises = Medicine::when($medicinName, function ($query, $medicinName) {
            return $query->where('name', 'like', "%$medicinName%");
        })->get();

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

    public function storeMedicine(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:tablet,capsule,syrup,injection',
            'mass' => 'required|string',
            'how_to_use' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'indications' => 'nullable|string',
            'warnings' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validation->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $medicine = Medicine::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'mass' => $request->mass,
            'how_to_use' => $request->how_to_use,
            'side_effects' => $request->side_effects,
            'indications' => $request->indications,
            'warnings' => $request->warnings,
            'image' => $request->hasFile('image') ? $request->file('image')->store('images/medicine', 'public') : null,
        ]);

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Medicine added successfully',
            data: $medicine
        );

        return response()->json($response->toArray(), 201);
    }

    public function updateMedicine(Request $request, $id)
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

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:tablet,capsule,syrup,injection',
            'mass' => 'required|string',
            'how_to_use' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'indications' => 'nullable|string',
            'warnings' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validation->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        if ($request->hasFile('image') && $medicine->image) {
            if ($medicine->image !== 'default.jpg') {
                Storage::disk('public')->delete($medicine->image);
            }
        }

        $medicine->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'mass' => $request->mass,
            'how_to_use' => $request->how_to_use,
            'side_effects' => $request->side_effects,
            'indications' => $request->indications,
            'warnings' => $request->warnings,
            'image' => $request->hasFile('image') ? $request->file('image')->store('images/medicine', 'public') : $medicine->image,
        ]);

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Medicine updated successfully',
            data: $medicine
        );

        return response()->json($response->toArray(), 200);
    }
}
