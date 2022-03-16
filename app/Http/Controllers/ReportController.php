<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'division_id' => 'required',
            'district_id' => 'required',
            'unit_id' => 'required',
            'created_at' => 'required',
            'total_work' => 'required',
            'total_id' => 'required',
            'comment' => 'string'
        ]);

        $duplicate_value = Report::select('id')
            ->whereDate('created_at', date($request['created_at']))
            ->where(
                'division_id',
                $request['division_id']
            )
            ->where(
                'district_id',
                $request['district_id']
            )
            ->where(
                'unit_id',
                $request['unit_id']
            )
            ->value('id');

        if ($duplicate_value != null) {
            $report = Report::find($duplicate_value);
            $report->update([
                'total_work' => $fields['total_work'],
                'total_id' => $fields['total_id'],
                'comment' => $fields['comment']
            ]);

            return $report;
        } else {
            $report = Report::create([
                'division_id' => $fields['division_id'],
                'district_id' => $fields['district_id'],
                'unit_id' => $fields['unit_id'],
                'created_at' => $fields['created_at'],
                'total_work' => $fields['total_work'],
                'total_id' => $fields['total_id'],
                'comment' => $fields['comment']
            ]);

            return $report;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Report::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $report = Report::find($id);
        $report->update($request->all());
        return $report;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Report::destroy($id);
    }

    /**
     * Search for a report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {
        return Report::find($id);
    }
}
