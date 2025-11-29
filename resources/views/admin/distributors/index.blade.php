@extends('layouts.app')

@section('title', 'Manage Distributors')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="section-title text-4xl mb-2">Manage Distributors</h1>
            <p class="text-lg text-gray-600">Review partnership requests and manage existing distributors</p>
        </div>
        <a href="{{ route('admin.distributors.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Add Distributor Manually
        </a>
    </div>

    <!-- Pending Partner Requests -->
    @if($pendingRequests->count() > 0)
    <div class="card mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-yellow-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Pending Partnership Requests</h2>
                        <p class="text-sm text-gray-600">{{ $pendingRequests->count() }} distributor(s) waiting for approval</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Business Info</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Business Details</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pendingRequests as $request)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $request->business_name }}</div>
                            <div class="text-sm text-gray-500">{{ $request->name }}</div>
                            @if($request->license_number)
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-id-card mr-1"></i>Registration: {{ $request->license_number }}
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
                            <div class="flex items-center space-x-3">
                                <button onclick="showRequestDetails({{ $request->id }})" 
                                        class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded transition" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <form action="{{ route('admin.distributors.approve-request', $request->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Approve this distributor? A user account will be created with default password: password123')" 
                                            class="text-green-600 hover:text-green-800 hover:bg-green-50 p-2 rounded transition" title="Approve">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                                
                                <button onclick="openRejectModal({{ $request->id }})" 
                                        class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded transition" title="Reject">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>

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

    <!-- Existing Distributors -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Active Distributors</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Business Reg</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($distributors as $distributor)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $distributor->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $distributor->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $distributor->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $distributor->business_registration ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $distributor->products_count }} products
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $distributor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $distributor->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.distributors.edit', $distributor) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-3 py-1 rounded transition mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.distributors.destroy', $distributor) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this distributor?')" class="text-red-600 hover:text-red-800 hover:bg-red-50 px-3 py-1 rounded transition">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-truck text-4xl text-gray-300 mb-2"></i>
                            <p>No distributors found. <a href="{{ route('admin.distributors.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Add your first distributor</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $distributors->links() }}
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">Reject Partnership Request</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection *</label>
                    <textarea name="admin_notes" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="Explain why this request is being rejected..."></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        Reject Request
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition">
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
    form.action = '{{ route("admin.distributors.reject-request", ":id") }}'.replace(':id', requestId);
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}
</script>
@endsection