<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Share Form') }}: {{ $form->name }}
            </h2>
            <div class="flex space-x-2">
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
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Share Your Form</h3>
                        <p class="mt-2 text-sm text-gray-600">Copy the link below to share your form with others.</p>
                    </div>

                    <div class="mb-6">
                        <label for="shareable-link" class="block text-sm font-medium text-gray-700 mb-1">Shareable Link</label>
                        <div class="flex">
                            <input type="text" id="shareable-link" value="{{ $url }}" class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                            <button type="button" onclick="copyLink()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Copy
                            </button>
                        </div>
                        <div id="copy-message" class="mt-2 text-sm text-green-600 hidden">
                            Link copied to clipboard!
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Preview</h3>
                        <div class="border rounded-md p-4">
                            <p>You can view your public form here:</p>
                            <a href="{{ $url }}" target="_blank" class="text-blue-600 hover:underline">{{ $url }}</a>
                        </div>
                    </div>

                    @if(!$form->is_active)
                        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                            <strong>Warning:</strong> This form is currently inactive. It will not be accessible to users until you activate it.
                            <a href="{{ route('forms.edit', $form) }}" class="underline">Edit form settings</a> to activate it.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyLink() {
            const linkInput = document.getElementById('shareable-link');
            linkInput.select();
            document.execCommand('copy');
            
            const copyMessage = document.getElementById('copy-message');
            copyMessage.classList.remove('hidden');
            
            setTimeout(() => {
                copyMessage.classList.add('hidden');
            }, 3000);
        }
    </script>
</x-app-layout>