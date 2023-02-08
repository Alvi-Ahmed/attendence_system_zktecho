<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  string $category;
     * @return \Illuminate\Http\Response
     */    
    public function leavereport($id)
    {
       // $mytime = Carbon::now();
        $user = DB::select('SELECT * FROM records WHERE user_id = ? ORDER BY created_at',[$id] );
        return response()->json([
            'status'=> true,
            'record' => $user
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  string $category;
     * @return \Illuminate\Http\Response
     */    
    public function recordget($id)
    {
        $user = DB::select('SELECT * FROM records WHERE user_id = ?',[$id]);
        return response()->json([
            'status'=> true,
            'record' => $user
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Record::all();
        return response()->json([
            'status'=> true,
            'Record' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = Record::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Record Created successfully!",
            'record' => $record
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
