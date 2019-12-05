<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temperature;
use Carbon\Carbon;

class TemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //retrieve all temperatures
        $result = Temperature::all();
        return response()->json($result);
    }

    /**
     * return daily temperature records between two dates passed
     */
    public function search(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);
        $from = $request->input("from");
        $to = $request->input("to");
        $result = Temperature::whereBetween('dateRecorded', array($from, $to))->get();
        return response()->json($result);
    }

    /**
     * displaying daily temperature values for the last 7 days
     */
    public function recent()
    {
        $date = new Carbon;
        $date->subWeek();
        $result = Temperature::where('dateRecorded', '>', $date->toDateTimeString())->get();
        return response()->json($result);
    }

    /**
     * updating the temperature value for any date that has a record on the system
     */
    public function update(Request $request)
    {
        $jsonBody = json_decode($request->getContent(), true);
        $date = $jsonBody["date"];
        $temperature = $jsonBody["temperature"];
        //dd($jsonBody);
        $update = Temperature::where('dateRecorded', $date)
            ->update(['temperature' => $temperature]);
            
        if ($update)
            $message = response()->json([
                'response' => 'OK! record updated'
            ]);
        else
            $message = response()->json([
                'response' => 'Error! Date does not exist',
            ]);

        return $message;
    }
}
