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

    <div class="card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">

        <div class="product-form-wrapper" style="display: flex; gap: 30px; flex-wrap: wrap;">

            {{-- ================= LEFT (DATA PRODUK UTAMA) ================= --}}
            <div class="product-form-left" style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 15px;">

                <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 600; color: #555;">Product Name <span style="color: red;">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter Product Name" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 600; color: #555;">Status <span style="color: red;">*</span></label>
                    <select name="status" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: #fff;">
                        <option value="">Choose Status</option>
                        <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 600; color: #555;">Price <span style="color: red;">*</span></label>
                    <input type="number" name="price" min="0" value="{{ old('price', $product->price) }}" placeholder="Rp 000000" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 600; color: #555;">Description</label>
                    <textarea name="description" placeholder="Enter Description" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; min-height: 100px; resize: vertical;">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group" style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 600; color: #555;">Image</label>
                    <input type="file" name="image" style="padding: 5px 0;">
                    @if($product->image)
                        <div style="margin-top:10px">
                            <img src="{{ asset('storage/'.$product->image) }}" style="width:80px; border-radius:8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                    @endif
                </div>

            </div>

            {{-- ================= RIGHT (CUSTOMIZE MENU) ================= --}}
            <div class="product-form-right" style="flex: 1; min-width: 300px; background: #fdfbf9; padding: 20px; border-radius: 8px; border: 1px solid #f0e6df;">

                <div class="customize-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h4 style="margin: 0; color: #4A3525; font-size: 18px; font-weight: 700;">Customize Menu</h4>
                    <button type="button" onclick="addCustomize()" class="add-btn" style="padding: 8px 12px; background: #4A3525; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 13px;">
                        + Add Customization
                    </button>
                </div>

                <div id="customize-wrapper" style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Loop data kustomisasi yang sudah pernah dibuat saat create --}}
                    @foreach($product->customizes ?? [] as $i => $customize)
                        <div class="customize-card" id="customize-card-{{ $i }}" style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #eddcd2; position: relative;">
                            
                            {{-- Tombol Hapus Grup Kustomisasi --}}
                            <button type="button" onclick="removeElement('customize-card-{{ $i }}')" style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold;">✕</button>

                            <h5 style="margin: 0 0 10px 0; color: #6c584c; font-size: 14px;">Customize Option</h5>

                            {{-- Mengirimkan ID kustomisasi yang sudah ada agar tidak duplikat di backend --}}
                            <input type="hidden" name="customize[{{ $i }}][id]" value="{{ $customize->id }}">

                            <div class="form-group" style="display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px;">
                                <label style="font-size: 13px; font-weight: 600; color: #555;">Customization Name</label>
                                <input type="text" name="customize[{{ $i }}][name]" value="{{ $customize->name }}" placeholder="e.g., Level Gula, Toppping" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                            </div>

                            <div class="customize-inline" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <label style="font-size: 13px; font-weight: 600; color: #555;">Customization Variant / Type</label>
                                <button type="button" onclick="addCustomizationType({{ $i }})" style="padding: 4px 8px; background: #8C7A6B; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 11px;">
                                    + Add Type
                                </button>
                            </div>

                            <div id="customize-types-{{ $i }}" style="display: flex; flex-direction: column; gap: 8px;">
                                @foreach($customize->types ?? [] as $j => $type)
                                    <div id="type-row-{{ $i }}-{{ $j }}" style="display: flex; gap: 5px; align-items: center;">
                                        {{-- Mengirimkan ID tipe varian yang sudah ada --}}
                                        <input type="hidden" name="customize[{{ $i }}][type_ids][]" value="{{ $type->id }}">
                                        
                                        <input type="text" 
                                               name="customize[{{ $i }}][types][]" 
                                               value="{{ $type->name }}" 
                                               class="custom-input" 
                                               placeholder="e.g., Less Sugar, Normal" 
                                               style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                                        
                                        <button type="button" onclick="removeElement('type-row-{{ $i }}-{{ $j }}')" style="background: none; border: none; color: #999; cursor: pointer; font-size: 14px;">✕</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- ACTION BUTTONS --}}
    <div class="product-form-actions" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
        <a href="{{ route('products.index') }}" class="btn-cancel" style="padding: 10px 20px; background: #6c757d; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;">Cancel</a>
        <button type="submit" class="btn-submit" style="padding: 10px 20px; background: #4A3525; color: #fff; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Update Product</button>
    </div>

</form>

{{-- ================= JAVASCRIPT ================= --}}
<script>
// Ambil total index kustomisasi dari data yang ada di database agar tidak berbenturan
let customizeIndex = {{ count($product->customizes ?? []) }};
// Penanda unik untuk row tipe input baru
let typeUniqueId = 0; 

/* FUNGSI TAMBAH GRUP KUSTOMISASI BARU */
function addCustomize() {
    const wrapper = document.getElementById('customize-wrapper');
    const currentId = customizeIndex;

    const html = `
        <div class="customize-card" id="customize-card-${currentId}" style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #eddcd2; position: relative;">
            <button type="button" onclick="removeElement('customize-card-${currentId}')" style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold;">✕</button>
            
            <h5 style="margin: 0 0 10px 0; color: #6c584c; font-size: 14px;">Customize Option</h5>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 600; color: #555;">Customization Name</label>
                <input type="text" name="customize[${currentId}][name]" placeholder="e.g., Level Gula, Topping" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>

            <div class="customize-inline" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="font-size: 13px; font-weight: 600; color: #555;">Customization Variant / Type</label>
                <button type="button" onclick="addCustomizationType(${currentId})" style="padding: 4px 8px; background: #8C7A6B; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 11px;">
                    + Add Type
                </button>
            </div>

            <div id="customize-types-${currentId}" style="display: flex; flex-direction: column; gap: 8px;">
                <div id="type-row-${currentId}-init" style="display: flex; gap: 5px; align-items: center;">
                    <input type="text" name="customize[${currentId}][types][]" placeholder="e.g., Normal, Less Sugar" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    <button type="button" onclick="removeElement('type-row-${currentId}-init')" style="background: none; border: none; color: #999; cursor: pointer; font-size: 14px;">✕</button>
                </div>
            </div>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    customizeIndex++;
}

/* FUNGSI TAMBAH INPUT VARIAN / TIPE BARU */
function addCustomizationType(index) {
    const wrapper = document.getElementById('customize-types-' + index);
    const rowId = `type-row-${index}-new-${typeUniqueId}`;

    const html = `
        <div id="${rowId}" style="display: flex; gap: 5px; align-items: center;">
            <input type="text" name="customize[${index}][types][]" placeholder="New Variant" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            <button type="button" onclick="removeElement('${rowId}')" style="background: none; border: none; color: #999; cursor: pointer; font-size: 14px;">✕</button>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    typeUniqueId++;
}

/* FUNGSI HAPUS ELEMEN (UNTUK MENGHAPUS GRUP/TIPE DINAMIS) */
function removeElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.remove();
    }
}
</script>

@endsection