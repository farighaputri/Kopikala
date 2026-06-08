@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="page-header"
     style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
     ">

<div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Stock --}}
    <a href="{{ route('stock.index') }}" style="text-decoration: none; color: inherit;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Stock 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Categories
            </span>
        </h2>
    </a>
</div>

    <a href="{{ route('categories.create') }}"
       class="add-btn"
       style="
            padding:10px 20px;
            background:#333;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
       ">
        + Add New Category
    </a>

</div>

{{-- TABLE --}}
<div class="card"
     style="
        display:flex;
        justify-content:center;
        align-items:center;
        padding:20px;
     ">

    <table class="table"
           style="
                width:100%;
                border-collapse:collapse;
                text-align:center;
           ">

        <thead>
            <tr>
                <th style="text-align:center; padding:15px;">No</th>
                <th style="text-align:center; padding:15px;">Category Name</th>
                <th style="text-align:center; padding:15px;">Items</th>
                <th style="text-align:center; padding:15px;">Status</th>
                <th style="text-align:center; padding:15px;">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($categories as $i => $cat)

            <tr>

                <td style="text-align:center; padding:15px;">
                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                </td>

                <td style="text-align:center; padding:15px;">
                    {{ $cat->name }}
                </td>

                <td style="text-align:center; padding:15px;">
                    {{ $cat->stocks_count }}
                </td>

                <td style="text-align:center; padding:15px;">

                    <span style="
                        padding:4px 10px;
                        border-radius:5px;
                        font-size:12px;
                        background:{{ $cat->status ? '#E0F2F1' : '#FFEBEE' }};
                        color:{{ $cat->status ? '#00796B' : '#C62828' }};
                    ">
                        {{ $cat->status ? 'Active' : 'Inactive' }}
                    </span>

                </td>

                <td style="text-align:center; padding:15px;">

                    <div class="action-icons"
                         style="
                            display:flex;
                            justify-content:center;
                            align-items:center;
                            gap:15px;
                         ">

                        {{-- EDIT --}}
                        <a href="{{ route('categories.edit', $cat->id) }}"
                           title="Edit">

                            <img src="{{ asset('images/icons/edit.png') }}"
                                 alt="Edit"
                                 style="width:20px;">

                        </a>

                        {{-- DELETE --}}
                        <form id="deleteCategoryForm{{ $cat->id }}"
                              method="POST"
                              action="{{ route('categories.destroy', $cat->id) }}"
                              style="display:none;">

                            @csrf
                            @method('DELETE')

                        </form>

                        <button type="button"
                                onclick="showDeletePopup('deleteCategoryForm{{ $cat->id }}')"
                                style="
                                    background:none;
                                    border:none;
                                    cursor:pointer;
                                    padding:0;
                                ">

                            <img src="{{ asset('images/icons/delete.png') }}"
                                 alt="Delete"
                                 title="Delete"
                                 style="width:20px;">

                        </button>

                    </div>

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="5"
                    style="
                        text-align:center;
                        color:#999;
                        padding:20px;
                    ">
                    No categories found
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

<script>
    function showDeletePopup(formId) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            document.getElementById(formId).submit();
        }
    }
</script>

@endsection