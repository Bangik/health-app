<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.recipe.index', compact('recipes'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'food_name'    => 'nullable|string|max:255',
            'description'  => 'nullable|string|max:255',
            'food_type'    => 'nullable|in:breakfast,lunch,dinner,snack', // Restricting to the enum values
            'portion'      => 'nullable|string|max:255',
            'calories'     => 'nullable|string|max:255',
            'protein'      => 'nullable|string|max:255',
            'fat'          => 'nullable|string|max:255',
            'carbohydrate' => 'nullable|string|max:255',
            'sugar'        => 'nullable|string|max:255',
            'cholesterol'  => 'nullable|string|max:255',
            'mass'         => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            Alert::error('Error', 'Please fill all the required fields');
            return redirect()->back()->withErrors($validation)->withInput();
        }

        Recipe::create([
            'food_name'    => $request->food_name,
            'description'  => $request->description,
            'food_type'    => $request->food_type,
            'portion'      => $request->portion,
            'calories'     => $request->calories,
            'protein'      => $request->protein,
            'fat'          => $request->fat,
            'carbohydrate' => $request->carbohydrate,
            'sugar'        => $request->sugar,
            'cholesterol'  => $request->cholesterol,
            'mass'         => $request->mass,
            'image'        => $request->hasFile('image') ? $request->file('image')->store('images/recipe', 'public') : null,
        ]);

        Alert::success('Success', 'Recipe added successfully');
        return redirect()->route('admin.recipe.index');
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validation = Validator::make($request->all(), [
            'food_name'    => 'nullable|string|max:255',
            'description'  => 'nullable|string|max:255',
            'food_type'    => 'nullable|in:breakfast,lunch,dinner,snack', // Restricting to the enum values
            'portion'      => 'nullable|string|max:255',
            'calories'     => 'nullable|string|max:255',
            'protein'      => 'nullable|string|max:255',
            'fat'          => 'nullable|string|max:255',
            'carbohydrate' => 'nullable|string|max:255',
            'sugar'        => 'nullable|string|max:255',
            'cholesterol'  => 'nullable|string|max:255',
            'mass'         => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            // convert array to string
            $errorMessages = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errorMessages);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // Delete the image if it exists
        if ($recipe->image && $request->hasFile('image')) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->update([
            'food_name'    => $request->food_name,
            'description'  => $request->description,
            'food_type'    => $request->food_type,
            'portion'      => $request->portion,
            'calories'     => $request->calories,
            'protein'      => $request->protein,
            'fat'          => $request->fat,
            'carbohydrate' => $request->carbohydrate,
            'sugar'        => $request->sugar,
            'cholesterol'  => $request->cholesterol,
            'mass'         => $request->mass,
            'image'        => $request->hasFile('image') ? $request->file('image')->store('images/recipe', 'public') : $recipe->image,
        ]);

        Alert::success('Success', 'Recipe updated successfully');
        return redirect()->route('admin.recipe.index');
    }

    public function destroy(Recipe $recipe)
    {
        // Delete the image if it exists
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }
        $recipe->delete();

        Alert::success('Success', 'Recipe deleted successfully');
        return redirect()->route('admin.recipe.index');
    }

    public function getRecipes()
    {
        $recipes = Recipe::all();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all recipes',
            data: $recipes
        );

        return response()->json($response->toArray(), 200);
    }

    public function getRecipeById($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Recipe not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get recipe',
            data: $recipe
        );

        return response()->json($response->toArray(), 200);
    }
}
