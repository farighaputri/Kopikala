@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="page-header">
    <h2 class="page-title">Products</h2>
    <a href="{{ route('products.create') }}" class="add-btn">+ Add New Product</a>
</div>

{{-- FILTER BAR --}}
<div class="filter-wrapper">
    <div class="filter-pill dropdown" onclick="toggleFilterMenu()">
        <span class="filter-icon">⚲</span>
        <span id="filterLabel">Filter</span>
        <span class="arrow">▾</span>
    </div>

    <a href="{{ route('products.index') }}" class="filter-reset">
        ⟳ Reset Filter
    </a>
</div>

{{-- FILTER MENU --}}
<div id="filterMenu" class="filter-menu">
    <div onclick="selectFilter('price','Price')">Price</div>
    <div onclick="selectFilter('status','Status')">Status</div>
    <div onclick="selectFilter('name','Product Name')">Product Name</div>
</div>

<form method="GET" action="{{ route('products.index') }}">
    <div id="filterPanel" class="filter-panel">

        {{-- PRICE --}}
        <div class="filter-box filter-field" data-filter="price">
            <label>Price</label>
            <select name="price">
                <option value="">All Price</option>
                <option value="0-10000">0 - 10.000</option>
                <option value="10000-50000">10.000 - 50.000</option>
                <option value="50000+">> 50.000</option>
            </select>
        </div>

        {{-- STATUS --}}
        <div class="filter-box filter-field" data-filter="status">
            <label>Status</label>
            <select name="status">
                <option value="">All Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        {{-- NAME --}}
        <div class="filter-box filter-field" data-filter="name">
            <label>Product Name</label>
            <input type="text" name="name" placeholder="Search name...">
        </div>

        <button type="submit" class="add-btn">
            Apply Filter
        </button>
    </div>
</form>
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

                <th style="padding:15px; text-align:center;">No</th>

                <th style="padding:15px; text-align:center;">Products Name</th>

                <th style="padding:15px; text-align:center;">Image</th>

                <th style="padding:15px; text-align:center;">Price</th>

                <th style="padding:15px; text-align:center;">Status</th>

                <th style="padding:15px; text-align:center;">Action</th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $i => $product)

            <tr>

                <td style="padding:15px; text-align:center;">
                    {{ $i + 1 }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $product->name }}
                </td>

                <td style="padding:15px; text-align:center;">

                    @if($product->image)

                        <img src="{{ asset('storage/'.$product->image) }}"
                             width="40"
                             style="border-radius:6px;">

                    @else

                        -

                    @endif

                </td>

                <td style="padding:15px; text-align:center;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </td>

                <td style="padding:15px; text-align:center;">

                    <span class="badge {{ $product->status == 1 ? 'success' : 'danger' }}">
                        {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                    </span>

                </td>

                <td style="padding:15px; text-align:center;">

                    <div class="action-icons"
                         style="
                            display:flex;
                            justify-content:center;
                            align-items:center;
                            gap:15px;
                         ">

                        {{-- DELETE FORM --}}
                        <form id="deleteProductForm{{ $product->id }}"
                              method="POST"
                              action="{{ route('products.destroy', $product->id) }}"
                              style="display:none;">

                            @csrf
                            @method('DELETE')

                        </form>

                        {{-- DELETE BUTTON --}}
                        <button type="button"
                                class="icon-btn-btn"
                                onclick="showDeletePopup('deleteProductForm{{ $product->id }}')"
                                style="
                                    background:none;
                                    border:none;
                                    cursor:pointer;
                                    padding:0;
                                ">

                            <img src="{{ asset('images/icons/delete.png') }}"
                                 alt="Delete"
                                 class="icon-btn"
                                 title="Delete"
                                 style="width:20px;">

                        </button>

                        {{-- EDIT --}}
                        <a href="{{ route('products.edit',$product->id) }}">

                            <img src="{{ asset('images/icons/edit.png') }}"
                                 alt="Edit"
                                 class="icon-btn"
                                 title="Edit"
                                 style="width:20px;">

                        </a>

                        {{-- DETAIL --}}
                        <a href="{{ route('products.show',$product->id) }}">

                            <img src="{{ asset('images/icons/detail.png') }}"
                                 alt="Show"
                                 class="icon-btn"
                                 title="Detail"
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

{{-- SCRIPT --}}
<script>
function toggleFilterMenu() {
    const menu = document.getElementById('filterMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

function selectFilter(type) {
    document.getElementById('filterLabel').innerText =
        type === 'price' ? 'Price' :
        type === 'status' ? 'Status' : 'Product Name';

    document.getElementById('filterPanel').classList.add('active');

    document.querySelectorAll('.filter-field').forEach(el => {
        el.style.display = 'none';
    });

    document.querySelector(`[data-filter="${type}"]`).style.display = 'block';

    document.getElementById('filterMenu').style.display = 'none';
}
</script>

@endsection