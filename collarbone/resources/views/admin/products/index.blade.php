@extends('admin.layout')

@section('title', 'Produk')
@section('page-title', 'Produk')
@section('page-subtitle', 'Kelola semua produk catalog')

@section('topbar-actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Produk
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Daftar Produk ({{ $products->total() }})</h2>
            <form method="GET" class="filter-bar">
                <div class="search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                </div>
                <select name="category" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Arrival</option>
                </select>
            </form>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    @if($product->thumbnail)
                                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="product-thumb">
                                    @else
                                        <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted)"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        </div>
                                    @endif
                                    <div class="product-info">
                                        <h4>{{ Str::limit($product->name, 30) }}</h4>
                                        <span>SKU: {{ $product->sku ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-purple">{{ $product->category->name ?? '-' }}</span>
                            </td>
                            <td>
                                @if($product->is_on_sale)
                                    <div style="font-weight:600;color:var(--accent-teal)">{{ $product->formatted_sale_price }}</div>
                                    <div style="font-size:12px;text-decoration:line-through;color:var(--text-muted)">{{ $product->formatted_price }}</div>
                                @else
                                    <div style="font-weight:600">{{ $product->formatted_price }}</div>
                                @endif
                            </td>
                            <td>
                                @if($product->stock < 10)
                                    <span class="badge badge-warning">{{ $product->stock }}</span>
                                @else
                                    <span class="badge badge-success">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                                @if($product->is_featured)
                                    <span class="badge badge-info" style="margin-left:4px">★</span>
                                @endif
                                @if($product->is_new_arrival)
                                    <span class="badge badge-purple" style="margin-left:4px">New</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn-icon" title="Detail">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" title="Hapus" style="color:var(--danger)">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                    <h3>Belum ada produk</h3>
                                    <p>Mulai tambahkan produk pertama Anda</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Tambah Produk
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} produk
                </div>
                <div class="pagination">
                    {{ $products->appends(request()->query())->links('vendor.pagination.custom-admin') }}
                </div>
            </div>
        @endif
    </div>
@endsection
