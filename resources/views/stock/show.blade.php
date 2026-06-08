@extends('layouts.app')

@section('title', 'Stock Detail')

@section('content')

<div class="stock-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Staff --}}
    <a href="{{ route('stock.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Stock
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Item Detail
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
            <input type="text" value="{{ $stock->stock_id }}" readonly>
        </div>

        <div class="form-group">
            <label>Item Name</label>
            <input type="text" value="{{ $stock->item_name }}" readonly>
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" value="{{ $stock->categoryRelation->name ?? '-' }}" readonly>
        </div>

        <div class="form-group">
            <label>Branch</label>
            <input type="text" value="{{ $stock->branch->branch_name ?? '-' }}" readonly>
        </div>

        @if($stock->image)
        <div class="form-group">
            <label>Item Image</label><br>
            <img src="{{ asset('storage/'.$stock->image) }}" style="width:140px;border-radius:10px;">
        </div>
        @endif

        {{-- PRICE DETAILS --}}
        <h4 class="form-section">Price Details</h4>

        <div class="form-group">
            <label>Qty Purchased</label>
            <input type="text" value="{{ $stock->qty_purchased }}" readonly>
        </div>

        <div class="form-group">
            <label>Unit Price</label>
            <input type="text" value="Rp {{ number_format($stock->unit_price,0,',','.') }}" readonly>
        </div>

        <div class="form-group">
            <label>Total Price</label>
            <input type="text" value="Rp {{ number_format($stock->total_price,0,',','.') }}" readonly>
        </div>

        {{-- STOCK DETAILS --}}
        <h4 class="form-section">Stock Details</h4>

        <div class="form-group">
            <label>In Stock</label>
            <input type="text" value="{{ $stock->in_stock }}" readonly>
        </div>

        <div class="form-group">
            <label>Status</label>
            <input type="text" value="{{ $stock->status }}" readonly>
        </div>

        {{-- ACTION BUTTON --}}
        <div class="form-action">

            <a href="{{ route('stock.index') }}" class="btn-cancel">Back</a>
        </div>

    </div>
</div>

@endsection
