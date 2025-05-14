<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $form->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <div class="flex-grow flex items-center justify-center py-12">
            <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('forms.public.submit', $form) }}" method="POST">
                            @csrf
                            
                            @if($form->cover_image)
    <div class="mb-4">
        <img src="{{ Storage::url($form->cover_image) }}" alt="{{ $form->name }}" class="w-full h-auto rounded-lg object-cover" style="max-height: 300px;">
    </div>
@endif

<h1 class="text-2xl font-bold mb-2">{{ $form->name }}</h1>
                            
                            @if($form->description)
                                <p class="mb-6 text-gray-600">{{ $form->description }}</p>
                            @endif
                            
                            @foreach($form->fields as $index => $field)
                                <div class="mb-4">
                                    <label for="field-{{ $index }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $field['name'] }}
                                        @if(isset($field['required']) && $field['required'])
                                            <span class="text-red-600">*</span>
                                        @endif
                                    </label>
                                    
                                    @switch($field['type'])
                                        @case('text')
                                            <input 
                                                type="text" 
                                                id="field-{{ $index }}" 
                                                name="fields[{{ $field['name'] }}]" 
                                                value="{{ old('fields.' . $field['name']) }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                            @break
                                        @case('email')
                                            <input 
                                                type="email" 
                                                id="field-{{ $index }}" 
                                                name="fields[{{ $field['name'] }}]" 
                                                value="{{ old('fields.' . $field['name']) }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                            @break
                                        @case('phone')
                                            <input 
                                                type="tel" 
                                                id="field-{{ $index }}" 
                                                name="fields[{{ $field['name'] }}]" 
                                                value="{{ old('fields.' . $field['name']) }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                            @break
                                        @case('number')
                                            <input 
                                                type="number" 
                                                id="field-{{ $index }}" 
                                                name="fields[{{ $field['name'] }}]" 
                                                value="{{ old('fields.' . $field['name']) }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                            @break
                                        @case('textarea')
                                            <textarea 
                                                id="field-{{ $index }}" 
                                                name="fields[{{ $field['name'] }}]" 
                                                rows="3" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >{{ old('fields.' . $field['name']) }}</textarea>
                                            @break
                                        @case('select')
                                            <select 
                                                id="field-{{ $index }}" 
                                                name="fields[{{ $field['name'] }}]" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                                <option value="">Select an option</option>
                                                @if(isset($field['options']) && is_array($field['options']))
                                                    @foreach($field['options'] as $option)
                                                        <option value="{{ $option }}" {{ old('fields.' . $field['name']) == $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @break
                                        @case('checkbox')
                                            @if(isset($field['options']) && is_array($field['options']))
                                                @foreach($field['options'] as $optionIndex => $option)
                                                    <div class="mt-1">
                                                        <label class="inline-flex items-center">
                                                            <input 
                                                                type="checkbox" 
                                                                name="fields[{{ $field['name'] }}][]" 
                                                                value="{{ $option }}" 
                                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                {{ is_array(old('fields.' . $field['name'])) && in_array($option, old('fields.' . $field['name'])) ? 'checked' : '' }}
                                                            >
                                                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @break
                                        @case('radio')
                                            @if(isset($field['options']) && is_array($field['options']))
                                                @foreach($field['options'] as $optionIndex => $option)
                                                    <div class="mt-1">
                                                        <label class="inline-flex items-center">
                                                            <input 
                                                                type="radio" 
                                                                name="fields[{{ $field['name'] }}]" 
                                                                value="{{ $option }}" 
                                                                class="border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                {{ old('fields.' . $field['name']) == $option ? 'checked' : '' }}
                                                                {{ isset($field['required']) && $field['required'] && $optionIndex === 0 ? 'required' : '' }}
                                                            >
                                                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @break
                                    @endswitch
                                    
                                    @error('fields.' . $field['name'])
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            
                            <div class="mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ $form->submit_button_text }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    © {{ date('Y') }} BIIC. Made with ❤️ Rocks
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
