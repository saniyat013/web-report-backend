<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getMembersByUnit($unitId)
    {
        $unit = Unit::find($unitId);
        return [
            'members' => $unit->members
        ];
    }

    public function updateMembersByUnit(Request $request, $unitId)
    {
        $unit = Unit::find($unitId);
        $unit->update($request->all());
        return [
            'members' => $unit->members
        ];
    }
}
