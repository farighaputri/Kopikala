@extends('layouts.app')

@section('content')

<div class="stock-header">
    <div style="margin-bottom: 25px;">
        {{-- Navigasi Kembali ke halaman Djuanda Stock --}}
        <a href="{{ route('djuanda.stock') }}" style="text-decoration: none; color: inherit; display: inline-block;">
            <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
                Djuanda Stock
                <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                    › Add New Stock
                </span>
            </h2>
        </a>
    </div>
</div>

<form action="{{ route('djuanda.stock.store') }}" method="POST" enctype="multipart/form-data" class="stock-form">
@csrf
<div class="stock-form-card">

    {{-- ITEM DETAILS --}}
    <h4 class="form-section">Item Details</h4>

    <div class="form-group">
        <label>Item Name <span>*</span></label>
        <input type="text" name="item_name" placeholder="Enter Item Name" value="{{ old('item_name') }}" required>
    </div>

    <div class="form-group">
        <label>Item Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label>Category <span>*</span></label>
        <select name="category_id" required>
            <option value="">Choose Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- PRICE DETAILS --}}
    <h4 class="form-section">Item Price Details</h4>

    <div class="form-group">
        <label>Quantity Purchased <span>*</span></label>
        <input type="number" name="qty_purchased" id="qty_purchased" placeholder="Enter Quantity Purchased" min="0" value="{{ old('qty_purchased') }}" required>
    </div>

    <div class="form-group">
        <label>Unit Price <span>*</span></label>
        <input type="number" name="unit_price" id="unit_price" placeholder="Rp 000000" min="0" value="{{ old('unit_price') }}" required>
    </div>

    <div class="form-group">
        <label>Total Price</label>
        <input type="number" id="total_price" placeholder="Rp 000000" readonly>
    </div>

    {{-- STOCK DETAILS --}}
    <h4 class="form-section">Item Stock Details</h4>

    <div class="form-group">
        <label>In Stock <span>*</span></label>
        <input type="number" name="in_stock" placeholder="Enter In Stock" min="0" value="{{ old('in_stock') }}" required>
    </div>

    {{-- BRANCH (PASTI LOCK DJUANDA) --}}
    <h4 class="form-section">Branch Location</h4>
    <div class="form-group">
        <label>Assigned Branch</label>
        <input type="text" 
               value="Djuanda" 
               readonly 
               style="background-color: #f5f5f5; color: #666; cursor: not-allowed; font-weight: bold; border: 1px solid #eee;">
    </div>

    <div class="form-action">
        <a href="{{ route('djuanda.stock') }}" class="btn-cancel">Cancel</a>
        <button type="submit" class="btn-submit" style="background: #4A3525; color: #fff;">Add New Item</button>
    </div>

</div>
</form>

<script>
const qtyInput = document.getElementById('qty_purchased');
const priceInput = document.getElementById('unit_price');
const totalInput = document.getElementById('total_price');

function updateTotal() {
    const qty = parseFloat(qtyInput.value) || 0;
    const price = parseFloat(priceInput.value) || 0;
    totalInput.value = qty * price;
}

qtyInput.addEventListener('input', updateTotal);
priceInput.addEventListener('input', updateTotal);
updateTotal();
</script>

@endsection