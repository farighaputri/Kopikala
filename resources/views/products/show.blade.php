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

<div class="card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">

    <div class="product-form-wrapper" style="display: flex; gap: 30px; flex-wrap: wrap;">

        {{-- ================= LEFT (DATA PRODUK UTAMA) ================= --}}
        <div class="product-form-left" style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 15px;">

            <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: 600; color: #555;">Product Name</label>
                <input type="text" value="{{ $product->name }}" readonly style="padding: 10px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9; color: #333;">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: 600; color: #555;">Status</label>
                <input type="text" 
                       value="{{ $product->status == 1 ? 'Active' : 'Inactive' }}" 
                       readonly
                       style="padding: 10px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9; font-weight: bold; color: {{ $product->status == 1 ? '#28a745' : '#dc3545' }};">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: 600; color: #555;">Price</label>
                <input type="text" value="Rp {{ number_format($product->price, 0, ',', '.') }}" readonly style="padding: 10px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9; color: #333;">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: 600; color: #555;">Description</label>
                <textarea readonly style="padding: 10px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9; color: #333; min-height: 100px; resize: none;">{{ $product->description ?? 'No description available.' }}</textarea>
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: 600; color: #555;">Image</label>
                @if($product->image)
                    <div style="margin-top: 5px;">
                        <img src="{{ asset('storage/'.$product->image) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    </div>
                @else
                    <p style="color: #999; margin: 5px 0; font-style: italic;">No Image Available</p>
                @endif
            </div>

        </div>

        {{-- ================= RIGHT (CUSTOMIZE MENU) ================= --}}
        <div class="product-form-right" style="flex: 1; min-width: 300px; background: #fdfbf9; padding: 20px; border-radius: 8px; border: 1px solid #f0e6df;">

            <div class="customize-header" style="margin-bottom: 20px; border-bottom: 1px solid #eddcd2; padding-bottom: 10px;">
                <h4 style="margin: 0; color: #4A3525; font-size: 18px; font-weight: 700;">Customize Menu</h4>
            </div>

            <div id="customize-wrapper" style="display: flex; flex-direction: column; gap: 15px;">

                {{-- Membaca relasi asli dari Controller: customizations --}}
                @forelse($product->customizations ?? [] as $i => $customize)
                    <div class="customize-card" style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #eddcd2;">
                        <h5 style="margin: 0 0 12px 0; color: #6c584c; font-size: 14px; font-weight: 700; background: #eddcd2; display: inline-block; padding: 3px 8px; border-radius: 4px;">
                            Option #{{ $i + 1 }}
                        </h5>

                        <div class="form-group" style="display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px;">
                            <label style="font-size: 13px; font-weight: 600; color: #777;">Customization Name</label>
                            <input type="text" value="{{ $customize->name }}" readonly style="padding: 8px; border: 1px solid #eee; border-radius: 4px; background: #fdfdfd; color: #333;">
                        </div>

                        <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                            <label style="font-size: 13px; font-weight: 600; color: #777;">Available Variants / Types</label>
                            
                            {{-- Membaca sub-relasi asli dari database: options --}}
                            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 5px;">
                                @forelse($customize->options ?? [] as $type)
                                    <span style="background: #8C7A6B; color: #fff; padding: 5px 10px; border-radius: 4px; font-size: 13px; font-weight: 500;">
                                        {{ $type->name }}
                                    </span>
                                @empty
                                    <span style="color: #999; font-style: italic; font-size: 13px;">No variants added</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #999; padding: 20px; font-style: italic; background: #fff; border-radius: 6px; border: 1px dashed #ccc;">
                        No customization menu for this product.
                    </div>
                @endforelse

            </div>

        </div>

    </div>

</div>

{{-- BACK BUTTON --}}
<div style="margin-top: 20px; display: flex; justify-content: flex-start;">
    <a href="{{ route('products.index') }}" class="btn-cancel" style="padding: 10px 20px; background: #4A3525; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background 0.2s;">
        Back 
    </a>
</div>

@endsection