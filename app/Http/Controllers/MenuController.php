<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все элементы меню из базы данных
        $menus = Menu::all();

        // Возвращаем представление с меню
        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Получаем родительские меню для выпадающего списка
        $parentMenus = Menu::all();
        return view('menus.create', compact('parentMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'position' => 'required|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'is_active' => 'required|boolean',
        ]);

        // Отладка
        //dd($request->all());

        Menu::create($request->only(['name', 'url', 'position', 'parent_id', 'is_active']));

        return redirect()->route('menus.index')->with('success', 'Меню добавлено успешно.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        // Возвращаем представление с меню
        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        // Получаем родительские меню для выпадающего списка
        $parentMenus = Menu::all();
        return view('menus.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url', // Добавьте валидацию для URL
            'position' => 'nullable|integer', // Валидация для позиции (целое число)
            'parent_id' => 'nullable|exists:menus,id', // Валидация для родительского элемента
            'is_active' => 'required|boolean',
        ]);

        $menu->update($request->only(['name', 'url', 'position', 'parent_id', 'is_active']));

        return redirect()->route('menus.index')->with('success', 'Меню обновлено успешно!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Меню удалено успешно!');
    }
}
