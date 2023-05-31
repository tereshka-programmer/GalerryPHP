<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPicturePostRequest;
use App\Http\Requests\UpdatePicturePostRequest;
use App\Models\Picture;
use App\Models\Review;
use App\Services\Pictures\CreatePictureServiceAbstract;
use App\Services\Pictures\DeletePictureService;
use App\Services\Pictures\UpdatePictureServiceAbstract;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

class PictureController extends Controller
{
    public function addForm(): View
    {
        return view('add-picture');
    }

    public function previewForm(Picture $picture): View
    {
        $reviews = Review::where('picture_id', $picture->id)->orderBy('status')->orderByDesc('created_at')->paginate(config('pagination.default.count'));
        return view('picture-reviews', ['picture' => $picture], ['reviews' => $reviews]);
    }

    public function indexMyPictures(): View
    {
        $picture = Picture::where('user_id', \auth()->id())->orderByDesc('created_at')->paginate(config('pagination.default.count'));
        return view('home', ['pictures' => $picture]);
    }

    public function editForm(Picture $picture): View
    {
        return view('edit-picture', ['picture' => $picture]);
    }

    public function delete(Picture $picture, DeletePictureService $deletePictureService): RedirectResponse
    {
        $deletePictureService->handle($picture);

        return redirect()->route('home');
    }

    public function update(UpdatePicturePostRequest $request, Picture $picture, UpdatePictureServiceAbstract $updatePictureService): RedirectResponse
    {
        $updatePictureService->handle(
            $request->input('title'),
            $request->input('description'),
            auth()->user()->getAuthIdentifier(),
            $picture,
            $request->file('user_file')
        );


        return redirect()->route('home');
    }

    public function create(AddPicturePostRequest $request, CreatePictureServiceAbstract $createPictureService): RedirectResponse
    {
        $createPictureService->handle(
            $request->input('title'),
            $request->input('description'),
            $request->file('user_file'),
            auth()->user()->getAuthIdentifier()
        );

        return redirect()->route('home');
    }
}
