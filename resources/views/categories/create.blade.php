@extends('layouts.app')
@section('content')
<div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Categories --}}
    <a href="{{ route('categories.index') }}" style="text-decoration: none; color: #333;">
        <h2 style="font-size: 24px; font-weight: 700; margin: 0;">
            Stock 
            <span style="color: #999; font-weight: 400;">› Categories</span>
            <span style="color: #666; font-weight: 400;">› Add New Category</span>
        </h2>
    </a>
</div>
<form action="{{ route('categories.store') }}" method="POST" class="stock-form-card">
    @csrf
    <label>Category Name *</label>
    <input type="text" name="name" required style="width:100%; padding:10px; margin-bottom:20px;">
    
    <label>Status *</label>
    <select name="status" style="width:100%; padding:10px; margin-bottom:20px;">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
    
    <div style="display:flex; justify-content:flex-end; gap:10px;">
        <a href="{{ route('categories.index') }}" style="padding:10px 20px; background:red; color:white; text-decoration:none;">Cancel</a>
        <button type="submit" style="padding:10px 20px; background:#333; color:white; border:none;">Add New Category</button>
    </div>
</form>
@endsection