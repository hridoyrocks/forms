<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $form->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('forms.leads.index', $form) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('View Leads') }}
                </a>
                <a href="{{ route('forms.edit', $form) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit Form') }}
                </a>
                <a href="{{ route('forms.shareable', $form) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Share Form') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Form Details</h3>
                        <div class="mt-2 flex items-center">
                            <span class="mr-2">Status:</span>
                            @if($form->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ __('Active') }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ __('Inactive') }}
                                </span>
                            @endif
                        </div>
                        @if($form->description)
                            <p class="mt-2 text-sm text-gray-600">{{ $form->description }}</p>
                        @endif
                        <div class="mt-2 text-sm text-gray-600">
                            <p>Created: {{ $form->created_at->format('M d, Y H:i') }}</p>
                            <p>Last Updated: {{ $form->updated_at->format('M d, Y H:i') }}</p>
                            <p>Total Leads: {{ $form->leads->count() }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Form Preview</h3>
                        <div class="border rounded-md p-6 bg-gray-50">
                            <h2 class="text-xl font-bold mb-4">{{ $form->name }}</h2>
                            
                            @if($form->description)
                                <p class="mb-4 text-gray-600">{{ $form->description }}</p>
                            @endif
                            
                            @foreach($form->fields as $field)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $field['name'] }}
                                        @if(isset($field['required']) && $field['required'])
                                            <span class="text-red-600">*</span>
                                        @endif
                                    </label>
                                    
                                    @switch($field['type'])
                                        @case('text')
                                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled>
                                            @break
                                        @case('email')
                                            <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled>
                                            @break
                                        @case('phone')
                                            <input type="tel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled>
                                            @break
                                        @case('number')
                                            <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled>
                                            @break
                                        @case('textarea')
                                            <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" disabled></textarea>
                                            @break
                                        @case('select')
                                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled>
                                                <option value="">Select an option</option>
                                                @if(isset($field['options']) && is_array($field['options']))
                                                    @foreach($field['options'] as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @break
                                        @case('checkbox')
                                            @if(isset($field['options']) && is_array($field['options']))
                                                @foreach($field['options'] as $option)
                                                    <div class="mt-1">
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled>
                                                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @break
                                        @case('radio')
                                            @if(isset($field['options']) && is_array($field['options']))
                                                @foreach($field['options'] as $option)
                                                    <div class="mt-1">
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" class="border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled>
                                                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @break
                                    @endswitch
                                </div>
                            @endforeach
                            
                            <div class="mt-6">
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest opacity-50 cursor-not-allowed">
                                    {{ $form->submit_button_text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>