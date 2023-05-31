<?php

namespace App\Http\Controllers;

use App\Enum\PictureStatus;
use App\Enum\ReviewStatus;
use App\Models\Picture;


use App\Services\Pictures\DecidePictureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function panelForm(): View
    {
        $pictures = Picture::Where('status', PictureStatus::Draft->value)
            ->orWhere('status', PictureStatus::Published->value)
            ->whereHas('reviews', function($query) {
                $query->where('status', ReviewStatus::WaitingForApproval->value);
            })
            ->orderBy('updated_at')
            ->paginate(config('pagination.default.count'));

        return view('admin-panel', ['pictures' => $pictures]);
    }

    public function hidePicture(Picture $picture, DecidePictureService $decidePictureService): RedirectResponse
    {
        $decidePictureService->handle($picture, PictureStatus::Revoked);
        return redirect()->back();
    }

    public function publishPicture(Picture $picture, DecidePictureService $decidePictureService): RedirectResponse
    {
        $decidePictureService->handle($picture, PictureStatus::Published);

        return redirect()->back();
    }

    public function groupAction()
    {
    }
}
