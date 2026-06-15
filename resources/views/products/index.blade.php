@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="page-header">
    <h2 class="page-title">Products</h2>
    <a href="{{ route('products.create') }}" class="add-btn">
        + Add New Product
    </a>
</div>

{{-- FILTER --}}
<div class="filter-card">

    <form method="GET" action="{{ route('products.index') }}" class="filter-grid">

        <div class="filter-group">
            <label>Product Name</label>
            <input type="text"
                   name="name"
                   placeholder="Search product..."
                   value="{{ request('name') }}">
        </div>

        <div class="filter-group">
            <label>Price Range</label>
            <select name="price">
                <option value="">All Price</option>

                <option value="0-10000"
                    {{ request('price') == '0-10000' ? 'selected' : '' }}>
                    0 - 10.000
                </option>

                <option value="10000-50000"
                    {{ request('price') == '10000-50000' ? 'selected' : '' }}>
                    10.000 - 50.000
                </option>

                <option value="50000+"
                    {{ request('price') == '50000+' ? 'selected' : '' }}>
                    > 50.000
                </option>
            </select>
        </div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status">
                <option value="">All Status</option>

                <option value="1"
                    {{ request('status') == '1' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ request('status') == '0' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>

        <div class="filter-action">

            <button type="submit" class="add-btn filter-submit">
                Filter
            </button>

            <a href="{{ route('products.index') }}" class="add-btn">
                Reset
            </a>

        </div>

    </form>

</div>

{{-- TABLE --}}
<div class="card"
     style="
        display:flex;
        justify-content:center;
        padding:20px;
        overflow-x:auto;
     ">

    <table class="table"
           style="
                width:100%;
                border-collapse:collapse;
                text-align:center;
           ">

        <thead>
            <tr>
                <th style="padding:15px;">No</th>
                <th style="padding:15px;">Product Name</th>
                <th style="padding:15px;">Image</th>
                <th style="padding:15px;">Price</th>
                <th style="padding:15px;">Status</th>
                <th style="padding:15px;">Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($products as $i => $product)

            <tr>

                <td style="padding:15px;">
                    {{ $i + 1 }}
                </td>

                <td style="padding:15px;">
                    {{ $product->name }}
                </td>

                <td style="padding:15px;">

                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             width="40"
                             alt="{{ $product->name }}"
                             style="border-radius:6px;">
                    @else
                        -
                    @endif

                </td>

                <td style="padding:15px;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </td>

                <td style="padding:15px;">

                    <span class="badge {{ $product->status == 1 ? 'success' : 'danger' }}">
                        {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                    </span>

                </td>

                <td style="padding:15px;">

                    <div class="action-icons"
                         style="
                            display:flex;
                            justify-content:center;
                            align-items:center;
                            gap:15px;
                         ">

                        {{-- DELETE FORM --}}
                        <form id="deleteProductForm{{ $product->id }}"
                              action="{{ route('products.destroy', $product->id) }}"
                              method="POST"
                              style="display:none;">

                            @csrf
                            @method('DELETE')

                        </form>

                        {{-- DELETE --}}
                        <button type="button"
                                onclick="showDeletePopup('deleteProductForm{{ $product->id }}')"
                                style="
                                    background:none;
                                    border:none;
                                    cursor:pointer;
                                    padding:0;
                                ">

                            <img src="{{ asset('images/icons/delete.png') }}"
                                 alt="Delete"
                                 title="Delete"
                                 class="icon-btn"
                                 style="width:20px;">

                        </button>

                        {{-- EDIT --}}
                        <a href="{{ route('products.edit', $product->id) }}">
                            <img src="{{ asset('images/icons/edit.png') }}"
                                 alt="Edit"
                                 title="Edit"
                                 class="icon-btn"
                                 style="width:20px;">
                        </a>

                        {{-- DETAIL --}}
                        <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ asset('images/icons/detail.png') }}"
                                 alt="Detail"
                                 title="Detail"
                                 class="icon-btn"
                                 style="width:20px;">
                        </a>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6"
                    style="
                        text-align:center;
                        color:#999;
                        padding:20px;
                    ">
                    No products found
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<style>
.filter-submit{
    border:none;
    cursor:pointer;
}

.filter-action{
    display:flex;
    gap:10px;
    align-items:center;
}
</style>

@endsection