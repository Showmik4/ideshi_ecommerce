<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    use ImageTrait;

    public function show()
    {
        return view('menu.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $menu = Menu::with('page', 'parentMenu')->get();
        return datatables()->of($menu)
            ->addColumn('imageLink', function (Menu $menu){
                if (isset($menu->imageLink)) {
                    return '<img height="50px" width="50px" src="'.url($menu->imageLink).'" alt="">';
                }
                return '';
            })
            ->addColumn('fkPageId', function (Menu $menu){
                if (isset($menu->fkPageId)) {
                    return @$menu->page->pageTitle;
                }
                return '';
            })
            ->addColumn('parent', function (Menu $menu){
                if (isset($menu->parent)) {
                    return @$menu->parentMenu->menuName;
                }
                return '';
            })
            ->addColumn('status', function (Menu $menu){
                if ($menu->status === 'active') {
                    return '<label class="btn btn-success">Active</label>';
                }
                return '<label class="btn btn-danger">Inactive</label>';
            })
            ->setRowAttr([
                'align'=>'center',
            ])
            ->rawColumns(['imageLink', 'status'])
            ->make(true);
    }

    public function create()
    {
        $menus = Menu::query()->where('parent', null)->where('fkPageId', null)->get();
        $pages = Page::query()->where('status', 'active')->get();
        return view('menu.create', compact('menus', 'pages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'menuName' => 'required|string|max:255',
            // 'parent' => 'nullable|numeric',
            'menuOrder' => 'required|numeric',
            'menuType' => 'required|string|max:50',
            // 'imageLink' => 'nullable|image|mimes:jpeg,png,jpg',
            'fkPageId' => 'nullable|numeric',
            'status' => 'required|string|max:45',
        ]);

        Menu::query()->create([
            'menuName' => $validated['menuName'],
            // 'parent' => $validated['parent'],
            'menuOrder' => $validated['menuOrder'],
            'menuType' => $validated['menuType'],
            // 'imageLink' => isset($validated['imageLink']) ? $this->save_image('menuImage', $validated['imageLink']) : null,
            'fkPageId' => $validated['fkPageId'],
            'status' => $validated['status'],
        ]);

        Session::flash('success', 'Menu Created Successfully!');
        return redirect()->route('menu.show');
    }

    public function edit($menuId)
    {
        $menus = Menu::query()->where('parent', null)->where('fkPageId', null)->get();
        $pages = Page::query()->where('status', 'active')->get();
        $menu = Menu::query()->where('menuId', $menuId)->first();
        return view('menu.edit', compact( 'menu', 'pages', 'menus'));
    }

    public function update(Request $request, $menuId): RedirectResponse
    {
        $validated = $this->validate($request, [
            'menuName' => 'required|string|max:255',
            // 'parent' => 'nullable|numeric',
            'menuOrder' => 'required|numeric',
            // 'menuType' => 'required|string',
            // 'imageLink' => 'nullable|image|mimes:jpeg,png,jpg',
            'fkPageId' => 'nullable|numeric',
            'status' => 'required|string|max:45',
        ]);        

        $menu = Menu::query()->where('menuId', $menuId)->first();
        if(!empty($menu)) {
            // if (empty($validated['imageLink'])) {
            //     $imageLink = $menu->imageLink;
            // } else {
            //     $this->deleteImage($menu->imageLink);
            //     $imageLink = $this->save_image('menuImage', $validated['imageLink']);
            // }

            $menu->update([
                'menuName' => $validated['menuName'],              
                'menuOrder' => $validated['menuOrder'],
                'menuType' => $request->input('menuType'),                
                'fkPageId ' => $validated['fkPageId'],
                'status' => $validated['status'],
            ]);       
          
        }

        Session::flash('success', 'Menu Updated Successfully!');
        return redirect()->route('menu.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $menu = Menu::query()->where('menuId', $request->menuId)->first();
        if (!empty($menu)) {
            Menu::query()->where('parent', $request->menuId)->delete();
            $menu->delete();
        }
        return response()->json();
    }

    public function checkParentType(Request $request)
    {
        $parentMenuType = Menu::query()->where('menuId', $request->menuId)->first()->menuType;
        return response()->json(['parentMenuType' => $parentMenuType]);
    }
}
