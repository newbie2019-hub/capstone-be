<?php

namespace App\Http\Controllers;

use App\Models\OrgUnitRole;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function all(){
        $rolepermission = Permission::get();
        return response()->json($rolepermission);
    }

    public function index(){
        $permission = OrgUnitRole::with(['permission:id,permission'])->paginate(8);
        return response()->json($permission);
    }

    public function searchRole(Request $request){
        $permission = OrgUnitRole::where('role', 'like', '%'.$request->search.'%')->with(['permission:id,permission'])->paginate(8);
        return response()->json($permission);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
       PermissionRole::where('org_unit_role_id', $id)->delete();
       foreach($request->permission as $permission){
           PermissionRole::create([
               'permission_id' => $permission['id'],
               'org_unit_role_id' => $id
           ]);
       }

       return response()->json(['msg' => 'Role permissions updated successfully!'], 200);
    }

    public function destroy($id)
    {
        PermissionRole::where('org_unit_role_id', $id)->delete();
        return response()->json(['msg' => 'All permissions were removed'], 200);
    }
}
