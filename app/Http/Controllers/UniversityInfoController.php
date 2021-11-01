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
        $tel = TelephoneDirectory::paginate(5);
        return response()->json($tel);
    }

    public function searchTelephoneDirectory(Request $request){
        $tel = TelephoneDirectory::where('name', 'like', '%'.$request->search.'%')->paginate(5);
        return response()->json($tel);
    }

    public function storeTelephone(Request $request){
        $tel = TelephoneDirectory::create([
            'name' => $request->name,
            'tel_num' => $request->tel_num
        ]);
        return response()->json($tel);
    }

    public function updateTelephone(Request $request, $id){
        $tel = TelephoneDirectory::where('id', $id)->first();
        $tel->update(['name' => $request->name, 'tel_num' => $request->tel_num]);
        return response()->json(['success' => 'Telephone updated successfully']);
    }

    public function deleteTelephone($id){
        TelephoneDirectory::destroy($id);
        return response()->json(['success' => 'Telephone deleted successfully']);
    }

    public function colleges(){
        $college = College::paginate(5);
        return response()->json($college);
    }

    public function searchCollege(Request $request){
        $college = College::where('name', 'like', '%'.$request->search.'%')->paginate(5);
        return response()->json($college);
    }

    public function storeCollege(Request $request){
        College::create([
            'name' => $request->name, 
            'abbreviation' => $request->abbreviation, 
            'dean' => $request->dean,
            'goals' => $request->goals,
        ]);

        return response()->json(['success' => 'College added successfully']);
    }

    public function updateCollege(Request $request, $id){
        $college = College::where('id', $id)->first();
        $college->update([
            'name' => $request->name, 
            'abbreviation' => $request->abbreviation, 
            'dean' => $request->dean,
            'goals' => $request->goals,
        ]);
        
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

    public function courseObjectives(){
        $courseobjective = CourseObjective::with('course')->paginate(8);
        return response()->json($courseobjective);
    }

    // public function searchCourseObjective(Request $request){
    //     $courseobjective = CourseObjective::with('course')
    //     ->where('course_objective', 'like', '%'.$request->search.'%')->paginate(8);
    //     return response()->json($courseobjective);
    // }

    // public function storeCourseObjective(Request $request){
    //     CourseObjective::create([
    //         'course_objective' => $request->objective, 
    //         'course_id' => $request->college
    //     ]);

    //     return response()->json(['success' => 'Course Objective added successfully']);
    // }

    public function updateCourseObjective(Request $request, $id){
        $courseobjective = CourseObjective::where('id', $id)->first();
        $courseobjective->update([
            'course_objective' => $request->objective
        ]);
        
        return response()->json(['success' => 'Course Objective updated successfully']);
    }

    public function deleteCourseObjective($id){
        CourseObjective::destroy($id);
        return response()->json(['success' => 'Course Objective deleted successfully']);
    }

    public function goals(){
        $goals = Goal::with('college:id,name,abbreviation')->paginate(5);
        return response()->json($goals);
    }

    public function searchGoal(Request $request){
        $goals = Goal::with('college:id,name,abbreviation')->where('goal', 'like', '%'.$request->searchgoal.'%')->paginate(5);
        return response()->json($goals);
    }

    public function storeGoal(Request $request){
        Goal::create([
            'goal' => $request->goal_content, 
            'college_id' => $request->academic
        ]);

        return response()->json(['success' => 'Goal added successfully']);
    }

    public function updateGoal(Request $request, $id){
        $goals = Goal::where('id', $id)->first();
        $goals->update(['goal' => $request->goal,]);
        
        return response()->json(['success' => 'Goal updated successfully']);
    }

    public function deleteGoal($id){
        Goal::destroy($id);
        return response()->json(['success' => 'Goal deleted successfully']);
    }

    public function objectives(){
        $objectives = Objective::with('college:id,name,abbreviation')->paginate(8);
        return response()->json($objectives);
    }

    public function searchObjective(Request $request){
        $objectives = Objective::with('college:id,name,abbreviation')->where('objective', 'like', '%'.$request->searchobjective.'%')->paginate(8);
        return response()->json($objectives);
    }

    public function storeObjective(Request $request){
        Objective::create([
            'objective' => $request->objective_content, 
            'college_id' => $request->academic
        ]);

        return response()->json(['success' => 'Objective added successfully']);
    }

    public function updateObjective(Request $request, $id){
        $objectives = Objective::where('id', $id)->first();
        $objectives->update([
            'objective' => $request->objective, 
        ]);
        
        return response()->json(['success' => 'Objective updated successfully']);
    }

    public function deleteObjective($id){
        Objective::destroy($id);
        return response()->json(['success' => 'Objective deleted successfully']);
    }
    
    public function destroy($id){
        SchoolOfficials::destroy($id);
        return response()->json(['msg' => 'School Official deleted successfully'], 200);
    }
}
