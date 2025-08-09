<?php

namespace App\Http\Controllers\Category;

use Illuminate\Http\Request;
use App\Models\ClientCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientCategoryRequest;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    public function index()
    {
        $data = self::getData();
        return view('category.company.index', $data);
    }
    public function create()
    {
        $quick_add = request()->quick_add;
        if (request()->ajax() and $quick_add == 1) {
            $modal = request()->modal;
            return view('category.company.create_modal', compact('modal'));
        }
        return view('category.company.create');
    }

    public static function getData(): array
    {
        $data = [];
        $data['company_categories'] = ClientCategory::where('type', 'company')->get();
        return $data;
    }
    public static function findById($id): object
    {
        return ClientCategory::first($id);
    }

    public function store(ClientCategoryRequest $request)
    {
        if (!$request->json()) {
            abort(404);
        }
        $model = new ClientCategory();
        $model->name = $request->name;
        $model->description = $request->description;
        $model->plaintiff = $request->plaintiff ? 1 : 0;
        $model->type = 'company';
        $model->save();

        $response = [
            'model' => $model,
            'message' => __('client.Company Category Added Successfully'),
        ];

        if ($request->quick_add == 1) {
            $response['appendTo'] = '#client_category_id';
        }

        return response()->json($response);

        return response()->json($response);
    }


    public function show($id)
    {
        $model = self::findById($id);
        return view('category.company.show', compact('model'));
    }

    public function edit($id)
    {
        $model = self::findById($id);
        return view('category.company.edit', compact('model'));
    }


    public function update(ClientCategoryRequest $request, $id)
    {
        if (!$request->json()) {
            abort(404);
        }

        $validate_rules = [
            'name' => 'required|max:191|string',
            'description' => 'sometimes|nullable|max:1500|string',
        ];

        $request->validate($validate_rules, validationMessage($validate_rules));

        $model = self::findById($id);
        if (!$model) {
            throw ValidationException::withMessages(['message' => __('client.Company Category Not Found')]);
        }

        $model->name = $request->name;
        $model->description = $request->description;
        $model->plaintiff = $request->plaintiff ? 1 : 0;
        $model->save();

        $response = [
            'message' => __('client.Company Category Updated Successfully'),
            'goto' => route('category.company.index'),
        ];

        return response()->json($response);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->json()) {
            abort(404);
        }

        $model = ClientCategory::with('cases')->find($id);
        if (!$model) {
            throw ValidationException::withMessages(['message' => __('client.Company Category Not Found')]);
        }

        if ($model->cases()->count()) {
            throw ValidationException::withMessages(['message' => __('client.Company category assign with cases.')]);
        }

        $model->delete();

        return response()->json(['message' => __('client.Company Category Deleted Successfully'), 'goto' => route('category.company.index')]);
    }
}
