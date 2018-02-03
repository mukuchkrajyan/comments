<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class CommentsController extends BaseController
{
    protected $view = 'comments.';


    /**
     *  Display a listing of items.
     * @return mixed
     */

    public function index($item_id)
    {
        // $comments = Picture::orderBy('id', 'desc')->paginate(1);


        $comments =  Comment::where('item_id', $item_id);
        //dd($comments->count());
        //Comment::where('item_id', $item_id)->paginate(10);


        return $this->view($this->view . 'dashboard', compact('comments'));
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
        $picture = Picture::find($id);

        if (is_null($picture)) {
            flash('Current Item doesn\'t exist', 'danger');

            return redirect()->back();
        }

        return $this->view($this->view . 'show', compact('picture'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function edit($id)
    {

    }

    /**
     * @param UpdatePicturesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePicturesRequest $request)
    {

    }

    /**
     * Remove the specified item from storage.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Picture::findOrNew($id)->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    }

}
