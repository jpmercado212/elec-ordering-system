@extends('layouts.app')

@section('title', 'Edit Product | Trendify')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Edit Product</h1>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">

      @if ($errors->any())
        <div class="alert alert-danger">
          <strong>Please fix the following:</strong>
          <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

          
            <div class="mb-4">
              <h2 class="h6 text-uppercase text-muted mb-3">Basic Information</h2>
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Product Name <span class="text-danger">*</span></label>
                  <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                         value="{{ old('product_name', $product->product_name) }}" required>
                  @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Price (₱) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" step="0.01" min="0" name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $product->price) }}" required>
                  </div>
                  @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Available Quantity <span class="text-danger">*</span></label>
                  <input type="number" min="0" name="available_quantity"
                         class="form-control @error('available_quantity') is-invalid @enderror"
                         value="{{ old('available_quantity', $product->available_quantity) }}" required>
                  @error('available_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Category</label>
                  <select name="category" class="form-select @error('category') is-invalid @enderror">
                    @php $cat = old('category', $product->category); @endphp
                    <option value="" @selected($cat==='')>— Select —</option>
                    <option value="Electronics" @selected($cat==='Electronics')>Electronics</option>
                    <option value="Home" @selected($cat==='Home')>Home</option>
                    <option value="School/Office" @selected($cat==='School/Office')>School/Office</option>
                    <option value="Accessories" @selected($cat==='Accessories')>Accessories</option>
                  </select>
                  @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label class="form-label">Description</label>
                  <textarea name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Short details about this product...">{{ old('description', $product->description) }}</textarea>
                  @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>
            </div>

            
            <div class="mb-4">
              <h2 class="h6 text-uppercase text-muted mb-3">Media</h2>
              <div class="row g-3 align-items-start">
                <div class="col-md-8">
                  <label class="form-label">Replace Image</label>
                  <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                  <div class="form-text">Accepted formats: JPG, PNG, JPEG (max 2MB)</div>
                  @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" value="1" id="remove_image" name="remove_image">
                    <label class="form-check-label" for="remove_image">
                      Remove current image
                    </label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="thumb-preview border rounded d-flex align-items-center justify-content-center">
                    @if($product->image)
                      <img id="preview-image" src="{{ asset('uploads/'.$product->image) }}" alt="Preview" class="thumb-64">
                    @else
                      <img id="preview-image" alt="Preview" class="thumb-64 d-none">
                    @endif
                    <span id="preview-placeholder" class="text-muted small {{ $product->image ? 'd-none' : '' }}">No preview</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
              <button type="submit" class="btn btn-primary px-4">Save Changes</button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
 
  const fileInput = document.querySelector('input[name="image"]');
  const previewImg = document.getElementById('preview-image');
  const previewPlaceholder = document.getElementById('preview-placeholder');

  if (fileInput) {
    fileInput.addEventListener('change', function(e){
      const [file] = e.target.files || [];
      if (file){
        previewImg.src = URL.createObjectURL(file);
        previewImg.classList.remove('d-none');
        previewPlaceholder.classList.add('d-none');
      } else {
        previewImg.src = '';
        previewImg.classList.add('d-none');
        previewPlaceholder.classList.remove('d-none');
      }
    });
  }
</script>
@endsection
