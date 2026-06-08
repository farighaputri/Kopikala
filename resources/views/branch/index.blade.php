@extends('layouts.app')

@section('content')

<div class="page-header">
    <h2 class="page-title">Kopikala Branch</h2>

    <a href="{{ route('branch.create') }}" class="add-btn">
        + Add New Branch
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Branch Name</th>
                    <th>Location</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($branches as $branch)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $branch->branch_name }}</td>
                    <td>{{ $branch->location }}</td>
                  <td class="action">
                    <div class="action-icons">
                        <!-- Show / Detail Icon -->
                        <a href="{{ route('branch.show', $branch->id) }}">
                            <img src="{{ asset('images/icons/detail.png') }}" alt="Show" class="icon-btn" title="Detail">
                        </a>

                        <!-- Edit Icon -->
                        <a href="{{ route('branch.edit', $branch->id) }}">
                            <img src="{{ asset('images/icons/edit.png') }}" alt="Edit" class="icon-btn" title="Edit">
                        </a>

                        <!-- Delete Icon -->
                        <form id="deleteBranchForm{{ $branch->id }}" method="POST" action="{{ route('branch.destroy', $branch->id) }}" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" class="icon-btn-btn" onclick="showDeletePopup('deleteBranchForm{{ $branch->id }}')">
                        <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="icon-btn" title="Delete">
                    </button>
                    </div>
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Belum ada data branch
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
