<?php

namespace App\Http\Controllers;

use App\Enum\PictureStatus;
use App\Models\Picture;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function home(): View
    {
        $pictures = Picture::where('status', PictureStatus::Published->value)->orderBy('created_at', 'desc')->paginate(config('pagination.default.count'));

        return view('home', ['pictures' => $pictures]);
    }
}
