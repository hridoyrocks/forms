<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TestUploadController extends Controller
{
    public function index()
    {
        return view('test-upload');
    }

    public function upload(Request $request)
    {
        // ভ্যালিডেশন
        $request->validate([
            'test_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // লগিং
        Log::info('File upload test initiated', [
            'has_file' => $request->hasFile('test_image'),
            'storage_path' => storage_path('app/public')
        ]);

        if ($request->hasFile('test_image')) {
            $file = $request->file('test_image');
            
            // ফাইল ইনফো লগিং
            Log::info('File details:', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'error' => $file->getError()
            ]);
            
            try {
                // ফোল্ডার এক্সিস্ট করে কিনা চেক করা
                if (!Storage::disk('public')->exists('test-uploads')) {
                    Storage::disk('public')->makeDirectory('test-uploads');
                    Log::info('Created directory: test-uploads');
                }
                
                // ফাইল আপলোড
                $path = $file->store('test-uploads', 'public');
                Log::info('File stored at: ' . $path);
                
                // পূর্ণ URL তৈরি করা
                $url = Storage::url($path);
                
                return view('test-upload', [
                    'success' => true,
                    'message' => 'File uploaded successfully!',
                    'path' => $path,
                    'url' => $url
                ]);
            } catch (\Exception $e) {
                Log::error('File upload error: ' . $e->getMessage());
                
                return view('test-upload', [
                    'error' => true,
                    'message' => 'Error uploading file: ' . $e->getMessage()
                ]);
            }
        }
        
        return view('test-upload', [
            'error' => true,
            'message' => 'No file selected'
        ]);
    }
}