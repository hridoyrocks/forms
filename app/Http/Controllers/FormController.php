<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $forms = Auth::user()->forms()->latest()->get();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fields' => 'required|array|min:1',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,email,phone,number,textarea,select,checkbox,radio',
            'fields.*.required' => 'boolean',
            'fields.*.options' => 'nullable|array',
            'submit_button_text' => 'nullable|string|max:255',
            'success_message' => 'nullable|string',
        ]);

      // ইমেজ আপলোড হ্যান্ডলিং
        $coverImagePath = null;
        
        if ($request->hasFile('cover_image')) {
            try {
                // ফোল্ডার চেক
                if (!Storage::disk('public')->exists('form-covers')) {
                    Storage::disk('public')->makeDirectory('form-covers');
                }
                
                $coverImagePath = $request->file('cover_image')->store('form-covers', 'public');
                
                // লগিং
                Log::info('Cover image uploaded successfully', [
                    'path' => $coverImagePath
                ]);
            } catch (\Exception $e) {
                Log::error('Cover image upload failed', [
                    'error' => $e->getMessage()
                ]);
                
                return back()->withErrors(['cover_image' => 'ইমেজ আপলোড করতে সমস্যা হয়েছে: ' . $e->getMessage()]);
            }
        }

        $form = Auth::user()->forms()->create([
            'name' => $request->name,
            'description' => $request->description,
            'cover_image' => $coverImagePath,
            'fields' => $request->fields,
            'submit_button_text' => $request->submit_button_text ?? 'Submit',
            'success_message' => $request->success_message ?? 'Form submitted successfully!',
        ]);

        return redirect()->route('forms.show', $form)
            ->with('success', 'Form created successfully!');
    }

    public function show(Form $form)
    {
        $this->authorize('view', $form);
        
        return view('forms.show', compact('form'));
    }

    public function edit(Form $form)
    {
        $this->authorize('update', $form);
        
        return view('forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $this->authorize('update', $form);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fields' => 'required|array|min:1',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,email,phone,number,textarea,select,checkbox,radio',
            'fields.*.required' => 'boolean',
            'fields.*.options' => 'nullable|array',
            'submit_button_text' => 'nullable|string|max:255',
            'success_message' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

       // ইমেজ আপলোড হ্যান্ডলিং
        $coverImagePath = $form->cover_image;
        
        if ($request->hasFile('cover_image')) {
            try {
                // আগের ইমেজ থাকলে ডিলিট করুন
                if ($form->cover_image) {
                    Storage::disk('public')->delete($form->cover_image);
                }
                
                // ফোল্ডার চেক
                if (!Storage::disk('public')->exists('form-covers')) {
                    Storage::disk('public')->makeDirectory('form-covers');
                }
                
                $coverImagePath = $request->file('cover_image')->store('form-covers', 'public');
                
                // লগিং
                Log::info('Cover image updated successfully', [
                    'path' => $coverImagePath
                ]);
            } catch (\Exception $e) {
                Log::error('Cover image update failed', [
                    'error' => $e->getMessage()
                ]);
                
                return back()->withErrors(['cover_image' => 'ইমেজ আপডেট করতে সমস্যা হয়েছে: ' . $e->getMessage()]);
            }
        }

        $form->update([
            'name' => $request->name,
            'description' => $request->description,
            'cover_image' => $coverImagePath,
            'fields' => $request->fields,
            'submit_button_text' => $request->submit_button_text ?? 'Submit',
            'success_message' => $request->success_message ?? 'Form submitted successfully!',
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('forms.show', $form)
            ->with('success', 'Form updated successfully!');
    }

    public function destroy(Form $form)
    {
        $this->authorize('delete', $form);
        
        $form->delete();
        
        return redirect()->route('forms.index')
            ->with('success', 'Form deleted successfully!');
    }
    
    public function shareableLink(Form $form)
    {
        $this->authorize('view', $form);
        
        $url = route('forms.public.show', $form->id);
        
        return view('forms.shareable', compact('form', 'url'));
    }

    
}