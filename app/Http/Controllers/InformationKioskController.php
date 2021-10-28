<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\CoreValues;
use App\Models\Course;
use App\Models\Faqs;
use App\Models\Organization;
use App\Models\OrgUnit;
use App\Models\SchoolOfficials;
use App\Models\TelephoneDirectory;
use App\Models\Unit;
use App\Models\UniversityInfo;
use Illuminate\Http\Request;

class InformationKioskController extends Controller
{
    public function missionvision(){
        return response()->json(UniversityInfo::get(['lnu_hymn', 'lnu_mission', 'lnu_vision']));
    }

    public function organizations(){
        return response()->json(OrgUnit::where('type', 'Organization')->get());
    }

    public function departments(){
        return response()->json(OrgUnit::where('type', 'Department')->get());
    }

    public function corevalues(){
        return response()->json(CoreValues::get(['core_value', 'description']));
    }

    public function schoolofficials(){
        return response()->json(SchoolOfficials::get(['first_name', 'middle_name', 'last_name', 'email', 'role', 'image', 'title', 'telephone']));
    }

    public function teldirectories(){
        return response()->json(TelephoneDirectory::get(['name', 'tel_num']));
    }

    public function courses(){
        return response()->json(College::with(['courses:id,course_name,course_abbreviation,college_id', 'goals', 'objectives'])->get(['id', 'name', 'dean', 'abbreviation']));
    }

    public function faqs(){
        return response()->json(Faqs::get(['id','question','answer']));
    }
}
