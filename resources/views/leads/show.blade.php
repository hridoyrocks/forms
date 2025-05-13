<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lead Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('forms.leads.index', $form) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Back to Leads') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Submission for') }}: {{ $form->name }}</h3>
                        <div class="mt-2 text-sm text-gray-600">
                            <p>Submitted: {{ $lead->created_at->format('F d, Y \a\t H:i') }}</p>
                            <p>IP Address: {{ $lead->ip_address }}</p>
                        </div>
                    </div>

                    <div class="border rounded-md p-6 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Submitted Data') }}</h3>
                        
                        <div class="space-y-4">
                            @foreach($form->fields as $field)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">{{ $field['name'] }}</h4>
                                    <div class="mt-1 text-gray-900 bg-white p-3 rounded border border-gray-200">
                                        @if(isset($lead->data[$field['name']]))
                                            @if(is_array($lead->data[$field['name']]))
                                                {{ implode(', ', $lead->data[$field['name']]) }}
                                            @else
                                                {{ $lead->data[$field['name']] }}
                                            @endif
                                        @else
                                            <span class="text-gray-400">No data</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('forms.leads.index', $form) }}" class="text-sm text-gray-700 underline">
                            {{ __('Back to all leads') }}
                        </a>
                        
                        <form action="{{ route('forms.leads.destroy', [$form, $lead]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lead?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Delete Lead') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>