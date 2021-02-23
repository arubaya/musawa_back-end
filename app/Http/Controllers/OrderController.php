<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrdersAll()
    {
        $data = DB::table('orders')
                ->select(
                    'orders.id',
                    'orders.room_id',
                    'orders.user_id',
                    'users.name',
                    'rooms.room_name',
                    DB::raw('date_format(orders.check_in, "%e %M %Y") as check_in'),
                    DB::raw('date_format(orders.check_out, "%e %M %Y") as check_out'),
                    'orders.message',
                    'orders.status')
                ->join('rooms', 'room_id', 'rooms.id')
                ->join('users', 'user_id', 'users.id')
                ->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOrder(Request $request)
    {

        $order = Order::create([
            'room_id' => $request['roomId'],
            'user_id' => $request['userId'],
            'guests' => $request['guests'],
            'check_in' => $request['checkIn'],
            'check_out' => $request['checkOut'],
            'total_days' => $request['totalDays'],
            'message' => $request['message'],
            'status' => $request['status'],
        ]);

        return response()->json([
            "message" => "pesananmu masuk kedalam proses",
            "data" => $order
        ]);
    }

    public function getOrderByUser($id)
    {
        try {
            $data = DB::table('orders')
                ->select(
                    'orders.id',
                    'orders.room_id',
                    'rooms.room_name',
                    DB::raw('date_format(orders.check_in, "%e %M %Y") as check_in'),
                    DB::raw('date_format(orders.check_out, "%e %M %Y") as check_out'),
                    'orders.total_days',
                    'orders.message',
                    'orders.status')
                ->join('rooms', 'room_id', 'rooms.id')
                ->where('orders.user_id', $id)
                ->get();

            return response()->json($data);
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "get order failed",
                "fail" => $exception
            ]);
        }
    }

    public function getDetailOrder($orderId)
    {
        try {
            $data = DB::table('orders')
                ->select(
                    'orders.id',
                    'orders.room_id',
                    'rooms.room_name',
                    'rooms.room_price',
                    DB::raw('date_format(orders.check_in, "%e %M %Y") as check_in'),
                    DB::raw('date_format(orders.check_out, "%e %M %Y") as check_out'),
                    'orders.guests',
                    'orders.total_days',
                    'orders.message',
                    'orders.status')
                ->join('rooms', 'room_id', 'rooms.id')
                ->where('orders.id', $orderId)
                ->first();
                return response()->json($data);
            
        } catch (\Exception $exception) {
            return response()->json([
                "message" => $exception
            ]);
        }
    }

    public function checkAvailability($from, $to, $id)
    {
        $check = DB::table('orders')->whereBetween('check_in', [$from, $to])
                    ->where('room_id', $id)        
                    ->get();

        return response()->json($check);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        Order::where('id', $id)
                ->update([
                    'status' => $request['status'],
                    ]);
        return response()->json([
                        "message" => "successfully update"
                        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyOrder($id)
    {
        try {
            Order::where('id', $id)->delete();
            return response()->json([
                "message" => "DELETE Method Success " . $id,
            ]);
            
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
