<?php
namespace App\Http\Controllers\Tries;

use App\Http\Controllers\Controller;

/**
 * Created by PhpStorm.
 * User: arkadij
 * Date: 11.12.15
 * Time: 17:58
 */
class IndexController extends Controller
{
    public function index()
    {
        return view('tries.index');
    }
}