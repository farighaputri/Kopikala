@extends('layouts.app')

@section('content')

<div class="stock-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Staff --}}
    <a href="{{ route('stock.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Stock
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Edit Item
            </span>
        </h2>
    </a>
</div>
</div>

<form action="{{ route('stock.update', $stock->id) }}"
      method="POST"
      enctype="multipart/form-data"
      class="stock-form">

@csrf
@method('PUT')

<div class="stock-form-card">

    {{-- ITEM DETAILS --}}
    <h4 class="form-section">Item Details</h4>

    <div class="form-group">
        <label>Item Name <span>*</span></label>
        <input type="text" name="item_name"
               value="{{ old('item_name', $stock->item_name) }}"
               required>
    </div>

    <div class="form-group">
        <label>Item Image</label>
        <input type="file" name="image">

        @if($stock->image)
            <div style="margin-top:8px">
                <img src="{{ asset('storage/'.$stock->image) }}" width="120">
            </div>
        @endif
    </div>

    <div class="form-group">
        <label>Category <span>*</span></label>
        <select name="category_id" required>
            <option value="">Choose Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    @selected(old('category_id', $stock->category_id) == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- PRICE --}}
    <h4 class="form-section">Item Price Details</h4>

    <div class="form-group">
        <label>Quantity Purchased <span>*</span></label>
        <input type="number" name="qty_purchased" id="qty_purchased"
               value="{{ old('qty_purchased', $stock->qty_purchased) }}" required>
    </div>

    <div class="form-group">
        <label>Unit Price <span>*</span></label>
        <input type="number" name="unit_price" id="unit_price"
               value="{{ old('unit_price', $stock->unit_price) }}" required>
    </div>

    <div class="form-group">
        <label>Total Price</label>
        <input type="number" id="total_price" readonly>
    </div>

    {{-- STOCK --}}
    <h4 class="form-section">Item Stock Details</h4>

    <div class="form-group">
        <label>In Stock <span>*</span></label>
        <input type="number" name="in_stock"
               value="{{ old('in_stock', $stock->in_stock) }}" required>
    </div>

    <div class="form-group">
        <label>Status <span>*</span></label>
        <select name="status" required>
            <option value="IN STOCK" @selected($stock->status == 'IN STOCK')>IN STOCK</option>
            <option value="LOW STOCK" @selected($stock->status == 'LOW STOCK')>LOW STOCK</option>
            <option value="OUT OF STOCK" @selected($stock->status == 'OUT OF STOCK')>OUT OF STOCK</option>
        </select>
    </div>

    {{-- BRANCH --}}
    <h4 class="form-section">Assign Branch</h4>

    <div class="form-group">
        <select name="branch_id" required>
            <option value="">Choose Branch</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}"
                    @selected($stock->branch_id == $branch->id)>
                    {{ $branch->branch_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- ✅ ACTION BUTTON (INI YANG KAMU HILANGIN SEBELUMNYA) --}}
    <div style="margin-top:20px; display:flex; gap:10px;">
        <a href="{{ route('stock.index') }}"
           style="padding:10px 15px; background:#6c757d; color:white; text-decoration:none;">
            Cancel
        </a>

        <button type="submit"
                style="padding:10px 15px; background:#28a745; color:white; border:none;">
            Update
        </button>
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