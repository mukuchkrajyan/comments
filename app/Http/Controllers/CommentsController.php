<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreComment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;


class CommentsController extends BaseController
{
    protected $view = 'comments.';


    /**
     *  Display a listing of items.
     * @return mixed
     */

    public function index($item_id)
    {
        $item = Item::find($item_id);

        $comments = $item->comments()->with('user')->paginate(4);

        //  dd($item->comments()->first()->user($item->comments()->first()->userid)->name);
        return $this->view($this->view . 'dashboard', compact('comments', 'item_id'));
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
    * @param Request $request
    */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'comment_area' => 'required|max:2',
//         ]);
        $user_id = Auth::user()->id;  /*Getting User ID*/

        $item_id = $request->segments()[1];   /*Getting Item ID*/

        $description = $request->description;   /*Getting Comment Description*/

        //dd($description);

        $comment = new Comment();

        $comment->item_id = $item_id;

        $comment->userid = $user_id;

        $comment->description = $description;

        $comment->save();

        return redirect()->back()
            ->with('success', 'Comment added successfully');

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
     * @param Request $request
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
    public function destroy($comment_id)
    {
        Comment::findOrNew($comment_id)->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    }

}
