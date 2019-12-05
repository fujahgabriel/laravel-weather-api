<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temperature;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()->first()]);
        }

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
        $rules = [
            'date' => 'required|date',
            'temperature' => 'required|integer',
        ];

        $validator = Validator::make($jsonBody, $rules);

        if ($validator->fails()) {
            return response()->json(['response' => $validator->messages()->first()]);
        }

        $date = $jsonBody["date"];
        $temperature = $jsonBody["temperature"];

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
