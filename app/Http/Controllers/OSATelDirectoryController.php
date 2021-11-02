<?php

namespace App\Http\Controllers;

use App\Models\TelephoneDirectory;
use Illuminate\Http\Request;

class OSATelDirectoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function telephoneDirectories(){
        $tel = TelephoneDirectory::paginate(8);
        return response()->json($tel);
    }

    public function searchTelephoneDirectory(Request $request){
        $tel = TelephoneDirectory::where('name', 'like', '%'.$request->search.'%')->paginate(8);
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
}
