<?php

namespace App\Http\Controllers;

use App\Models\Facilitie;
use App\Models\Room_Facilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = Facilitie::all();
        return response()->json([
            "data" => $facilities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $facilitie = new Facilitie;
            $facilitie->facilities_title = $request->facilities_title;
            $facilitie->save();

            return response()->json([
                "message" => "Create facilitie success",
                "data" => $facilitie
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Create facilitie failed"
            ]);
        }
    }

    public function getFacilitiesById($id)
    {
        try {
            $data = DB::table('room_facilities')
                ->select('facilities.facilities_title', 'room_facilities.is_active')
                ->join('facilities', 'facilitie_id', 'facilities.id')
                ->join('rooms', 'room_id', 'rooms.id')
                ->where('rooms.id', $id)
                // ->first();
                ->get();

            return response()->json($data);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Room is not found"
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facilitie  $facilitie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $roomID, $facilitieId)
    {
        Room_Facilities::where('room_id', $roomID)
                        ->where('facilitie_id', $facilitieId)
                        ->update(['is_active' => $request['isActive']]);
        return response()->json([
                        "message" => "successfully update"
                        ], 200);
    }

}
