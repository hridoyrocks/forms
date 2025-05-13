<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Leads for') }}: {{ $form->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('forms.leads.download.csv', $form) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Download CSV') }}
                </a>
                <a href="{{ route('forms.show', $form) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Back to Form') }}
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
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Submissions') }}</h3>
                            <div class="text-sm text-gray-600">
                                {{ __('Total') }}: {{ $leads->total() }}
                            </div>
                        </div>
                    </div>

                    @if($leads->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">{{ __('No leads have been submitted for this form yet.') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('ID') }}
                                        </th>
                                        
                                        @foreach($form->fields as $field)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ $field['name'] }}
                                            </th>
                                        @endforeach
                                        
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Submitted At') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($leads as $lead)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $lead->id }}
                                            </td>
                                            
                                            @foreach($form->fields as $field)
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if(isset($lead->data[$field['name']]))
                                                        @if(is_array($lead->data[$field['name']]))
                                                            {{ implode(', ', $lead->data[$field['name']]) }}
                                                        @else
                                                            {{ $lead->data[$field['name']] }}
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endforeach
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $lead->created_at->format('M d, Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('forms.leads.show', [$form, $lead]) }}" class="text-blue-600 hover:text-blue-900">
                                                        {{ __('View') }}
                                                    </a>
                                                    <form action="{{ route('forms.leads.destroy', [$form, $lead]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lead?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $leads->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>