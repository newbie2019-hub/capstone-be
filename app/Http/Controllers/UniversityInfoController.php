<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolOfficialRequest;
use App\Models\CoreValues;
use App\Models\SchoolOfficials;
use App\Models\UniversityInfo;
use App\Models\TelephoneDirectory;
use App\Models\College;
use App\Models\Course;
use App\Models\CollegeInfo;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\CourseObjective;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UniversityInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $schoolofficials = SchoolOfficials::paginate(5);
        return response()->json($schoolofficials);
    }

    public function searchOfficial(Request $request){
        $officials = SchoolOfficials::where('first_name', 'like', '%'.$request->search.'%')
        ->orWhere('last_name', 'like', '%'.$request->search.'%')
        ->orWhere('role', 'like', '%'.$request->search.'%')
        ->paginate(8);

        return response()->json($officials);
    }

    public function store(SchoolOfficialRequest $request){
        $data = [
            'image' => $request->image,
            'middle_name' => $request->middle_name,
            'title' => $request->title,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ];

        SchoolOfficials::create($request->validated() + $data);
        return response()->json(['msg' => 'School Official created successfully!']);
    }

    public function update(SchoolOfficialRequest $request, $id){
        $data = [
            'image' => $request->image,
            'middle_name' => $request->middle_name,
            'title' => $request->title,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ];

        $official = SchoolOfficials::where('id', $id)->first();
        $official->update($request->validated() + $data);
        return response()->json(['msg' => 'School Official updated successfully!']);
    }

    public function universityinfo(){
        return response()->json(UniversityInfo::get());
    }

    public function corevalues(){
        return response()->json(CoreValues::get(['id', 'core_value', 'description']));
    }

    public function updateMission(Request $request, $id){
        $mission = UniversityInfo::where('id', $id)->first();
        $mission->update(['lnu_mission' => $request->lnu_mission]);
        return response()->json($mission);
    }

    public function updateHistory(Request $request, $id){
        $history = UniversityInfo::where('id', $id)->first();
        $history->update(['lnu_history' => $request->history]);
        return response()->json($history);
    }

    public function updateQualityPolicy(Request $request, $id){
        $qualitypolicy = UniversityInfo::where('id', $id)->first();
        $qualitypolicy->update(['lnu_qualitypolicy' => $request->qualitypolicy]);
        return response()->json(['msg' => 'Quality Policy updated successfully']);
    }

    public function updateVision(Request $request, $id){
        $vision = UniversityInfo::where('id', $id)->first();
        $vision->update(['lnu_vision' => $request->lnu_vision]);
        return response()->json($vision);
    }

    public function updateCV(Request $request, $id){
        $cv = CoreValues::where('id', $id)->first();
        $cv->update(['core_value' => $request->core_value, 'description' => $request->description]);
        return response()->json($cv);
    }

    public function telephoneDirectories(){
        $tel = TelephoneDirectory::paginate(10);
        return response()->json($tel);
    }

    public function searchTelephoneDirectory(Request $request){
        $tel = TelephoneDirectory::where('name', 'like', '%'.$request->search.'%')->paginate(10);
        return response()->json($tel);
    }

    public function storeTelephone(Request $request){
        if(auth('admin')->user()){

            activity()->disableLogging();

            $tel = TelephoneDirectory::create([
                'name' => $request->name,
                'tel_num' => $request->tel_num
            ]);
            
            activity()->enableLogging();

            activity('Admin - Telephone Directory Created')->withProperties($tel)
            ->causedBy(auth('admin')->user())
            ->performedOn($tel)
            ->event('created')
            ->log('You added a telephone directory record');
            
        }
        else {
            $tel = TelephoneDirectory::create([
                'name' => $request->name,
                'tel_num' => $request->tel_num
            ]);
        }

        return response()->json($tel);
    }

    public function updateTelephone(Request $request, $id){
        if(auth('admin')->user()){
            $tel = TelephoneDirectory::where('id', $id)->first();
            activity()->disableLogging();
            $tel->update(['name' => $request->name, 'tel_num' => $request->tel_num]);
            
            activity()->enableLogging();
            
            activity('Admin - Telephone Directory Delete')->withProperties($tel)
            ->causedBy(auth('admin')->user())
            ->performedOn($tel)
            ->event('updated')
            ->log('You updated a telephone directory record');
        }
        else {
            $tel = TelephoneDirectory::where('id', $id)->first();
            $tel->update(['name' => $request->name, 'tel_num' => $request->tel_num]);
        }

        return response()->json(['success' => 'Telephone updated successfully']);
    }

    public function deleteTelephone($id){
        if(auth('admin')->user()){
            $telDirectory = TelephoneDirectory::where('id', $id)->first();
            $telDirectory->disableLogging();
            
            activity('Admin - Telephone Directory Delete')->withProperties($telDirectory)
            ->causedBy(auth('admin')->user())
            ->performedOn($telDirectory)
            ->event('deleted')
            ->log('You deleted a telephone directory record');
            
            $telDirectory->delete();
        }
        else {
            TelephoneDirectory::destroy($id);
        }

        return response()->json(['success' => 'Telephone deleted successfully']);
    }

    public function colleges(){
        $college = College::with(['goals:id,college_id,goal', 'objectives:id,college_id,objective'])->paginate(8);
        return response()->json($college);
    }

    public function searchCollege(Request $request){
        $college = College::with(['goals:id,college_id,goal', 'objectives:id,college_id,objective'])->where('name', 'like', '%'.$request->search.'%')->paginate(5);
        return response()->json($college);
    }

    public function storeCollege(Request $request){
        $college = College::create([
            'name' => $request->college, 
            'abbreviation' => $request->abbreviation, 
            'dean' => $request->dean,
        ]);

        foreach($request->objectives as $objective){
            if($objective['objective']){
                Objective::create([
                    'objective' => $objective['objective'],
                    'college_id' => $college->id
                ]);
            }
        }

        foreach($request->goals as $goal){
            if($goal['goal']){
                Goal::create([
                    'goal' => $goal['goal'],
                    'college_id' => $college->id
                ]);
            }
        }

        return response()->json(['success' => 'College added successfully']);
    }

    public function updateCollege(Request $request, $id){
        Objective::where('college_id', $id)->delete();
        Goal::where('college_id', $id)->delete();

        $college = College::where('id', $id)->first();
        $college->update([
            'name' => $request->name, 
            'abbreviation' => $request->abbreviation, 
            'dean' => $request->dean,
        ]);

        foreach($request->objectives as $objective){
            if($objective['objective']){
                Objective::create([
                    'objective' => $objective['objective'],
                    'college_id' => $college->id
                ]);
            }
        }

        foreach($request->goals as $goal){
            if($goal['goal']){
                Goal::create([
                    'goal' => $goal['goal'],
                    'college_id' => $college->id
                ]);
            }
        }
        
        return response()->json(['success' => 'College updated successfully']);
    }

    public function deleteCollege($id){
        College::destroy($id);
        return response()->json(['success' => 'College deleted successfully']);
    }

    public function courses(){
        $course = Course::with(['college', 'objectives'])->paginate(8);
        return response()->json($course);
    }

    public function searchCourse(Request $request){
        $course = Course::with('college')->where('course_name', 'like', '%'.$request->search.'%')->paginate(8);
        return response()->json($course);
    }

    public function storeCourse(Request $request){
        $course = Course::create([
            'course_name' => $request->name, 
            'course_abbreviation' => $request->abbreviation,
            'college_id' => $request->college
        ]);

        if($request->objectives){
            foreach($request->objectives as $objective){
                CourseObjective::create([
                    'course_objective' => $objective['objective'], 
                    'course_id' => $course->id
                ]);
            }
        }

        return response()->json(['success' => 'Course added successfully']);
    }

    public function updateCourse(Request $request, $id){
        CourseObjective::where('course_id', $id)->delete();

        $course = Course::where('id', $id)->first();
        
        if($request->objectives){
            foreach($request->objectives as $objective){
                //CHECK IF COURSE OBJECTIVE SENT IS NOT EMPTY
                if($objective['course_objective']){
                    CourseObjective::create([
                        'course_objective' => $objective['course_objective'], 
                        'course_id' => $id
                    ]);
                }
            }
        }

        $course->update([
            'course_name' => $request->course_name, 
            'course_abbreviation' => $request->course_abbreviation,
            'college_id' => $request->college_id
        ]);
        
        return response()->json(['success' => 'Course updated successfully']);
    }

    public function deleteCourse($id){
        Course::destroy($id);
        return response()->json(['success' => 'Course deleted successfully']);
    }

    public function destroy($id){
        SchoolOfficials::destroy($id);
        return response()->json(['msg' => 'School Official deleted successfully'], 200);
    }
}
