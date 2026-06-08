@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="page-header" style="margin-bottom:20px;">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Categories --}}
    <a href="{{ route('categories.index') }}" style="text-decoration: none; color: inherit;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Categories 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Edit Category
            </span>
        </h2>
    </a>
</div>
</div>

{{-- CARD --}}
<div class="card"
     style="
        background:#fff;
        padding:25px;
        border-radius:12px;
        box-shadow:0 2px 10px rgba(0,0,0,0.05);
     ">

    <form action="{{ route('categories.update', $category->id) }}" method="POST">

        @csrf
        @method('PUT')

        {{-- CATEGORY NAME --}}
        <div style="margin-bottom:20px;">

            <label style="
                display:block;
                margin-bottom:8px;
                font-weight:600;
                color:#333;
            ">
                Category Name
            </label>

            <input type="text"
                   name="name"
                   value="{{ $category->name }}"
                   required
                   style="
                        width:100%;
                        padding:12px;
                        border:1px solid #ddd;
                        border-radius:8px;
                        outline:none;
                   ">

        </div>

        {{-- STATUS --}}
        <div style="margin-bottom:25px;">

            <label style="
                display:block;
                margin-bottom:8px;
                font-weight:600;
                color:#333;
            ">
                Status
            </label>

            <select name="status"
                    style="
                        width:100%;
                        padding:12px;
                        border:1px solid #ddd;
                        border-radius:8px;
                        outline:none;
                    ">

                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>

        </div>

        {{-- BUTTON --}}
        <div style="display:flex; gap:12px;">

            {{-- BACK --}}
            <a href="{{ route('categories.index') }}"
               style="
                    padding:10px 18px;
                    background:#6c757d;
                    color:white;
                    text-decoration:none;
                    border-radius:8px;
                    transition:0.3s;
               "
               onmouseover="this.style.background='#5a6268'"
               onmouseout="this.style.background='#6c757d'">

                Back

            </a>

            {{-- UPDATE --}}
            <button type="submit"
                    style="
                        padding:10px 18px;
                        background:#333;
                        color:white;
                        border:none;
                        border-radius:8px;
                        cursor:pointer;
                        transition:0.3s;
                        font-weight:500;
                    "
                    onmouseover="this.style.background='#222'"
                    onmouseout="this.style.background='#333'">

                Update

            </button>

        </div>

    </form>

</div>

@endsection