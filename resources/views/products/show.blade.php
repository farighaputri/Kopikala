@extends('layouts.app')

@section('content')

<div class="page-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Products --}}
    <a href="{{ route('products.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Products 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Detail Product
            </span>
        </h2>
    </a>
</div>
</div>

<div class="card">

    <div class="product-form-wrapper">

        {{-- ================= LEFT ================= --}}
        <div class="product-form-left">

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" value="{{ $product->name }}" readonly>
            </div>

            <div class="form-group">
                <label>Status</label>
                <input type="text" 
                       value="{{ $product->status == 1 ? 'Active' : 'Inactive' }}" 
                       readonly
                       style="color:{{ $product->status == 1 ? '#3490dc' : '#e3342f' }}">
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="text" value="Rp {{ number_format($product->price,0,',','.') }}" readonly>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea readonly>{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Image</label>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" style="width:120px; border-radius:8px;">
                @else
                    <p style="color:#999">No Image</p>
                @endif
            </div>

        </div>

        {{-- ================= RIGHT ================= --}}
        <div class="product-form-right">

            <div class="customize-header">
                <h4>Customize Menu</h4>
            </div>

            <div id="customize-wrapper">

                @foreach($product->customizes ?? [] as $i => $customize)
                <div class="customize-card">
                    <h5>Customize Menu {{ $i + 1 }}</h5>

                    <div class="form-group">
                        <label>Customization Name</label>
                        <input type="text" value="{{ $customize->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Customization Types</label>
                        <ul>
                            @foreach($customize->types as $type)
                                <li>{{ $type }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

    </div>

</div>

{{-- BACK BUTTON --}}
<div style="margin-top:15px;">
    <a href="{{ route('products.index') }}" class="btn-cancel">← Back</a>
</div>

@endsection
