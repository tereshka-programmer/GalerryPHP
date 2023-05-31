<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Services\FavouritesPictures\CreateFavouriteService;
use App\Services\FavouritesPictures\DeleteFavouriteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavouritesController extends Controller
{
    public function index(): View
    {
        $pictures = Auth::user()->myFavouritesPictures()->paginate(config('pagination.default.count'));
        return view('home', ['pictures' => $pictures]);
    }

    public function add(Picture $picture, CreateFavouriteService $createFavouriteService): RedirectResponse
    {
        $createFavouriteService->handle($picture, \auth()->id());

        return redirect()->route('home');
    }

    public function delete(Picture $picture, DeleteFavouriteService $deleteFavouriteService): RedirectResponse
    {
        $deleteFavouriteService->handle($picture, \auth()->user());
        return redirect()->route('home');
    }
}
