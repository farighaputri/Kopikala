@extends('layouts.app')

@section('content')

<div class="page-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Products --}}
    <a href="{{ route('products.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Products 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Edit Product
            </span>
        </h2>
    </a>
</div>
</div>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">

        <div class="product-form-wrapper">

            {{-- ================= LEFT ================= --}}
            <div class="product-form-left">

                <div class="form-group">
                    <label>Product Name <span>*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter Product Name" required>
                </div>

                <div class="form-group">
                    <label>Status <span>*</span></label>
                    <select name="status" required>
                        <option value="">Choose Status</option>
                        <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Price <span>*</span></label>
                    <input type="number" name="price" min="0" value="{{ old('price', $product->price) }}" placeholder="Rp 000000" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Enter Description">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image">
                    @if($product->image)
                        <div style="margin-top:10px">
                            <img src="{{ asset('storage/'.$product->image) }}" style="width:80px; border-radius:8px">
                        </div>
                    @endif
                </div>

            </div>

            {{-- ================= RIGHT ================= --}}
            <div class="product-form-right">

                <div class="customize-header">
                    <h4>Customize Menu</h4>
                    <button type="button" onclick="addCustomize()" class="add-btn">
                        + Add Customization
                    </button>
                </div>

                <div id="customize-wrapper">

                    @foreach($product->customizes ?? [] as $i => $customize)
                        <div class="customize-card">
                            <h5>Customize Menu</h5>

                            <div class="form-group">
                                <label>Customization Name</label>
                                <input type="text" name="customize[{{ $i }}][name]" value="{{ $customize->name }}">
                            </div>

                            <div class="customize-inline">
                                <label>Customization Type</label>
                                <button type="button" onclick="addCustomizationType({{ $i }})">
                                    + Add Customization Type
                                </button>
                            </div>

                            <div id="customize-types-{{ $i }}">
                                @foreach($customize->types as $type)
                                    <input type="text" name="customize[{{ $i }}][types][]" value="{{ $type }}">
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- ACTION BUTTON --}}
    <div class="product-form-actions">
        <a href="{{ route('products.index') }}" class="btn-cancel">Cancel</a>
        <button type="submit" class="btn-submit">Update Product</button>
    </div>

</form>

{{-- ================= JS ================= --}}
<script>
let customizeIndex = {{ count($product->customizes ?? []) }};

/* ADD CUSTOMIZE MENU */
function addCustomize() {
    const wrapper = document.getElementById('customize-wrapper');

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="customize-card">
            <h5>Customize Menu</h5>

            <div class="form-group">
                <label>Customization Name</label>
                <input type="text" name="customize[${customizeIndex}][name]" placeholder="New Customize">
            </div>

            <div class="customize-inline">
                <label>Customization Type</label>
                <button type="button" onclick="addCustomizationType(${customizeIndex})">
                    + Add Customization Type
                </button>
            </div>

            <div id="customize-types-${customizeIndex}">
                <input type="text" name="customize[${customizeIndex}][types][]" placeholder="Normal">
            </div>
        </div>
    `);

    customizeIndex++;
}

/* ADD CUSTOMIZATION TYPE */
function addCustomizationType(index) {
    const wrapper = document.getElementById('customize-types-' + index);

    wrapper.insertAdjacentHTML('beforeend', `
        <input type="text" name="customize[${index}][types][]" placeholder="New Type">
    `);
}
</script>

@endsection
