<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MKnowledge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class KnowledgeController extends Controller
{
    public function index()
    {
        $knowledges = MKnowledge::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.knowledge.index', compact('knowledges'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $erros = implode(', ', $validation->errors()->all());
            Alert::error('Error', $erros);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        MKnowledge::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'image' => $request->hasFile('image') ? $request->file('image')->store('images/knowledge', 'public') : null,
        ]);

        Alert::success('Success', 'Knowledge added successfully');
        return redirect()->route('admin.knowledge.index');
    }

    public function update(Request $request, MKnowledge $knowledge)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $erros = implode(', ', $validation->errors()->all());
            Alert::error('Error', $erros);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // delete old image
        if ($request->hasFile('image') && $knowledge->image) {
            Storage::disk('public')->delete($knowledge->image);
        }

        $knowledge->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'image' => $request->hasFile('image') ? $request->file('image')->store('images/knowledge', 'public') : $knowledge->image,
        ]);

        Alert::success('Success', 'Knowledge updated successfully');
        return redirect()->route('admin.knowledge.index');
    }

    public function destroy(MKnowledge $knowledge)
    {
        if ($knowledge->image) {
            Storage::disk('public')->delete($knowledge->image);
        }

        $knowledge->delete();

        Alert::success('Success', 'Knowledge deleted successfully');
        return redirect()->route('admin.knowledge.index');
    }

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

