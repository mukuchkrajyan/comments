<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentTyping;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;

class CommentTypingController extends Controller
{
    /**
     * fixing typing event
     * @param $request
     */
    public function typingEvent(Request $request)
    {
        $user_id = Auth::user()->id;  /*Getting User ID*/

        $item_id = $request->segments()[1];   /*Getting Item ID*/

        date_default_timezone_set("Asia/Yerevan");

        $dateNow = date('Y-m-d H:i:s');

        if ($request->typing == true && CommentTyping::where('item_id', $item_id)->where('userid', $user_id)->where('created_at', $dateNow)->count() == 0) {

            $commentTyping = new CommentTyping;

            $commentTyping->userid = $user_id;

            $commentTyping->item_id = $item_id;

            $commentTyping->save();
        }

        return 1;

    }

    /**
     * getting typing users
     * @param $request
     */
    public function getTypersNow(Request $request)
    {
        $self_user_id = Auth::user()->id;  /*Getting User ID*/

        $item_id = $request->segments()[1];   /*Getting Item ID*/

        date_default_timezone_set("Asia/Yerevan");

        $date = new DateTime();

        $date->setTimezone(new DateTimeZone('Asia/Yerevan'));

        $dateNow = $date->format('Y-m-d H:i:s');

        $date->modify('-3 seconds');

        $dateSecondsAgo = $date->format('Y-m-d H:i:s');

        $dateNow = date('Y-m-d H:i:s',strtotime($dateSecondsAgo));

        return CommentTyping::where('item_id', $item_id)
            ->where('created_at', '>=', $dateNow)
            ->whereNotIn('userid',array($self_user_id)) /* Return data except self user typing*/
            ->groupby('userid')
            ->with('user')
            ->get()
            ->pluck('user.name');
    }

}
