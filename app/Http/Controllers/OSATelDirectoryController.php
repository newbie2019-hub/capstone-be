<?php

namespace App\Http\Controllers;

use App\Models\TelephoneDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OSATelDirectoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function telephoneDirectories(){
        if (!Gate::allows('osa_tel_directory')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        $tel = TelephoneDirectory::paginate(8);
        return response()->json($tel);
    }

    public function searchTelephoneDirectory(Request $request){
        if (!Gate::allows('osa_tel_directory')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        $tel = TelephoneDirectory::where('name', 'like', '%'.$request->search.'%')->paginate(8);
        return response()->json($tel);
    }

    public function storeTelephone(Request $request){
        if (!Gate::allows('osa_tel_directory')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        $tel = TelephoneDirectory::create([
            'name' => $request->name,
            'tel_num' => $request->tel_num
        ]);
        return response()->json($tel);
    }

    public function updateTelephone(Request $request, $id){
        if (!Gate::allows('osa_tel_directory')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }

        $tel = TelephoneDirectory::where('id', $id)->first();
        $tel->update(['name' => $request->name, 'tel_num' => $request->tel_num]);
        return response()->json(['success' => 'Telephone updated successfully']);
    }

    public function deleteTelephone($id){
        if (!Gate::allows('osa_tel_directory')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }
        
        TelephoneDirectory::destroy($id);
        return response()->json(['success' => 'Telephone deleted successfully']);
    }
}
