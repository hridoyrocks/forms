<?php
namespace App\Http\Controllers;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class PublicFormController extends Controller
{
    public function show(Form $form, Request $request)
    {
        if (!$form->is_active) {
            abort(404);
        }
        
        // Store UTM parameters in session
        $utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
        foreach ($utmParams as $param) {
            if ($request->has($param)) {
                session([$param => $request->get($param)]);
            }
        }
        
        return view('forms.public.show', compact('form'));
    }
    
    public function thankYou(Form $form)
    {
        if (!$form->is_active) {
            abort(404);
        }
        
        // Add this for debugging
        Log::info('Thank you page accessed for form: ' . $form->id);
        
        return view('forms.public.thank-you', compact('form'));
    }
}
