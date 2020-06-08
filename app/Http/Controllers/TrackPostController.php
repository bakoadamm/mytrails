<?php

namespace App\Http\Controllers;

use App\Repository\TrackRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackPostController extends Controller
{
    private $repository;

    public function __construct(TrackRepository $repository) {
        $this->repository = $repository;
    }

    public function add(Request $request) {
        // TODO validate request data
        $this->repository->addTrack($request);
        return redirect('/profil')
            ->with('success', 'Sikeresen hozzáadtad az útvonalat');
    }

    public function delete(Request $request) {
        $id = $request->id;

        if($this->repository->delete($id, Auth::user()->id)) {
            return response(['message' => 'ok'],200);
        }
        return response(['message' => 'not found'], 404);
    }

    public function update(Request $request) {
        // TODO validate request data
        if($this->repository->update($request)) {
            return redirect("/utvonal/szerkesztes/{$request->track_id}")
                ->with('success', 'Sikeresen szerkesztetted az útvonalat');
        } else {
            abort(404);
        }
    }

    public function like($id) {
        $result = $this->repository->like($id);
        if($result == 'dislike') {
            return response(['message' => 'dislike'],200);
        }
        return response(['message' => 'like'],200);
    }
}
