<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Csv\Writer;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
   use AuthorizesRequests;
    
    public function index(Form $form)
    {
        $this->authorize('viewLeads', $form);
        
        $leads = $form->leads()->latest()->paginate(20);
        return view('leads.index', compact('form', 'leads'));
    }

    public function store(Request $request, Form $form)
    {
        // Log the form submission for debugging
        Log::info('Form submission started for form: ' . $form->id);
        
        // এই route public, কোন auth না লাগার জন্য
        if (!$form->is_active) {
            return redirect()->back()->with('error', 'This form is no longer active.');
        }
        
        $rules = [];
        
        foreach ($form->fields as $field) {
            $rule = 'nullable';
            
            if (isset($field['required']) && $field['required']) {
                $rule = 'required';
            }
            
            if ($field['type'] === 'email') {
                $rule .= '|email';
            } elseif ($field['type'] === 'number') {
                $rule .= '|numeric';
            } elseif ($field['type'] === 'phone') {
                $rule .= '|string|min:10';
            }
            
            $rules['fields.' . $field['name']] = $rule;
        }
        
        $validatedData = $request->validate($rules);
        
        $lead = $form->leads()->create([
            'data' => $validatedData['fields'] ?? [],
            'ip_address' => $request->ip(),
        ]);
        
        Log::info('Lead created successfully: ' . $lead->id);
        
        // Redirect to the thank you page
        return redirect()->route('forms.public.thank-you', $form);
    }

    public function show(Form $form, Lead $lead)
    {
        $this->authorize('viewLeads', $form);
        
        return view('leads.show', compact('form', 'lead'));
    }

    public function destroy(Form $form, Lead $lead)
    {
        $this->authorize('deleteLeads', $form);
        
        $lead->delete();
        
        return redirect()->route('forms.leads.index', $form)
            ->with('success', 'Lead deleted successfully!');
    }
    
    public function downloadCsv(Form $form)
    {
        $this->authorize('viewLeads', $form);
        
        $leads = $form->leads()->latest()->get();
        
        // CSV ফাইল তৈরি
        $csv = Writer::createFromString('');
        
        // ফিল্ড নাম (হেডার) যোগ করি
        $headers = array_map(function ($field) {
            return $field['name'];
        }, $form->fields);
        
        $csv->insertOne(array_merge(['ID', 'Created At'], $headers));
        
        // লিড ডাটা যোগ করি
        foreach ($leads as $lead) {
            $row = [
                $lead->id,
                $lead->created_at->format('Y-m-d H:i:s'),
            ];
            
            foreach ($headers as $header) {
                $row[] = $lead->data[$header] ?? '';
            }
            
            $csv->insertOne($row);
        }
        
        $filename = Str::slug($form->name) . '-leads-' . date('Y-m-d') . '.csv';
        
        return response($csv->getContent())
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}