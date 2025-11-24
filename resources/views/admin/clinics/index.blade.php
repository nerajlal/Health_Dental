@extends('layouts.app')

@section('title', 'Manage Clinics')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manage Clinics</h1>
            <p class="mt-2 text-gray-600">Review partnership requests and manage existing clinics</p>
        </div>
        <a href="{{ route('admin.clinics.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-plus mr-2"></i>Add Clinic Manually
        </a>
    </div>

    <!-- Pending Partner Requests -->
    @if($pendingRequests->count() > 0)
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-yellow-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-clock text-yellow-600 text-xl mr-3"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Pending Partnership Requests</h2>
                        <p class="text-sm text-gray-600">{{ $pendingRequests->count() }} clinic(s) waiting for approval</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clinic Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Business Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pendingRequests as $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $request->business_name }}</div>
                            <div class="text-sm text-gray-500">{{ $request->name }}</div>
                            @if($request->license_number)
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-id-card mr-1"></i>License: {{ $request->license_number }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $request->email }}</div>
                            <div class="text-sm text-gray-500">{{ $request->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $request->business_address }}</div>
                            <div class="text-sm text-gray-500">{{ $request->city }}, {{ $request->state }} {{ $request->zip_code }}</div>
                            @if($request->years_in_business)
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i>{{ $request->years_in_business }} years in business
                            </div>
                            @endif
                            @if($request->website)
                            <div class="text-xs text-blue-600 mt-1">
                                <a href="{{ $request->website }}" target="_blank" class="hover:underline">
                                    <i class="fas fa-globe mr-1"></i>Website
                                </a>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $request->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">{{ $request->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-2">
                                <!-- View Details Button -->
                                <button onclick="showRequestDetails({{ $request->id }})" 
                                        class="text-blue-600 hover:text-blue-900" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <!-- Approve Button -->
                                <form action="{{ route('admin.clinics.approve-request', $request->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Approve this clinic? A user account will be created with default password: password123')" 
                                            class="text-green-600 hover:text-green-900" title="Approve">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                                
                                <!-- Reject Button -->
                                <button onclick="openRejectModal({{ $request->id }})" 
                                        class="text-red-600 hover:text-red-900" title="Reject">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>

                            <!-- Hidden details div -->
                            <div id="details-{{ $request->id }}" class="hidden mt-4 p-4 bg-gray-50 rounded-lg">
                                @if($request->description)
                                <div class="mb-3">
                                    <strong class="text-gray-700">Description:</strong>
                                    <p class="text-sm text-gray-600 mt-1">{{ $request->description }}</p>
                                </div>
                                @endif
                                <div class="text-xs text-gray-500">
                                    <strong>Full Address:</strong> {{ $request->business_address }}, {{ $request->city }}, {{ $request->state }} {{ $request->zip_code }}, {{ $request->country }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Existing Clinics -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Active Clinics</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">License</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clinics as $clinic)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $clinic->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $clinic->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $clinic->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $clinic->license_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $clinic->orders_count }} orders</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 text-xs font-semibold rounded-full {{ $clinic->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $clinic->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.clinics.edit', $clinic) }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.clinics.destroy', $clinic) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this clinic?')" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No clinics found. <a href="{{ route('admin.clinics.create') }}" class="text-blue-600">Add your first clinic</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $clinics->links() }}</div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Partnership Request</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection *</label>
                    <textarea name="admin_notes" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="Explain why this request is being rejected..."></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                        Reject Request
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRequestDetails(id) {
    const detailsDiv = document.getElementById('details-' + id);
    detailsDiv.classList.toggle('hidden');
}

function openRejectModal(requestId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = '{{ route("admin.clinics.reject-request", ":id") }}'.replace(':id', requestId);
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}
</script>
@endsection