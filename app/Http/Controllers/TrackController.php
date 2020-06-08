<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TrackRepository;

class TrackController extends Controller  {

    protected $repository;

    public function __construct(TrackRepository $repository) {
        $this->repository = $repository;
    }

    public function render($id) {
        $data = [
            'track' => $this->repository->get($id)
        ];
        return view('track_single', $data);
    }

    public function all() {
        $data = [
            'tracks' => $this->repository->all()
        ];
        return view('tracks', $data);
    }
}
