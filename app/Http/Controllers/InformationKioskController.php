<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\CoreValues;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faqs;
use App\Models\Organization;
use App\Models\OrgUnit;
use App\Models\Post;
use App\Models\SchoolOfficials;
use App\Models\TelephoneDirectory;
use App\Models\Unit;
use App\Models\UniversityInfo;
use Illuminate\Http\Request;

class InformationKioskController extends Controller
{
    public function missionvision(){
        return response()->json(UniversityInfo::get(['lnu_hymn', 'lnu_mission', 'lnu_vision', 'lnu_history', 'lnu_qualitypolicy']));
    }

    public function organizations(){
        return response()->json(Organization::with(['members', 'members.posts'])->get());
    }

    public function posts(){
        return response()->json(Post::with(['postcontent', 'useraccount.userinfo', 'useraccount.userinfo.role', 'useraccount.userinfo.organization', 'useraccount.userinfo.department'])->where('status', 'Approved')->where('created_at', '>=', now()->subDays(7))->latest()->take(15)->get());
    }
    
    public function requestOrgPost(){
        return response()->json(Post::whereHas('useraccount.userinfo.organization', function($query){
            $query->where('name', request()->get('name'));
        })->with(['postcontent', 'useraccount.userinfo', 'useraccount.userinfo.role', 'useraccount.userinfo.organization', 'useraccount.userinfo.department'])->where('status', 'Approved')
        ->where('created_at', '>=', now()->subDays(7))->latest()->take(15)->get());
    }
    
    public function requestDepPost(){
        return response()->json(Post::whereHas('useraccount.userinfo.department', function($query){
            $query->where('name', request()->get('name'));
        })->with(['postcontent', 'useraccount.userinfo', 'useraccount.userinfo.role', 'useraccount.userinfo.department', 'useraccount.userinfo.department'])->where('status', 'Approved')
        ->where('created_at', '>=', now()->subDays(7))->latest()->take(15)->get());
    }

    public function departments(){
        return response()->json(Department::get());
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
