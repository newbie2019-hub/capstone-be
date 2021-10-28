<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Organization;
use App\Models\OrgUnit;
use App\Models\OrgUnitRole;
use Illuminate\Http\Request;

class DepartmentandOrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['index']]);
    }
    
    public function index(){
        $organization = Organization::get(['id', 'name']);
        $organization_roles = OrgUnitRole::where('type', 'Organization')->get(['id', 'role']);
        $unit = Department::get(['id', 'name']);
        $unit_roles = OrgUnitRole::where('type', 'Department')->get(['id', 'role']);

        return response()->json(['organization' => $organization, 'organization_roles' => $organization_roles, 'unit' => $unit, 'unit_roles' => $unit_roles ]);
    }

    public function organization(){
        $org = Organization::with(['department'])->paginate(8);
        return response()->json($org);
    }


    public function orgRoles(){
        $orgroles = OrgUnitRole::where('type', 'Organization')->paginate(8);
        return response()->json($orgroles);
    }

    public function updateOrgRole(Request $request){
        $role = OrgUnitRole::where('id', $request->id)->first();
        $role->update(['role' => $request->role]);
        return response()->json(['msg' => 'Role updated successfully!'], 200);
    }

    public function deleteOrgRoles(Request $request, $id){
        $orgrole = OrgUnitRole::with(['accounts'])->where('id', $id)->first();

        if($request->role_id){
            if($orgrole->accounts){
                foreach($orgrole->accounts as $acc){
                    $acc->update(['org_unit_role_id' => $request->role_id]);
                }
            }
        }
        
        OrgUnitRole::destroy($id);
        return response()->json(['msg'=> 'Role deleted successfully']);

    }

    public function searchOrganization(Request $request){
        $org = Organization::where('name', 'like', '%'.$request->search.'%')->paginate(8);
        return response()->json($org);
    }

    public function searchOrganizationRole(Request $request){
        $orgrole = OrgUnitRole::where('role', 'like', '%'.$request->search.'%')->where('type', 'Organization')->paginate(8);
        return response()->json($orgrole);
    }

    public function storeOrgRole(Request $request){
        $role = OrgUnitRole::create([
            'role' => $request->role,
            'type' => 'Organization'
        ]);

        return response()->json($role);
    }

    public function updateOrganization(Request $request, $id){
        $organization = Organization::findOrFail($id);

        $org = [
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'department_id' => $request->department_id
        ];

        if($request->image){
            $org['image'] = $request->image;
        } 

        $organization->update($org);
        return response()->json(['msg' => 'Organization updated successfully']);
    }
    /// NEED TO BE FIX
    public function deleteOrganization(Request $request, $id){
        $organization = OrgUnit::with(['accounts'])->where('id', $id)->first();

        if($request->organization_id){
            if($organization->accounts){
                foreach($organization->accounts as $acc){
                    $acc->update(['org_unit_id' => $request->organization_id]);
                }
            }
        }

        Organization::destroy($id);
        return response()->json(['msg' => 'Organization deleted successfully!']);
    }


    public function storeDepartment(Request $request){
        $department = Department::create([
            'name' => $request->department,
            'abbreviation' => $request->abbreviation
        ]);

        return response()->json($department);
    }

    public function storeOrganization(Request $request){
        $data = [
            'name' => $request->organization,
            'abbreviation' => $request->abbreviation,
        ];

        if(!empty($request->department_id)){
            $data['department_id'] = $request->department_id;
        }

        $department = Organization::create($data);

        return response()->json($department);
    }

    public function department(){
        $unit = Department::paginate(8);
        return response()->json($unit);
    }

    public function storeDepRole(Request $request){
        $role = OrgUnitRole::create([
            'role' => $request->role,
            'type' => 'Department'
        ]);

        return response()->json($role);
    }

    public function depRoles(){
        $deproles = OrgUnitRole::where('type', 'Department')->paginate(8);
        return response()->json($deproles);
    }

    public function searchDepartment(Request $request){
        $unit = Department::where('name', 'like', '%'.$request->search.'%')->paginate(8);
        return response()->json($unit);
    }

    public function searchDepartmentRole(Request $request){
        $unit = OrgUnitRole::where('role', 'like', '%'.$request->search.'%')->where('type', 'Department')->paginate(8);
        return response()->json($unit);
    }

    public function updateDepRole(Request $request){
        $role = OrgUnitRole::where('id', $request->role_id)->first();
        $role->update(['role' => $request->role]);
        return response()->json(['msg' => 'Role updated successfully!'], 200);
    }

    public function deleteDepRoles(Request $request, $id){

        $unitrole = OrgUnitRole::with(['accounts'])->where('id', $id)->first();

        if($request->role_id){
            if($unitrole->accounts){
                foreach($unitrole->accounts as $acc){
                    $acc->update(['org_unit_role_id' => $request->role_id]);
                }
            }
        }

        OrgUnitRole::destroy($id);

        return response()->json(['msg'=> 'Role deleted successfully']);
    }

    public function updateDepartment(Request $request, $id){
        $unit = Department::findOrFail($id);

        $department = [
            'name' => $request->name
        ];

        if($request->image){
            $department['image'] = $request->image;
        } 

        $unit->update($department);
        return response()->json(['success' => 'Department updated successfully'], 200);
    }

    public function deleteDepartment(Request $request, $id){
        $unit = OrgUnit::with(['accounts'])->where('id', $id)->first();

        if($request->department_id){
            if($unit->accounts){
                foreach($unit->accounts as $acc){
                    $acc->update(['org_unit_id' => $request->department_id]);
                }
            }
        }
        
        Department::destroy($id);
        return response()->json(['msg' => 'Department deleted successfully!']);
    }

    public function uploadDepartmentImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function uploadOrganizationImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }
}
