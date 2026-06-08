@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/transaction-detail.css') }}">

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Staff --}}
    <a href="{{ route('transactions.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Transaksi
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Detail Transaksi
            </span>
        </h2>
    </a>
</div>

    {{-- MAIN WRAPPER --}}
    <div class="transaction-detail-wrapper" style="display:flex; gap:20px; flex-wrap:wrap;">

        {{-- LEFT SIDE --}}
        <div class="detail-card" style="flex:1; min-width:300px; padding:20px; border-radius:8px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

            <h4>Order Details</h4>

            <div class="form-group mb-2">
                <label>Order ID</label>
                <input class="form-control" disabled value="{{ $transaction->order_id }}">
            </div>

            <div class="form-group mb-2">
                <label>Time</label>
                <input class="form-control" disabled value="{{ $transaction->created_at->format('d/m/Y H:i') }}">
            </div>

            <div class="form-group mb-2">
                <label>Customer Name</label>
                <input class="form-control" disabled value="{{ $transaction->customer_name }}">
            </div>

            <div class="form-group mb-2">
                <label>Status</label><br>
                <span class="status-badge
                    @if($transaction->status == 'Waiting Confirmation') status-waiting
                    @elseif($transaction->status == 'Order Confirmed') status-confirmed
                    @elseif($transaction->status == 'Order Ready') status-ready
                    @elseif($transaction->status == 'Order Finished') status-finished
                    @endif"
                    style="padding:4px 8px; border-radius:4px; font-size:0.85rem; font-weight:500; display:inline-block;">
                    {{ $transaction->status }}
                </span>
            </div>

            <div class="form-group mb-2">
                <label>Location</label><br>
                <span class="location-badge">
                    {{ $transaction->branch
                        ? $transaction->branch->branch_name.' - '.$transaction->branch->location
                        : ($transaction->location ?? '-') }}
                </span>
            </div>

            <div class="form-group mb-2">
                <label>Total</label>
                <input class="form-control" disabled value="Rp {{ number_format($transaction->total) }}">
            </div>

            <hr style="margin:20px 0">

            <h4>Customer Details</h4>

            <div class="form-group mb-2">
                <label>Customer Name</label>
                <input class="form-control" disabled value="{{ $transaction->customer_name }}">
            </div>

            <div class="form-group mb-2">
                <label>Customer Email</label>
                <input class="form-control" disabled value="{{ $transaction->email }}">
            </div>

            <div class="form-group mb-2">
                <label>Customer Number</label>
                <input class="form-control" disabled value="{{ $transaction->phone }}">
            </div>

            {{-- ACTION: Ubah status --}}
            <form action="{{ route('transactions.updateStatus', $transaction->order_id) }}" method="POST" class="mt-2">
                @csrf
                <div class="form-group mb-2">
                    <label for="status">Update Status</label>
                    <select name="status" id="status" class="form-control form-control-sm">
                        <option value="Waiting Confirmation" {{ $transaction->status == 'Waiting Confirmation' ? 'selected' : '' }}>Waiting Confirmation</option>
                        <option value="Order Confirmed" {{ $transaction->status == 'Order Confirmed' ? 'selected' : '' }}>Order Confirmed</option>
                        <option value="Order Ready" {{ $transaction->status == 'Order Ready' ? 'selected' : '' }}>Order Ready</option>
                        <option value="Order Finished" {{ $transaction->status == 'Order Finished' ? 'selected' : '' }}>Order Finished</option>
                    </select>
                </div>

                <div class="d-flex justify-content-start mt-1">
                    <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="history.back()">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                </div>
            </form>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="detail-card" style="flex:1; min-width:300px; padding:20px; border-radius:8px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

            <h4>Order Item Details</h4>

            {{-- Foto customer kecil-kecil --}}
            @if($transaction->customerPhotos->count() > 0)
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($transaction->customerPhotos as $photo)
                        <img src="{{ asset('storage/'.$photo->photo_path) }}" 
                             alt="Customer Photo" 
                             style="width:50px; height:50px; border-radius:6px; object-fit:cover; border:1px solid #ddd;">
                    @endforeach
                </div>
            @endif

            {{-- List items --}}
            @foreach($items as $item)
                <div class="order-item d-flex align-items-center mb-3" style="border-bottom:1px solid #eee; padding-bottom:10px;">

                    {{-- Info produk --}}
                    <div class="order-item-info flex-grow-1">
                        <h5 style="margin:0;">{{ $item['name'] ?? '-' }}</h5>
                        <span style="font-size:0.85rem; color:#555;">

@php
    $customText = [];

    if(isset($item['options'])){
        foreach($item['options'] as $option){
            $customText[] = $option['customization'].' : '.$option['option'];
        }
    }
@endphp

{{ count($customText) ? implode(', ', $customText) : 'Kopi Normal' }}

| Quantity: {{ $item['qty'] ?? 1 }}

</span>
                    </div>

                    {{-- Harga produk --}}
                    <div class="order-item-price" style="font-weight:600;">
                        Rp {{ number_format($item['price'] ?? 0) }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
