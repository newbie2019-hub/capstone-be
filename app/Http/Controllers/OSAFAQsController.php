<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;

class OSAFAQsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function faqs(){
        $faq = Faqs::paginate(5);
        return response()->json($faq);
    }

    public function storeFaqs(Request $request){
        $faqs = Faqs::create([
            'question' => $request->question,
            'answer' => $request->answer
        ]);
        return response()->json($faqs);
    }

    public function updateFaqs(Request $request, $id){
        $faqs = Faqs::where('id', $id)->first();
        $faqs->update(['question' => $request->question, 'answer' => $request->answer]);
        return response()->json(['success' => 'FAQ updated successfully']);
    }

    public function searchFaqs(Request $request){
        $faqs = Faqs::where('question', 'like', '%'.$request->search.'%')->orWhere('answer', 'like', '%'.$request->search.'%')->paginate(5);
        return response()->json($faqs);
    }

    public function deleteFaqs($id){
        Faqs::destroy($id);
        return response()->json(['success' => 'FAQ deleted successfully']);
    }
}
