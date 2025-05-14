<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Form') }}: {{ $form->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('forms.update', $form) }}" method="POST" id="form-builder">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Form Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $form->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $form->description) }}</textarea>
                        </div>
                        
<!-- কভার ইমেজ ফিল্ড -->
            <div class="mb-6">
                <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image (Optional)</label>
                
                @if($form->cover_image)
                    <div class="mt-2 mb-4">
                        <p class="text-sm font-medium text-gray-700">Current Cover Image:</p>
                        <img src="{{ Storage::url($form->cover_image) }}" alt="Cover Image" class="mt-2 rounded-lg max-h-40">
                        <p class="mt-1 text-xs text-gray-500">Upload a new image to replace this one.</p>
                    </div>
                @endif
                
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100">
                <p class="mt-1 text-sm text-gray-500">Recommended size: 1200 x 400px. Max 2MB.</p>
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Form Fields</label>
                            
                            <div id="fields-container">
                                <!-- জাভাস্ক্রিপ্ট দিয়ে এই কন্টেইনারে ফিল্ড যোগ করা হবে -->
                            </div>
                            
                            <button type="button" id="add-field" class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('+ Add Field') }}
                            </button>
                        </div>
                        
                        <div class="mb-6">
                            <label for="submit_button_text" class="block text-sm font-medium text-gray-700">Submit Button Text</label>
                            <input type="text" name="submit_button_text" id="submit_button_text" value="{{ old('submit_button_text', $form->submit_button_text) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div class="mb-6">
                            <label for="success_message" class="block text-sm font-medium text-gray-700">Success Message</label>
                            <input type="text" name="success_message" id="success_message" value="{{ old('success_message', $form->success_message) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div class="mb-6">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $form->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Form is active</span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('forms.show', $form) }}" class="text-sm text-gray-700 underline mr-4">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Form') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ফিল্ড টেমপ্লেট (জাভাস্ক্রিপ্ট দ্বারা ব্যবহৃত হবে) -->
    <template id="field-template">
        <div class="field-item bg-gray-50 p-4 rounded-md mb-4">
            <div class="flex justify-between items-start mb-4">
                <div class="w-1/3 pr-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Field Name</label>
                    <input type="text" name="fields[INDEX][name]" class="field-name mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div class="w-1/3 px-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Field Type</label>
                    <select name="fields[INDEX][type]" class="field-type mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="text">Text</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="number">Number</option>
                        <option value="textarea">Textarea</option>
                        <option value="select">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="radio">Radio Button</option>
                    </select>
                </div>
                <div class="w-1/4 pl-2 flex items-end">
                    <label class="inline-flex items-center mt-1">
                        <input type="checkbox" name="fields[INDEX][required]" value="1" class="required-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Required</span>
                    </label>
                    <button type="button" class="remove-field ml-auto text-red-600 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="options-container hidden">
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Options (one per line)</label>
                    <textarea name="fields[INDEX][options]" rows="3" class="options-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
            </div>
        </div>
    </template>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fieldsContainer = document.getElementById('fields-container');
            const addFieldButton = document.getElementById('add-field');
            const fieldTemplate = document.getElementById('field-template');
            let fieldIndex = 0;
            const existingFields = @json($form->fields);
            
            // ফিল্ড যোগ করার ফাংশন
            function addField(fieldData = null) {
                const template = fieldTemplate.content.cloneNode(true);
                
                // ইনডেক্স আপডেট
                template.querySelectorAll('[name*="INDEX"]').forEach(el => {
                    el.name = el.name.replace('INDEX', fieldIndex);
                });
                
                // ইভেন্ট লিসেনার যোগ করি
                fieldsContainer.appendChild(template);
                
                const newField = fieldsContainer.lastElementChild;
                
                // ফিল্ড ডাটা সেট করি যদি থাকে
                if (fieldData) {
                    newField.querySelector('.field-name').value = fieldData.name || '';
                    
                    const fieldType = newField.querySelector('.field-type');
                    fieldType.value = fieldData.type || 'text';
                    
                    if (fieldData.required) {
                        newField.querySelector('.required-checkbox').checked = true;
                    }
                    
                    const optionsContainer = newField.querySelector('.options-container');
                    const optionsTextarea = newField.querySelector('.options-textarea');
                    
                    if (fieldData.type === 'select' || fieldData.type === 'checkbox' || fieldData.type === 'radio') {
                        optionsContainer.classList.remove('hidden');
                        if (fieldData.options && Array.isArray(fieldData.options)) {
                            optionsTextarea.value = fieldData.options.join('\n');
                        }
                    }
                }
                
                // টাইপ চেঞ্জ ইভেন্ট
                const fieldType = newField.querySelector('.field-type');
                const optionsContainer = newField.querySelector('.options-container');
                
                fieldType.addEventListener('change', function() {
                    if (this.value === 'select' || this.value === 'checkbox' || this.value === 'radio') {
                        optionsContainer.classList.remove('hidden');
                    } else {
                        optionsContainer.classList.add('hidden');
                    }
                });
                
                // রিমুভ বাটন ক্লিক
                newField.querySelector('.remove-field').addEventListener('click', function() {
                    newField.remove();
                });
                
                fieldIndex++;
            }
            
            // অ্যাড ফিল্ড বাটন ক্লিক
            addFieldButton.addEventListener('click', function() {
                addField();
            });
            
            // আগের ফিল্ডগুলো লোড করি (যদি থাকে)
            if (existingFields && existingFields.length > 0) {
                existingFields.forEach(field => {
                    addField(field);
                });
            } else {
                // নতুন ফর্মের জন্য একটি ডিফল্ট ফিল্ড যোগ করি
                addField();
            }
            
            // ফর্ম সাবমিট ভ্যালিডেশন
            document.getElementById('form-builder').addEventListener('submit', function(e) {
                if (fieldsContainer.children.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one field to your form.');
                }
            });
        });
    </script>
</x-app-layout>