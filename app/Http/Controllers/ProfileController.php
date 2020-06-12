<?php

namespace App\Http\Controllers;

use App\DataObject\TrackDto;
use App\Repository\TrackRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @var TrackRepository
     */
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TrackRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $data = [
            'tracks' => $this->repository->getAllByUserId($userId),
            'favorites' => $this->repository->getFavorites($userId)
        ];

        return view('profile', $data);
    }

    public function add() {
        $regions = $this->repository->getAllRegion();
        $result = [
            'regions' => $regions
        ];
        return view('track_add', $result);
    }

    public function edit(Request $request) {
        $regions = $this->repository->getAllRegion();

        $data = $this->repository->getOwnTrackById($request->id, Auth::user()->id);

        $result = [
            'track' => $data,
            'regions' => $regions
        ];
        if($data instanceof TrackDto) {
            return view('track_add', $result);
        } else {
            abort(404);
        }
    }
}
