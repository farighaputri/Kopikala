@extends('layouts.app')

@section('content')

<div class="page-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Products --}}
    <a href="{{ route('products.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Products 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Add New Product
            </span>
        </h2>
    </a>
</div>
</div>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="card">

    <div class="product-form-wrapper">

        {{-- ================= LEFT ================= --}}
        <div class="product-form-left">

            <div class="form-group">
                <label>Product Name <span>*</span></label>
                <input type="text" name="name" placeholder="Enter Product Name" value="{{ old('name') }}" required>
                @error('name')
                    <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Status <span>*</span></label>
                <select name="status" required>
                    <option value="">Choose Status</option>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Price <span>*</span></label>
                <input type="number" name="price" placeholder="Rp 000000" min="0" value="{{ old('price') }}" required>
                @error('price')
                    <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                @error('description')
                    <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" onchange="previewImage(event)">

                {{-- Preview --}}
                <img id="imgPreview" width="80" style="border-radius:8px; margin-top:5px; display:none;">

                {{-- Error message --}}
                @error('image')
                    <div style="color:red; margin-top:5px">{{ $message }}</div>
                @enderror
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

                {{-- Customize Item 0 --}}
                <div class="customize-card">
                    <h5>Customize Menu</h5>

                    <div class="form-group">
                        <label>Customization Name</label>
                        <input type="text" name="customize[0][name]" placeholder="Coffee">
                    </div>

                    <div class="customize-inline">
                        <label>Customization Type</label>
                        <button type="button" onclick="addCustomizationType(0)">
                            + Add Customization Type
                        </button>
                    </div>

                    <div id="customize-types-0">
                        <input type="text" name="customize[0][types][]" placeholder="Normal">
                        <input type="text" name="customize[0][types][]" placeholder="Extra">
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- ACTION BUTTON --}}
<div class="product-form-actions">
    <a href="{{ route('products.index') }}" class="btn-cancel">Cancel</a>
    <button type="submit" class="btn-submit">Add New Products</button>
</div>

</form>

{{-- ================= JS ================= --}}
<script>
let customizeIndex = 1;

/* ADD CUSTOMIZE MENU */
function addCustomize() {
    const wrapper = document.getElementById('customize-wrapper');

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="customize-card">
            <h5>Customize Menu</h5>

            <div class="form-group">
                <label>Customization Name</label>
                <input type="text" name="customize[${customizeIndex}][name]" placeholder="Sugar">
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

/* PREVIEW IMAGE + SIZE VALIDATION */
function previewImage(event) {
    const file = event.target.files[0];
    if(!file) return;

    // Maksimal 2MB
    if(file.size > 2 * 1024 * 1024){
        alert("File terlalu besar! Maksimal 2MB.");
        event.target.value = ''; // reset input
        document.getElementById('imgPreview').style.display = 'none';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('imgPreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>

@endsection
