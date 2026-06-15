@extends('layouts.app')

@section('content')

<div class="stock-header">
    <div style="margin-bottom: 25px;">
        {{-- Navigasi Kembali ke halaman Semeru Stock --}}
        <a href="{{ route('semeru.stock') }}" style="text-decoration: none; color: inherit; display: inline-block;">
            <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
                Semeru Stock
                <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                    › Stock Item Detail
                </span>
            </h2>
        </a>
    </div>
</div>

<div class="stock-form">
<div class="stock-form-card">

    {{-- ITEM DETAILS --}}
    <h4 class="form-section">Item Details</h4>

    <div class="form-group">
        <label>Stock ID</label>
        <input type="text" value="{{ $stock->stock_id }}" readonly style="background-color: #f5f5f5; color: #333; font-weight: bold; border: 1px solid #eee;">
    </div>

    <div class="form-group">
        <label>Item Name</label>
        <input type="text" value="{{ $stock->item_name }}" readonly style="background-color: #f5f5f5; color: #555; border: 1px solid #eee;">
    </div>

    <div class="form-group">
        <label>Category</label>
        <input type="text" value="{{ $stock->categoryRelation->name ?? '-' }}" readonly style="background-color: #f5f5f5; color: #555; border: 1px solid #eee;">
    </div>

    @if($stock->image)
        <div class="form-group">
            <label>Item Image</label>
            <div style="margin-top: 5px;">
                <img src="{{ asset('storage/' . $stock->image) }}" alt="{{ $stock->item_name }}" style="max-width: 150px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: block;">
            </div>
        </div>
    @endif

    {{-- PRICE DETAILS --}}
    <h4 class="form-section">Item Price Details</h4>

    <div class="form-group">
        <label>Quantity Purchased</label>
        <input type="text" value="{{ $stock->qty_purchased }}" readonly style="background-color: #f5f5f5; color: #555; border: 1px solid #eee;">
    </div>

    <div class="form-group">
        <label>Unit Price</label>
        <input type="text" value="Rp {{ number_format($stock->unit_price, 0, ',', '.') }}" readonly style="background-color: #f5f5f5; color: #555; border: 1px solid #eee;">
    </div>

    <div class="form-group">
        <label>Total Price</label>
        <input type="text" value="Rp {{ number_format($stock->total_price, 0, ',', '.') }}" readonly style="background-color: #f5f5f5; color: #4A3525; font-weight: bold; border: 1px solid #eee;">
    </div>

    {{-- STOCK DETAILS --}}
    <h4 class="form-section">Item Stock Details</h4>

    <div class="form-group">
        <label>In Stock</label>
        <input type="text" value="{{ $stock->in_stock }}" readonly style="background-color: #f5f5f5; color: #555; font-weight: bold; border: 1px solid #eee;">
    </div>

    <div class="form-group">
        <label>Status</label>
        <div style="margin-top: 5px; display: inline-block;">
            <span class="badge {{ $stock->status=='IN STOCK' ? 'badge-green' : ($stock->status=='LOW STOCK' ? 'badge-yellow' : 'badge-red') }}">
                {{ $stock->status }}
            </span>
        </div>
    </div>

    {{-- BRANCH LOCATION --}}
    <h4 class="form-section">Branch Location</h4>
    <div class="form-group">
        <label>Assigned Branch</label>
        <input type="text" value="{{ $stock->branch->branch_name ?? 'Semeru Branch' }}" readonly style="background-color: #f5f5f5; color: #666; font-weight: bold; border: 1px solid #eee;">
    </div>

    <div class="form-action" style="margin-top: 30px;">
        <a href="{{ route('semeru.stock') }}" class="btn-cancel" style="background: #4A3525; color: #fff; text-align: center; line-height: normal; display: inline-flex; align-items: center; justify-content: center;">← Back to List</a>
        <a href="{{ route('semeru.stock.edit', $stock->id) }}" class="btn-submit" style="background: #8C7A6B; color: #fff; text-decoration: none; text-align: center; display: inline-flex; align-items: center; justify-content: center;">Edit This Item</a>
    </div>

</div>
</div>

@endsection