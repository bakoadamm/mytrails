<?php


namespace App\Repository;

use App\DataObject\TrackDto;
use App\Model\Region;
use App\Model\Track;
use App\Model\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TrackRepository implements TrackRepositoryInterface {
    /**
     * Get's a track by it's ID
     *
     * @param int
     *
     * @return TrackDto|null
     */
    public function get($trackId) {
        $track = Track::where([
            ['id', '=', $trackId],
            ['private', '=', 0],
            ['status', '=', 1]
        ])->first();
        if($track instanceof Track) {
            return new TrackDto($track);
        } else {
            return null;
        }

    }

    /**
     * Get track by userId and track id.
     *
     * @return Collection|TrackDto
     */
    public function getOwnTrackById($trackId, $userId) {
        $track = Track::where([
            ['id', '=', $trackId],
            ['user_id', "=", $userId]
        ])->first();

        if($track) {
            return new TrackDto($track);
        } else {
            return new Collection();
        }
    }

    /**
     * Get's all tracks.
     *
     * @return Collection
     */
    public function all(Request $request, $pageSize) {
        $tracks = Track::filter($request)->where([
            ['status', '=', 1],
            ['private', '=', 0]
        ])->orderBy('created_at', 'desc')->paginate($pageSize);

        $result = [];
        foreach($tracks as $track) {
            $result['collection'][] = new TrackDto($track);
        }
        $result['links'] = $tracks->links('vendor.pagination.paginate');
        return collect($result);
    }

    public function lastTwo() {
        $tracks = Track::where([
            ['status', '=', 1],
            ['private', '=', 0]
        ])->orderBy('created_at', 'desc')->limit(2)->get();

        $result = [];
        foreach($tracks as $track) {
            $result[] = new TrackDto($track);
        }
        return collect($result);
    }

    public function getAllRegion() {
        Return Region::orderBy('name', 'asc')->get();
    }

    /**
     * Deletes a track.
     *
     * @param int
     * @return boolean
     */
    public function delete($trackId, $userId) {
        $track = Track::where([
            ['id', '=', $trackId],
            ['user_id', '=', $userId]
        ])->first();

        if($track) {
            Storage::delete(['/storage/covers/' . $track->cover, '/storage/tracks/' . $track->gpx]);
            $track->delete();
            return true;
        }
        return false;
    }

    /**
     * Updates a track.
     *
     * @param Request
     *
     */
    public function update(Request $request) {
        //$track = $this->getOwnTrackById($request->track_id, Auth::user()->id);
        $track = Track::where([
            ['id', '=', $request->track_id],
            ['user_id', '=', Auth::user()->id]
        ])->first();

        if($track instanceof Track) {
            $track->title = $request->title;
            $track->short_description = $request->short_description;
            $track->description = $request->description;
            $gpx = $this->fileUpload($request, 'gpx', 'tracks');
            if($gpx) {
                $track->gpx = $gpx;
            }
            $cover = $this->fileUpload($request, 'cover', 'covers');
            if($cover) {
                $track->cover = $cover;
            }
            $track->save();
            return true;
        }
        return false;
    }

    public function getAllByUserId($userId) {
        $tracks = Track::where([
            ['user_id', '=', $userId]
        ])->orderBy('created_at', 'desc')->get();

        $result = [];
        foreach($tracks as $track) {
            $result[] = new TrackDto($track);
        }
        return collect($result);
    }

    public function addTrack(Request $request) {
        $track = new Track();
        $track->user_id = Auth::user()->id;
        $track->title = $request->title;
        $track->short_description = $request->short_description;
        $track->description = $request->description;
        $track->gpx  = '';
        $track->cover  = '';
        $track->private = 0;
        $track->status = 1;

        $gpx = $this->fileUpload($request, 'gpx', 'tracks');
        if($gpx) {
            $track->gpx = $gpx;
        }

        $cover = $this->fileUpload($request, 'cover', 'covers');
        if($gpx) {
            $track->cover = $cover;
        }
        $track->save();
        return true;

    }

    public function like($id) {
        $userId = Auth::user()->id;
        $like = UserLike::where([
            ['track_id', '=', $id],
            ['user_id', '=', $userId]
        ])->first();

        if($like instanceof UserLike) {
            $like->delete();
            return 'dislike';
        } else {
            $l = new UserLike();
            $l->track_id = $id;
            $l->user_id = $userId;
            $l->save();
            return 'like';
        }
    }

    public function getFavorites($userId) {
        if(Auth::user()) {
            $likedTracks = Auth::user()->likedTrack()->orderBy('id', 'desc')->get();
            $result = [];
            foreach ($likedTracks as $track) {
                $result[] = new TrackDto($track);
            }
            return collect($result);
        }
    }

    public function fileUpload(Request $request, string $name, $type) {
        if($request->hasfile($name)) {
            $fileNameWithExt = $request->file($name)->getClientOriginalName();
            $extension = $request->file($name)->getClientOriginalExtension();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $request->file($name)->move(storage_path('app/public/' . $type), $fileNameToStore);

            return $fileNameToStore;
        } else {
            return null;
        }
    }
}
