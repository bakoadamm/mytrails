<?php


namespace App\Repository;


use Illuminate\Http\Request;

interface TrackRepositoryInterface {
    /**
     * Get's a track by it's ID
     *
     * @param int
     */
    public function get($trackId);

    /**
     * Get's all tracks.
     *
     * @return mixed
     */
    public function all();

    /**
     * Deletes a track.
     *
     * @param int
     */
    public function delete($trackId, $userId);

    /**
     * Updates a track.
     *
     * @param int
     * @param array
     */
    public function update(Request $request);
}
