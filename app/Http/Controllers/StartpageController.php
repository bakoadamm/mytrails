<?php

namespace App\Http\Controllers;

use App\Repository\TrackRepository;
use Illuminate\Http\Request;

class StartpageController extends Controller
{
    protected $repository;

    public function __construct(TrackRepository $repository) {
        $this->repository = $repository;
    }

    public function render() {
        $data = [
            'tracks' => $this->repository->lastTwo()
        ];

        return view('startpage', $data);
    }
}
