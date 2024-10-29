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
            'food_name'    => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'food_type'    => 'required|in:breakfast,lunch,dinner,snack', // Restricting to the enum values
            'portion'      => 'nullable|string|max:255',
            'calories'     => 'nullable|numeric',
            'protein'      => 'nullable|numeric',
            'fat'          => 'nullable|numeric',
            'carbohydrate' => 'nullable|numeric',
            'sugar'        => 'nullable|numeric',
            'cholesterol'  => 'nullable|numeric',
            'mass'         => 'nullable|numeric',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $errorMessages = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errorMessages);
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
            'food_name'    => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'food_type'    => 'required|in:breakfast,lunch,dinner,snack', // Restricting to the enum values
            'portion'      => 'nullable|string|max:255',
            'calories'     => 'nullable|numeric',
            'protein'      => 'nullable|numeric',
            'fat'          => 'nullable|numeric',
            'carbohydrate' => 'nullable|numeric',
            'sugar'        => 'nullable|numeric',
            'cholesterol'  => 'nullable|numeric',
            'mass'         => 'nullable|numeric',
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

    public function getRecipes(Request $request)
    {
        $foodName = $request->query('food_name');
        $recipes = Recipe::when($foodName, function ($query, $foodName) {
            return $query->where('food_name', 'like', "%$foodName%");
        })->get();

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

    public function storeRecipe(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'food_name'    => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'food_type'    => 'required|in:breakfast,lunch,dinner,snack', // Restricting to the enum values
            'portion'      => 'nullable|string|max:255',
            'calories'     => 'nullable|numeric',
            'protein'      => 'nullable|numeric',
            'fat'          => 'nullable|numeric',
            'carbohydrate' => 'nullable|numeric',
            'sugar'        => 'nullable|numeric',
            'cholesterol'  => 'nullable|numeric',
            'mass'         => 'nullable|numeric',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: $validation->errors()->first()
            );

            return response()->json($response->toArray(), 400);
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

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Success create recipe'
        );

        return response()->json($response->toArray(), 201);
    }

    public function updateRecipe(Request $request, $id)
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

        $validation = Validator::make($request->all(), [
            'food_name'    => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'food_type'    => 'required|in:breakfast,lunch,dinner,snack', // Restricting to the enum values
            'portion'      => 'nullable|string|max:255',
            'calories'     => 'nullable|numeric',
            'protein'      => 'nullable|numeric',
            'fat'          => 'nullable|numeric',
            'carbohydrate' => 'nullable|numeric',
            'sugar'        => 'nullable|numeric',
            'cholesterol'  => 'nullable|numeric',
            'mass'         => 'nullable|numeric',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: $validation->errors()->first()
            );

            return response()->json($response->toArray(), 400);
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

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success update recipe'
        );

        return response()->json($response->toArray(), 200);
    }
}
