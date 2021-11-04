<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OSAFAQsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function faqs(){
        if (!Gate::allows('osa_faqs_management')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }
        $faq = Faqs::paginate(8);
        return response()->json($faq);
    }

    public function storeFaqs(Request $request){
        if (!Gate::allows('osa_faqs_management')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }
        $faqs = Faqs::create([
            'question' => $request->question,
            'answer' => $request->answer
        ]);
        return response()->json($faqs);
    }

    public function updateFaqs(Request $request, $id){
        if (!Gate::allows('osa_faqs_management')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }
        $faqs = Faqs::where('id', $id)->first();
        $faqs->update(['question' => $request->question, 'answer' => $request->answer]);
        return response()->json(['success' => 'FAQ updated successfully']);
    }

    public function searchFaqs(Request $request){
        if (!Gate::allows('osa_faqs_management')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }
        $faqs = Faqs::where('question', 'like', '%'.$request->search.'%')->orWhere('answer', 'like', '%'.$request->search.'%')->paginate(8);
        return response()->json($faqs);
    }

    public function deleteFaqs($id){
        if (!Gate::allows('osa_faqs_management')) {
            return response()->json(['msg' => 'User has no permission'], 422);
        }
        Faqs::destroy($id);
        return response()->json(['success' => 'FAQ deleted successfully']);
    }
}
