<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show view.
     *
     * @param $view
     * @param array $data
     * @param array $mergeData
     *
     * @return mixed
     */
    public function view($view, $data = array(), $mergeData = array())
    {
         return view('pages.' . $view, $data, $mergeData);
    }
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

}