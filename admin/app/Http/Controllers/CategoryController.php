<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('category.index');
    }

    /**
     * @throws \Exception
     */
    public function list()
    {
        $category = Category::with('parentCategory')->get();
        return datatables()->of($category)
            ->addColumn('homeShow', function (Category $category){
                if ($category->homeShow === 1) {
                    return '<i class="fa fa-check"></i>';
                }
                return '';
            })
            ->addColumn('parent', function (Category $category){
                if (isset($category->parent)) {
                    return @$category->parentCategory->categoryName;
                }
                return '';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['homeShow'])
            ->make(true);
    }

    public function create()
    {
        $categories = Category::query()->where('parent', null)->get();
        return view('category.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'categoryName' => 'required|string|max:255',
            'parent' => 'nullable|numeric',
//            'subParent' => 'nullable|numeric',
            'homeShow' => 'nullable|numeric',
            'imageLink' => 'required|image|mimes:jpeg,png,jpg',
            'bannerLink' => 'required|image|mimes:jpeg,png,jpg',
            'category_serial' => 'required|numeric',
            'gender' => 'required|in:Men,Women,Others',
        ]);

        Category::query()->create([
            'categoryName' => $validated['categoryName'],
            'parent' => $validated['parent'],
//            'subParent' => $validated['subParent'],
            'homeShow' => $validated['homeShow'] ?? null,
            'imageLink' => $this->save_image('categoryImage', $validated['imageLink']),
            'bannerLink' => $this->save_image('categoryImage', $validated['bannerLink']),
            'category_serial' => $validated['category_serial'],
            'gender' => $validated['gender'],
        ]);

        Session::flash('success', 'Category Created Successfully!');
        return redirect()->route('category.show');
    }

    public function edit($categoryId)
    {
        $categories = Category::query()->where('parent', null)->get();
        $category = Category::query()->where('categoryId', $categoryId)->first();
        return view('category.edit', compact( 'category', 'categories'));
    }

    public function update(Request $request, $categoryId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'categoryName' => 'required|string|max:255',
            'parent' => 'nullable|numeric',
//            'subParent' => 'nullable|numeric',
            'homeShow' => 'nullable|numeric',
            'imageLink' => 'nullable|image|mimes:jpeg,png,jpg',
            'bannerLink' => 'nullable|image|mimes:jpeg,png,jpg',
            'category_serial' => 'required|numeric',
        ]);

        $category = Category::query()->where('categoryId', $categoryId)->first();
        if(!empty($category)) {
            if (empty($validated['imageLink'])) {
                $imageLink = $category->imageLink;
            } else {
                $this->deleteImage($category->imageLink);
                $imageLink = $this->save_image('categoryImage', $validated['imageLink']);
            }

            if (empty($validated['bannerLink'])) {
                $bannerLink = $category->bannerLink;
            } else {
                $this->deleteImage($category->bannerLink);
                $bannerLink = $this->save_image('categoryImage', $validated['bannerLink']);
            }

            $category->update([
                'categoryName' => $validated['categoryName'],
                'parent' => $validated['parent'],
//                'subParent' => $validated['subParent'],
                'homeShow' => $validated['homeShow'] ?? null,
                'imageLink' => $imageLink,
                'bannerLink' => $bannerLink,
                'category_serial' => $validated['category_serial'],
            ]);
        }

        Session::flash('success', 'Category Updated Successfully!');
        return redirect()->route('category.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $category = Category::query()->where('categoryId', $request->categoryId)->first();
        if (!empty($category)) {
            Category::query()->where('parent', $request->categoryId)->delete();
            $category->delete();
        }
        return response()->json();
    }
}
