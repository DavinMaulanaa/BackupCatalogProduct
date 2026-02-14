@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview catalog product Collarbone')

@section('topbar-actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Produk
    </a>
@endsection

@section('content')
    <style>
        @keyframes slideInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .slide-in-up {
            animation: slideInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .stagger-1 { animation-delay: 0.05s; }
        .stagger-2 { animation-delay: 0.1s; }
        .stagger-3 { animation-delay: 0.15s; }
        .stagger-4 { animation-delay: 0.2s; }
        .stagger-5 { animation-delay: 0.25s; }
        .stagger-6 { animation-delay: 0.3s; }

        .quick-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }
        .quick-action-card {
            flex: 1;
            min-width: 160px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            color: var(--text-primary);
        }
        .quick-action-card:hover {
            transform: translateY(-2px);
            border-color: var(--accent-teal);
            box-shadow: 0 4px 20px rgba(0, 212, 170, 0.15);
            color: var(--text-primary);
        }
        .quick-action-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .quick-action-icon svg { width: 22px; height: 22px; }
        .quick-action-label { font-size: 13px; font-weight: 600; }
        .quick-action-sublabel { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        .toggle-btn {
            background: none;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        .toggle-btn.active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-color: rgba(16, 185, 129, 0.3);
        }
        .toggle-btn.inactive {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border-color: rgba(239, 68, 68, 0.3);
        }
        .toggle-btn:hover {
            transform: scale(1.05);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.active { display: flex; opacity: 1; }
        .modal {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 100%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
            transform: scale(0.95);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal-overlay.active .modal { transform: scale(1); }
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-title { font-size: 18px; font-weight: 700; }
        .modal-close { background: none; border: none; color: var(--text-muted); cursor: pointer; }
        .modal-close:hover { color: var(--text-primary); }
        .modal-body { padding: 24px; max-height: 70vh; overflow-y: auto; }
        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .confirm-dialog {
            text-align: center;
            padding: 20px 0;
        }
        .confirm-dialog svg {
            width: 48px;
            height: 48px;
            color: var(--warning);
            margin-bottom: 16px;
        }
        .confirm-dialog h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }
        .confirm-dialog p {
            color: var(--text-muted);
            font-size: 14px;
        }
    </style>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card slide-in-up stagger-1" style="--stat-color: var(--accent-teal); --stat-bg: var(--accent-teal-glow)">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            </div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-card slide-in-up stagger-2" style="--stat-color: var(--success); --stat-bg: rgba(16, 185, 129, 0.1)">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="stat-value">{{ $activeProducts }}</div>
            <div class="stat-label">Produk Aktif</div>
        </div>
        <div class="stat-card slide-in-up stagger-3" style="--stat-color: var(--accent-purple); --stat-bg: var(--accent-purple-glow)">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="stat-value">{{ $totalCategories }}</div>
            <div class="stat-label">Total Kategori</div>
        </div>
        <div class="stat-card slide-in-up stagger-4" style="--stat-color: var(--accent-blue); --stat-bg: rgba(59, 130, 246, 0.1)">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            </div>
            <div class="stat-value">{{ $newArrivals }}</div>
            <div class="stat-label">New Arrivals</div>
        </div>
        <div class="stat-card slide-in-up stagger-5" style="--stat-color: var(--accent-pink); --stat-bg: rgba(236, 72, 153, 0.1)">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div class="stat-value">{{ $featuredProducts }}</div>
            <div class="stat-label">Featured</div>
        </div>
        <div class="stat-card slide-in-up stagger-6" style="--stat-color: var(--warning); --stat-bg: rgba(245, 158, 11, 0.1)">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="stat-value">{{ $lowStock }}</div>
            <div class="stat-label">Stok Rendah</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions slide-in-up" style="animation-delay: 0.2s;">
        <a href="{{ route('admin.products.create') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: var(--accent-teal-glow); color: var(--accent-teal);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </div>
            <div>
                <div class="quick-action-label">Tambah Produk</div>
                <div class="quick-action-sublabel">Buat produk baru</div>
            </div>
        </a>
        <a href="{{ route('admin.categories.create') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: var(--accent-purple-glow); color: var(--accent-purple);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <div class="quick-action-label">Tambah Kategori</div>
                <div class="quick-action-sublabel">Buat kategori baru</div>
            </div>
        </a>
        <a href="{{ route('admin.new_arrivals') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            </div>
            <div>
                <div class="quick-action-label">Kelola New Arrivals</div>
                <div class="quick-action-sublabel">{{ $newArrivals }} produk</div>
            </div>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Recent Products with Full CRUD -->
        <div class="card slide-in-up" style="animation-delay: 0.3s;">
            <div class="card-header">
                <h2>Produk Terbaru</h2>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                            <tr id="product-row-{{ $product->id }}">
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
                                            <h4>{{ Str::limit($product->name, 25) }}</h4>
                                            <span>{{ $product->category->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->formatted_price }}</td>
                                <td>
                                    <button class="toggle-btn {{ $product->is_active ? 'active' : 'inactive' }}" 
                                            onclick="toggleProductStatus({{ $product->id }}, this)"
                                            title="Klik untuk toggle status">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        <button class="btn-icon" style="color:var(--danger);" title="Hapus" onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Categories with CRUD -->
        <div class="card slide-in-up" style="animation-delay: 0.35s;">
            <div class="card-header">
                <h2>Kategori Teratas</h2>
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Jumlah Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categoriesWithCount as $category)
                            <tr id="category-row-{{ $category->id }}">
                                <td>
                                    <div class="product-cell">
                                        @if($category->image_url)
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="product-thumb">
                                        @else
                                            <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted)"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                            </div>
                                        @endif
                                        <div class="product-info">
                                            <h4>{{ $category->name }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $category->products_count }} produk</span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        <button class="btn-icon" style="color:var(--danger);" title="Hapus" onclick="confirmDeleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== TESTIMONIALS SECTION ==================== -->
    <div class="card slide-in-up" style="animation-delay: 0.4s; margin-top: 24px;">
        <div class="card-header">
            <h2>🗣️ Kelola Testimonial</h2>
            <button class="btn btn-primary btn-sm" onclick="openModal('addTestimonialModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Testimonial
            </button>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Konten</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <td>
                                @if($testimonial->photo_url)
                                    <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="product-thumb" style="border-radius:50%;">
                                @else
                                    <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;border-radius:50%;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted)"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $testimonial->name }}</strong></td>
                            <td><span class="badge badge-purple">{{ $testimonial->role ?? '-' }}</span></td>
                            <td style="max-width:300px;">{{ Str::limit($testimonial->content, 80) }}</td>
                            <td>
                                <button class="toggle-btn {{ $testimonial->is_active ? 'active' : 'inactive' }}"
                                        onclick="toggleTestimonialStatus({{ $testimonial->id }}, this)">
                                    {{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <button class="btn-icon" title="Edit" onclick="editTestimonial({{ json_encode($testimonial) }})">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="btn-icon" style="color:var(--danger);" title="Hapus" onclick="confirmDeleteTestimonial({{ $testimonial->id }}, '{{ addslashes($testimonial->name) }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada testimonial</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ==================== COLLECTIONS SECTION ==================== -->
    <div class="card slide-in-up" style="animation-delay: 0.45s; margin-top: 24px;">
        <div class="card-header">
            <h2>🖼️ Kelola Collection</h2>
            <button class="btn btn-primary btn-sm" onclick="openModal('addCollectionModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Collection
            </button>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Subtitle</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collections as $collection)
                        <tr>
                            <td>
                                @if($collection->image_url)
                                    <img src="{{ $collection->image_url }}" alt="{{ $collection->title }}" class="product-thumb">
                                @else
                                    <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted)"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $collection->title }}</strong></td>
                            <td><span class="badge badge-info">{{ $collection->subtitle ?? '-' }}</span></td>
                            <td>
                                <button class="toggle-btn {{ $collection->is_active ? 'active' : 'inactive' }}"
                                        onclick="toggleCollectionStatus({{ $collection->id }}, this)">
                                    {{ $collection->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <button class="btn-icon" title="Edit" onclick="editCollection({{ json_encode($collection) }})">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="btn-icon" style="color:var(--danger);" title="Hapus" onclick="confirmDeleteCollection({{ $collection->id }}, '{{ addslashes($collection->title) }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada collection</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ==================== ALL MODALS ==================== -->

    <!-- Delete Product Modal -->
    <div id="deleteProductModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Hapus Produk</h2>
                <button type="button" class="modal-close" onclick="closeModal('deleteProductModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <div class="modal-body">
                <div class="confirm-dialog">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <h3>Yakin ingin menghapus?</h3>
                    <p id="deleteProductMessage">Produk ini akan dihapus secara permanen.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteProductModal')">Batal</button>
                <form id="deleteProductForm" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Hapus Produk</button></form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div id="deleteCategoryModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Hapus Kategori</h2>
                <button type="button" class="modal-close" onclick="closeModal('deleteCategoryModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <div class="modal-body">
                <div class="confirm-dialog">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <h3>Yakin ingin menghapus?</h3>
                    <p id="deleteCategoryMessage">Kategori beserta semua produk di dalamnya akan dihapus secara permanen.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteCategoryModal')">Batal</button>
                <form id="deleteCategoryForm" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Hapus Kategori</button></form>
            </div>
        </div>
    </div>

    <!-- Add Testimonial Modal -->
    <div id="addTestimonialModal" class="modal-overlay">
        <div class="modal" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Testimonial</h2>
                <button type="button" class="modal-close" onclick="closeModal('addTestimonialModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label class="form-label">Nama *</label><input type="text" name="name" class="form-control" required></div>
                    <div class="form-group"><label class="form-label">Role</label><input type="text" name="role" class="form-control" placeholder="e.g. Mahasiswa, Content Creator"></div>
                    <div class="form-group"><label class="form-label">Konten Testimonial *</label><textarea name="content" class="form-control" rows="3" required></textarea></div>
                    <div class="form-group"><label class="form-label">Upload Foto</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
                    <div class="form-group"><label class="form-label">Atau URL Foto</label><input type="url" name="photo_url" class="form-control" placeholder="https://..."></div>
                    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-control" value="0" min="0"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addTestimonialModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Testimonial Modal -->
    <div id="editTestimonialModal" class="modal-overlay">
        <div class="modal" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Edit Testimonial</h2>
                <button type="button" class="modal-close" onclick="closeModal('editTestimonialModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <form id="editTestimonialForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group"><label class="form-label">Nama *</label><input type="text" name="name" id="editTestName" class="form-control" required></div>
                    <div class="form-group"><label class="form-label">Role</label><input type="text" name="role" id="editTestRole" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Konten Testimonial *</label><textarea name="content" id="editTestContent" class="form-control" rows="3" required></textarea></div>
                    <div class="form-group"><label class="form-label">Upload Foto Baru</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
                    <div class="form-group"><label class="form-label">Atau URL Foto</label><input type="url" name="photo_url" id="editTestPhotoUrl" class="form-control" placeholder="https://..."></div>
                    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" id="editTestOrder" class="form-control" value="0" min="0"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editTestimonialModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Testimonial Modal -->
    <div id="deleteTestimonialModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Hapus Testimonial</h2>
                <button type="button" class="modal-close" onclick="closeModal('deleteTestimonialModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <div class="modal-body">
                <div class="confirm-dialog">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <h3>Yakin ingin menghapus?</h3>
                    <p id="deleteTestimonialMessage">Testimonial ini akan dihapus secara permanen.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteTestimonialModal')">Batal</button>
                <form id="deleteTestimonialForm" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Hapus</button></form>
            </div>
        </div>
    </div>

    <!-- Add Collection Modal -->
    <div id="addCollectionModal" class="modal-overlay">
        <div class="modal" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Collection</h2>
                <button type="button" class="modal-close" onclick="closeModal('addCollectionModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <form action="{{ route('admin.collections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group"><label class="form-label">Judul *</label><input type="text" name="title" class="form-control" required placeholder="e.g. T-Shirt | Limited Edition"></div>
                    <div class="form-group"><label class="form-label">Subtitle</label><input type="text" name="subtitle" class="form-control" placeholder="e.g. CATEGORY"></div>
                    <div class="form-group"><label class="form-label">Upload Gambar</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="form-group"><label class="form-label">Atau Path/URL Gambar</label><input type="text" name="image_url" class="form-control" placeholder="img/1.png atau https://..."></div>
                    <div class="form-group"><label class="form-label">Link</label><input type="text" name="link" class="form-control" placeholder="#"></div>
                    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-control" value="0" min="0"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addCollectionModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Collection Modal -->
    <div id="editCollectionModal" class="modal-overlay">
        <div class="modal" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Edit Collection</h2>
                <button type="button" class="modal-close" onclick="closeModal('editCollectionModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <form id="editCollectionForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group"><label class="form-label">Judul *</label><input type="text" name="title" id="editCollTitle" class="form-control" required></div>
                    <div class="form-group"><label class="form-label">Subtitle</label><input type="text" name="subtitle" id="editCollSubtitle" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Upload Gambar Baru</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="form-group"><label class="form-label">Atau Path/URL Gambar</label><input type="text" name="image_url" id="editCollImageUrl" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Link</label><input type="text" name="link" id="editCollLink" class="form-control"></div>
                    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" id="editCollOrder" class="form-control" value="0" min="0"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editCollectionModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Collection Modal -->
    <div id="deleteCollectionModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Hapus Collection</h2>
                <button type="button" class="modal-close" onclick="closeModal('deleteCollectionModal')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
            </div>
            <div class="modal-body">
                <div class="confirm-dialog">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <h3>Yakin ingin menghapus?</h3>
                    <p id="deleteCollectionMessage">Collection ini akan dihapus secara permanen.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteCollectionModal')">Batal</button>
                <form id="deleteCollectionForm" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Hapus</button></form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                ${type === 'success' 
                    ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>' 
                    : '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'}
            </svg>
            ${message}
        `;

        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(50px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Toggle Product Status via AJAX
    function toggleProductStatus(productId, btn) {
        fetch(`/admin/products/${productId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.className = `toggle-btn ${data.is_active ? 'active' : 'inactive'}`;
                btn.textContent = data.is_active ? 'Aktif' : 'Nonaktif';
                showToast(data.message, 'success');
            }
        })
        .catch(err => {
            showToast('Gagal mengubah status', 'error');
        });
    }

    // Delete Product
    function confirmDelete(productId, productName) {
        document.getElementById('deleteProductMessage').textContent = `Produk "${productName}" akan dihapus secara permanen.`;
        document.getElementById('deleteProductForm').action = `/admin/products/${productId}`;
        openModal('deleteProductModal');
    }

    // Delete Category
    function confirmDeleteCategory(categoryId, categoryName) {
        document.getElementById('deleteCategoryMessage').textContent = `Kategori "${categoryName}" beserta semua produk di dalamnya akan dihapus secara permanen.`;
        document.getElementById('deleteCategoryForm').action = `/admin/categories/${categoryId}`;
        openModal('deleteCategoryModal');
    }

    // ==================== TESTIMONIAL FUNCTIONS ====================
    function editTestimonial(testimonial) {
        document.getElementById('editTestimonialForm').action = `/admin/testimonials/${testimonial.id}`;
        document.getElementById('editTestName').value = testimonial.name;
        document.getElementById('editTestRole').value = testimonial.role || '';
        document.getElementById('editTestContent').value = testimonial.content;
        document.getElementById('editTestPhotoUrl').value = testimonial.photo && testimonial.photo.startsWith('http') ? testimonial.photo : '';
        document.getElementById('editTestOrder').value = testimonial.sort_order || 0;
        openModal('editTestimonialModal');
    }

    function toggleTestimonialStatus(id, btn) {
        fetch(`/admin/testimonials/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.className = `toggle-btn ${data.is_active ? 'active' : 'inactive'}`;
                btn.textContent = data.is_active ? 'Aktif' : 'Nonaktif';
                showToast(data.message, 'success');
            }
        })
        .catch(() => showToast('Gagal mengubah status', 'error'));
    }

    function confirmDeleteTestimonial(id, name) {
        document.getElementById('deleteTestimonialMessage').textContent = `Testimonial dari "${name}" akan dihapus secara permanen.`;
        document.getElementById('deleteTestimonialForm').action = `/admin/testimonials/${id}`;
        openModal('deleteTestimonialModal');
    }

    // ==================== COLLECTION FUNCTIONS ====================
    function editCollection(collection) {
        document.getElementById('editCollectionForm').action = `/admin/collections/${collection.id}`;
        document.getElementById('editCollTitle').value = collection.title;
        document.getElementById('editCollSubtitle').value = collection.subtitle || '';
        document.getElementById('editCollImageUrl').value = collection.image || '';
        document.getElementById('editCollLink').value = collection.link || '';
        document.getElementById('editCollOrder').value = collection.sort_order || 0;
        openModal('editCollectionModal');
    }

    function toggleCollectionStatus(id, btn) {
        fetch(`/admin/collections/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.className = `toggle-btn ${data.is_active ? 'active' : 'inactive'}`;
                btn.textContent = data.is_active ? 'Aktif' : 'Nonaktif';
                showToast(data.message, 'success');
            }
        })
        .catch(() => showToast('Gagal mengubah status', 'error'));
    }

    function confirmDeleteCollection(id, title) {
        document.getElementById('deleteCollectionMessage').textContent = `Collection "${title}" akan dihapus secara permanen.`;
        document.getElementById('deleteCollectionForm').action = `/admin/collections/${id}`;
        openModal('deleteCollectionModal');
    }
</script>
@endsection
