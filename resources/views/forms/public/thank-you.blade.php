<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Thank You | {{ $form->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Facebook Lead Event Tracking -->
<script>
    // Standard Lead Event
    fbq('track', 'Lead');
    
    // Custom Parameters (optional)
    fbq('track', 'FormSubmission', {
        'form_name': '{{ $form->name }}',
        'form_id': '{{ $form->id }}',
        'campaign': '{{ request()->get('utm_campaign') ?? "Not Set" }}'
    });
</script>

</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <div class="flex-grow flex items-center justify-center py-12">
            <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-center">
                            <!-- Success Icon -->
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            
                            <!-- Thank You Message -->
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">Thank You!</h1>
                            <p class="text-lg text-gray-600 mb-6">{{ $form->success_message ?? 'Your submission has been received. Our experts will contact you soon!' }}</p>
                            
                            <!-- Free Study Resources Section -->
                            <div class="mb-8 border-t border-b border-gray-200 py-6">
                                <h2 class="text-lg font-medium text-gray-800 mb-4">Free Study Abroad Resources</h2>
                                
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <a href="https://banglayielts.com" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-150">
                                        <div class="font-medium text-blue-800 mb-1">IELTS Preparation</div>
                                       
                                    </a>
                                    <a href="https://biic.com.bd" class="block p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-150">
                                        <div class="font-medium text-purple-800 mb-1">Scholarship Guide</div>
                                      
                                    </a>
                                    
                                </div>
                                
        

                                <!-- Book a Free Consultation -->
                                <a href="https://wa.me/+8801753477957" class="block p-5 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition duration-150 mb-6">
                                    <h3 class="text-lg font-medium text-white mb-1">Book a Free Consultation</h3>
                                    <p class="text-sm text-blue-100">Speak with our study abroad experts and plan your future!</p>
                                </a>
                            </div>

                        
                            
                            <!-- Social Media Links -->
                            <div class="mb-6">
                                <h3 class="text-md font-medium text-gray-700 mb-3">Connect With Us</h3>
                                <div class="flex justify-center space-x-4">
                                    <!-- Facebook -->
                                    <a href="https://facebook.com/BIIC.COM>BD" target="_blank" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-600 hover:bg-blue-700 transition-colors">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path>
                                        </svg>
                                    </a>
                                    
                                    
                                    
                                    <!-- YouTube for webinars -->
                                    <a href="https://youtube.com/yourchannel" target="_blank" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-red-600 hover:bg-red-700 transition-colors">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- WhatsApp for quick consultation -->
                                    <a href="https://wa.me/+8801XXXXXXXXX" target="_blank" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-green-500 hover:bg-green-600 transition-colors">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                         
                        
                            
                            <!-- Return to Homepage Button -->
                            <a href="https://facebook.com/BIIC.COM.BD" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none transition ease-in-out duration-150">
                                Explore More Resources
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center text-sm text-gray-500 mt-4">
                    &copy; BIIC. Made with ❤️ Rocks
                </div>
            </div>
        </div>
    </div>
</body>
</html>