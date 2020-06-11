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
        $track = $this->repository->get($id);
        if($track == null) {
            abort(404);
        }
        $data = [
            'track' => $track
        ];
        return view('track_single', $data);
    }

    public function all(Request $request) {

        $params['region'] = [];
        if(isset($_GET['tajegyseg'])) { $params['region'] = explode(',', $_GET['tajegyseg']); }

        $tracks = $this->repository->all($request,5);

        $regions = $this->repository->getAllRegion();

        if( ! isset($tracks['collection'])) {
            $tracks['collection'] = [];
        }
        $data = [
            'regions' => $regions,
            'tracks' => $tracks['collection'],
            'links'  => $tracks['links'],
            'params' => $params
        ];
        return view('tracks', $data);
    }
}
