<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function about()
    {
        $name = 'Arkadij <span style="color: red;">Kuzhel</span>';

        $phone1 = rand(123456, 129999);
        $phone2 = rand(123456, 129999);
        $phone3 = rand(123456, 129999);

        $people = /*[];//*/['zsetza', 'ase5tgsz', 'ser gae', 'aweryqazsrg'];

        return view('pages.about')->with(
            compact('phone1', 'phone2', 'phone3', 'people') +
            [
                'name'  => $name,
                'first' => 'ARk',
                'last'  => 'Kuz'
            ]
        );
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
