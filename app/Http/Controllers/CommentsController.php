<?php

namespace App\Http\Controllers;

use App\Events\MessagePosted;
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

    public function index(Request $request, $item_id)
    {
        $item = Item::find($item_id);

        $comments = $item->comments()->orderBy('commentid', 'desc')->with('user')->paginate(30);
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
        $user_id = Auth::user()->id;  /*Getting User ID*/

        $item_id = $request->segments()[1];   /*Getting Item ID*/

        $description = $request->description;   /*Getting Comment Description*/


        $comment = new Comment();

        $comment->item_id = $item_id;

        $comment->userid = $user_id;

        $comment->description = $description;

        $comment->save();


        $new_comments = false;

        $new_added_comments_count = 0;

        $old_comments_count = $request->old_comments_count;

        $new_comments_count = Comment::where('item_id', $item_id)->count();

        if ($new_comments_count > $old_comments_count) {

            $new_comments = true;

            $new_added_comments_count = $new_comments_count - $old_comments_count;

            $new_added_comments = Comment::orderBy('commentid', 'desc')->take($new_added_comments_count)->get();
        }

        return array("new_comments_count" => $new_comments_count,
            "new_comments" => $new_comments,
            "new_added_comments_count" => $new_added_comments_count,
            "new_added_comments" => $new_added_comments,
            "description" => $description,
            "userid" => $user_id,
            "email" => Auth::user()->email,
            "name" => Auth::user()->name,
            "date" => $comment->created_at,
            "id" => $comment->id);

//        event(new MessagePosted(Auth::user(), $request->get('description')));
//
//        return redirect()->back()
//            ->with('success', 'Comment added successfully');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {

    }

    /**
     * @param Request $request
     * @return $comments
     */
    public function get_comments_now(Request $request)
    {
        $new_added_comments = array();

        $item_id = $request->segments()[1];   /*Getting Item ID*/

        $new_comments = false;

        $new_added_comments_count = 0;

        $old_comments_count = $request->old_comments_count;

        $new_comments_count = Comment::where('item_id', $item_id)->count();

        if ($new_comments_count > $old_comments_count) {

            $new_comments = true;

            $new_added_comments_count = $new_comments_count - $old_comments_count;

            $new_added_comments = Comment::orderBy('commentid', 'desc')->take($new_added_comments_count)->get();
        }
        $result = array("new_comments_count" => $new_comments_count, "new_comments" => $new_comments, "new_added_comments_count" => $new_added_comments_count, "new_added_comments" => $new_added_comments);

        return $result;
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

        return redirect()->back()->with('success', 'Comment deleted successfully');
    }

}
