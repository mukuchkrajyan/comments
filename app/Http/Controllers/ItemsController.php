<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class ItemsController extends BaseController
{
    protected $view = 'items.';


    /**
     *  Display a listing of items.
     * @return mixed
     */

    public function index(Request $request)
    {
        if ($request->get('per_page')) {
            $per_page = $request->get('per_page');
        } else {
            $per_page = 4;
        }
        //print_r($per_page);
        $items = Item::orderBy('id', 'desc')->paginate($per_page);
//dd($items);
        return $this->view($this->view . 'dashboard', compact('items','per_page'));
    }

    /**
     * Show the form for creating a new item.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return $this->view($this->view . 'create');
    }


    /*
    * Store a newly created item in storage.
    * @param UpdateRequest $request
    */
    public function store(Create $request)
    {


    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function edit($id)
    {

    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified item from storage.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Item::findOrNew($id)->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    }

}
