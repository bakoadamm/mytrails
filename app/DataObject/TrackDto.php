<?php


namespace App\DataObject;


use App\Model\Track;
use Illuminate\Support\Facades\Auth;

class TrackDto {

    /**
     * @var mixed
     */
    private $id;
    /**
     * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|object|null
     */
    private $user;
    /**
     * @var mixed
     */
    private $title;
    /**
     * @var mixed
     */
    private $short_description;
    /**
     * @var mixed
     */
    private $description;
    /**
     * @var string
     */
    private $cover;
    /**
     * @var string
     */
    private $gpx;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $private;
    /**
     * @var mixed
     */
    private $updated_at;
    /**
     * @var mixed
     */
    private $created_at;

    private $userLiked;

    private $regions = [];

    /**
     * TrackDto constructor.
     * @param Track $track
     */
    public function __construct(Track $track) {
        $this->id = $track->id;
        $this->user = $track->user()->first();
        $this->title = $track->title;
        $this->short_description = $track->short_description;
        $this->description = $track->description;
        $this->cover = $track->cover;
        $this->gpx = $track->gpx;
        $this->status = $track->status;
        $this->private = $track->private;
        $this->updated_at = $track->updated_at;
        $this->created_at = $track->created_at;
        $this->userLiked = $this->getLiked();
        $this->regions = $track->region()->get();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|object|null
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getShortDescription() {
        return $this->short_description;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getCover() {
        return $this->cover;
    }

    /**
     * @return string
     */
    public function getGpx(): string {
        return $this->gpx;
    }

    /**
     * @return int
     */
    public function getStatus(): int {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getPrivate(): int {
        return $this->private;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * @return void
     */
    public function getUserLiked() {
        return $this->userLiked;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRegions(): \Illuminate\Database\Eloquent\Collection {
        return $this->regions;
    }

    public function getRegionIdArray() {
        $result = [];
        foreach($this->regions as $region) {
            $result[] = $region->id;
        }
        return $result;
    }

    public function getLiked() {
        if(Auth::user()) {
            $liked = Auth::user()->likedTrack()->where([
                ['track_id', '=', $this->id]
            ])->first();

            if ($liked instanceof Track) {
                return true;
            } else {
                return false;
            }
        }
        return null;

    }


}
