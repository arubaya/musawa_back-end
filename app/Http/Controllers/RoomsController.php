<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Room_Facilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();

        return response()->json([
            "data" => $rooms
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
            $room = Room::create($request->all());
            // $room->save();
            return response()->json([
                "message" => "create Room success",
                "data" => $room
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "create room data failed"
            ]);
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room_Facilities $room
     * @return \Illuminate\Http\Response
     */
    public function setRoomFacilitie(Request $request)
    {
        try {
            $room_facilitie = Room_Facilities::create($request->all());
            return response()->json([
                "message" => "create Room Facilitie success",
                "data" => $room_facilitie
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "create room facilitie failed",
                "error" => $exception
            ]);
        }
    }

    public function getRoomById($id)
    {
        try {
            $data = Room::where('rooms.id', $id)->get();

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
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idRoom)
    {
        Room::where('id', $idRoom)
            ->update(['room_price' => $request['newPrice']]);
        
            return response()->json([
                "message" => "successfully update"
                ], 200);
    }

  }
