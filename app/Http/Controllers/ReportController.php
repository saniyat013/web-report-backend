<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use DB;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Date;
use stdClass;

use function PHPSTORM_META\map;

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

    public function reportByDivision(Request $request)
    {
        $reportByDivision = DB::table('reports')
            ->whereBetween('created_at', [$request['dateFrom'], $request['dateTo']])
            ->selectRaw('sum(total_work) as totalWork')
            ->selectRaw('division_id')
            ->groupBy('division_id')
            ->get();

        foreach ($reportByDivision as $key => $item) {
            $reportByDivision[$key]->division = Division::select('name')->where('id',  $reportByDivision[$key]->division_id)->value('name');
        }

        return $reportByDivision;
    }

    public function reportBySingleDivision(Request $request)
    {
        $reportBySingleDivision = DB::table('reports')
            ->whereBetween('created_at', [$request['dateFrom'], $request['dateTo']])
            ->where('division_id', $request['divisionId'])
            ->selectRaw('sum(total_work) as totalWork')
            ->selectRaw('district_id')
            ->groupBy('district_id')
            ->get();

        foreach ($reportBySingleDivision as $key => $item) {
            $reportBySingleDivision[$key]->district = District::select('name')->where('id',  $reportBySingleDivision[$key]->district_id)->value('name');
        }

        return $reportBySingleDivision;
    }

    public function totalReport(Request $request)
    {
        $startDate = explode("T", $request['dateFrom'])[0];
        $endDate = explode("T", $request['dateTo'])[0];

        $reportAll = DB::table('reports')
            ->whereBetween(
                'created_at',
                [$startDate . " 00:00:00", $endDate . " 23:59:59"]
            )
            ->selectRaw('sum(total_work) as totalWork')
            ->selectRaw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as date")
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->get();

        return $reportAll;
    }

    public function totalReportByDivision(Request $request)
    {
        $reportAllByDivision = DB::table('reports')
            ->whereBetween('created_at', [$request['dateFrom'], $request['dateTo']])
            ->where('division_id', $request['divisionId'])
            ->selectRaw('sum(total_work) as totalWork')
            ->selectRaw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as date")
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->get();

        return $reportAllByDivision;
    }

    public function totalShortReportToday(Request $request)
    {
        $dateToday = explode("T", $request['dateToday'])[0];

        $divisions = Division::all();

        foreach ($divisions as $division) {
            $totalMemberByDivision = 0;

            $districts = $division->districts()->get();

            foreach ($districts as $district) {
                $units = $district->units()->get();

                foreach ($units as $unit) {
                    $totalMemberByDivision += (int)$unit->members;
                }
            }

            $totalWorkToday = Report::where('division_id', $division->id)
                ->whereBetween(
                    'created_at',
                    [$dateToday . " 00:00:00", $dateToday . " 23:59:59"]
                )
                ->selectRaw('sum(total_work) as totalWork')
                ->selectRaw('sum(total_id) as totalId')
                ->get();

            $division->totalMember = $totalMemberByDivision;
            $division->totalId = (int)$totalWorkToday[0]->totalId;
            $division->totalWorkToday = (int)$totalWorkToday[0]->totalWork;
        }

        return $divisions;
    }

    public function totalDetailedReportToday(Request $request)
    {
        $dateToday = explode("T", $request['dateToday'])[0];

        $divisions = Division::all();

        foreach ($divisions as $division) {

            $districts = $division->districts()->get();

            foreach ($districts as $district) {
                $totalMemberByDistrict = 0;

                $units = $district->units()->get();

                foreach ($units as $unit) {
                    $totalMemberByDistrict += (int)$unit->members;
                }

                $district->totalMember = $totalMemberByDistrict;

                $totalWorkToday = Report::where('district_id', $district->id)
                    ->whereBetween(
                        'created_at',
                        [$dateToday . " 00:00:00", $dateToday . " 23:59:59"]
                    )
                    ->selectRaw('sum(total_work) as totalWork')
                    ->selectRaw('sum(total_id) as totalId')
                    ->get();

                $district->totalMember = $totalMemberByDistrict;
                $district->totalId = (int)$totalWorkToday[0]->totalId;
                $district->totalWorkToday = (int)$totalWorkToday[0]->totalWork;
            }

            $division->districts = $districts;
        }

        return $divisions;
    }

    public function reportNotSentToday(Request $request)
    {
        $dateToday = explode("T", $request['dateToday'])[0];

        $divisions = Division::all();

        foreach ($divisions as $division) {
            $districts = $division->districts()->get();

            foreach ($districts as $district) {
                $units = $district->units()->get();

                foreach ($units as $unit) {

                    $reportToday = $unit->reports()->whereBetween(
                        'created_at',
                        [$dateToday . " 00:00:00", $dateToday . " 23:59:59"]
                    )
                        ->get();

                    if (count($reportToday) == 0) {

                        $unitUser = User::where('unit', $unit->id)
                            ->select('name', 'mobile')
                            ->get();
                        // echo $unitUser;
                        if (count($unitUser) !== 0) {
                            $unitUser[0]->unitName = $unit->name;
                            $userList[] = $unitUser[0];
                        } else {
                            $blankUnit = new stdClass();
                            $blankUnit->unitName = $unit->name;
                            $userList[] = $blankUnit;
                        }
                    }
                }
            }
        }

        return $userList;
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
