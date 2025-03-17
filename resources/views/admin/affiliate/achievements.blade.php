{{-- resources/views/admin/affiliate/achievements.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Achievements Management</h1>
                    <button type="button" onclick="showCreateForm()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Achievement
                    </button>
                </div>

                @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <!-- Create Achievement Form (Hidden by default) -->
                <div id="create-form" class="hidden mb-8 bg-gray-50 p-6 rounded-lg shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Create New Achievement</h2>
                    <form action="{{ route('admin.affiliate.store-achievement') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Achievement Name</label>
                                <input type="text" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            
                            <div>
                                <label for="points_value" class="block text-sm font-medium text-gray-700">Points Value</label>
                                <input type="number" name="points_value" id="points_value" min="0" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                            </div>

                            <div>
                                <label for="criteria_type" class="block text-sm font-medium text-gray-700">Criteria Type</label>
                                <select name="criteria_type" id="criteria_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                    <option value="referrals">Referrals Count</option>
                                    <option value="earnings">Total Earnings</option>
                                    <option value="tier">Tier Level</option>
                                    <option value="rank">Leaderboard Rank</option>
                                </select>
                            </div>

                            <div>
                                <label for="criteria_threshold" class="block text-sm font-medium text-gray-700">Threshold Value</label>
                                <input type="number" name="criteria_threshold" id="criteria_threshold" min="1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <p class="mt-1 text-xs text-gray-500" id="threshold-help-text">Number of referrals required</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="badge_image" class="block text-sm font-medium text-gray-700">Badge Image Path</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">badges/</span>
                                    <input type="text" name="badge_image" id="badge_image" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="achievement_name.svg">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Path to the SVG badge image in the public/storage/badges directory</p>
                            </div>

                            <div class="sm:col-span-2">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_active" name="is_active" type="checkbox" value="1" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-700">Active</label>
                                        <p class="text-gray-500">Make this achievement available for users to earn</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" onclick="hideCreateForm()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Achievement
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Achievements Table -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Badge
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Criteria
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Points
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Awarded
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($achievements as $achievement)
                                <tr id="achievement-row-{{ $achievement->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($achievement->badge_image)
                                            <img src="{{ Storage::url($achievement->badge_image) }}" alt="{{ $achievement->name }}" class="h-10 w-10">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $achievement->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $achievement->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if(isset($achievement->criteria['type']) && isset($achievement->criteria['threshold']))
                                                @if($achievement->criteria['type'] === 'referrals')
                                                    {{ $achievement->criteria['threshold'] }} referrals
                                                @elseif($achievement->criteria['type'] === 'earnings')
                                                    ₹{{ number_format($achievement->criteria['threshold'], 2) }} earnings
                                                @elseif($achievement->criteria['type'] === 'tier')
                                                    Tier {{ $achievement->criteria['threshold'] }}
                                                @elseif($achievement->criteria['type'] === 'rank')
                                                    Top {{ $achievement->criteria['threshold'] }} rank
                                                @endif
                                            @else
                                                Unknown criteria
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $achievement->points_value }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $achievement->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $achievement->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $achievement->users_count ?? 0 }} users
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button type="button" onclick="showEditForm({{ $achievement->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                        <form action="{{ route('admin.affiliate.delete-achievement', $achievement->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this achievement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Edit Achievement Form (Hidden by default) -->
                                <tr id="edit-form-{{ $achievement->id }}" class="hidden bg-gray-50">
                                    <td colspan="8" class="px-6 py-4">
                                        <form action="{{ route('admin.affiliate.update-achievement', $achievement->id) }}" method="POST" class="space-y-6">
                                            @csrf
                                            @method('PATCH')
                                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                                <div>
                                                    <label for="edit_name_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Achievement Name</label>
                                                    <input type="text" name="name" id="edit_name_{{ $achievement->id }}" value="{{ $achievement->name }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                </div>
                                                
                                                <div>
                                                    <label for="edit_points_value_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Points Value</label>
                                                    <input type="number" name="points_value" id="edit_points_value_{{ $achievement->id }}" value="{{ $achievement->points_value }}" min="0" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                </div>

                                                <div class="sm:col-span-2">
                                                    <label for="edit_description_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Description</label>
                                                    <textarea name="description" id="edit_description_{{ $achievement->id }}" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ $achievement->description }}</textarea>
                                                </div>

                                                <div>
                                                    <label for="edit_criteria_type_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Criteria Type</label>
                                                    <select name="criteria_type" id="edit_criteria_type_{{ $achievement->id }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                                        <option value="referrals" {{ isset($achievement->criteria['type']) && $achievement->criteria['type'] === 'referrals' ? 'selected' : '' }}>Referrals Count</option>
                                                        <option value="earnings" {{ isset($achievement->criteria['type']) && $achievement->criteria['type'] === 'earnings' ? 'selected' : '' }}>Total Earnings</option>
                                                        <option value="tier" {{ isset($achievement->criteria['type']) && $achievement->criteria['type'] === 'tier' ? 'selected' : '' }}>Tier Level</option>
                                                        <option value="rank" {{ isset($achievement->criteria['type']) && $achievement->criteria['type'] === 'rank' ? 'selected' : '' }}>Leaderboard Rank</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label for="edit_criteria_threshold_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Threshold Value</label>
                                                    <input type="number" name="criteria_threshold" id="edit_criteria_threshold_{{ $achievement->id }}" value="{{ isset($achievement->criteria['threshold']) ? $achievement->criteria['threshold'] : '' }}" min="1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                </div>

                                                <div class="sm:col-span-2">
                                                    <label for="edit_badge_image_{{ $achievement->id }}" class="block text-sm font-medium text-gray-700">Badge Image Path</label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">badges/</span>
                                                        <input type="text" name="badge_image" id="edit_badge_image_{{ $achievement->id }}" value="{{ str_replace('badges/', '', $achievement->badge_image) }}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-2">
                                                    <div class="flex items-start">
                                                        <div class="flex items-center h-5">
                                                            <input id="edit_is_active_{{ $achievement->id }}" name="is_active" type="checkbox" value="1" {{ $achievement->is_active ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label for="edit_is_active_{{ $achievement->id }}" class="font-medium text-gray-700">Active</label>
                                                            <p class="text-gray-500">Make this achievement available for users to earn</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex justify-end space-x-3">
                                                <button type="button" onclick="hideEditForm({{ $achievement->id }})" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Update Achievement
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                @if(count($achievements) === 0)
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No achievements found. Create one to get started.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showCreateForm() {
        document.getElementById('create-form').classList.remove('hidden');
    }
    
    function hideCreateForm() {
        document.getElementById('create-form').classList.add('hidden');
    }
    
    function showEditForm(id) {
        document.getElementById('achievement-row-' + id).classList.add('hidden');
        document.getElementById('edit-form-' + id).classList.remove('hidden');
    }
    
    function hideEditForm(id) {
        document.getElementById('achievement-row-' + id).classList.remove('hidden');
        document.getElementById('edit-form-' + id).classList.add('hidden');
    }
    
    // Update the help text based on criteria type
    document.getElementById('criteria_type').addEventListener('change', function() {
        const helpText = document.getElementById('threshold-help-text');
        
        switch(this.value) {
            case 'referrals':
                helpText.textContent = 'Number of referrals required';
                break;
            case 'earnings':
                helpText.textContent = 'Amount of earnings in rupees required (e.g. 1500)';
                break;
            case 'tier':
                helpText.textContent = 'Tier level required (e.g. 3)';
                break;
            case 'rank':
                helpText.textContent = 'Leaderboard rank required (e.g. 10 for top 10)';
                break;
        }
    });
    
    // Add event listeners for edit forms as well
    document.querySelectorAll('[id^="edit_criteria_type_"]').forEach(function(element) {
        element.addEventListener('change', function() {
            const id = this.id.split('_').pop();
            const helpTextId = 'edit_criteria_threshold_' + id;
            
            switch(this.value) {
                case 'referrals':
                    document.getElementById(helpTextId).placeholder = 'Number of referrals';
                    break;
                case 'earnings':
                    document.getElementById(helpTextId).placeholder = 'Amount in rupees';
                    break;
                case 'tier':
                    document.getElementById(helpTextId).placeholder = 'Tier level';
                    break;
                case 'rank':
                    document.getElementById(helpTextId).placeholder = 'Leaderboard rank';
                    break;
            }
        });
    });
</script>
@endsection