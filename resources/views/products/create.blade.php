<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product | Ordering System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="{{ route('products.index') }}">
      Ordering System
    </a>
    <div>
      <a href="{{ route('products.index') }}" class="btn btn-light btn-sm fw-semibold">
        ← Back to Products
      </a>
    </div>
  </div>
</nav>

<main class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <header class="mb-4 text-center">
        <h1 class="h3 fw-bold mb-1">Add New Product</h1>
        <p class="text-secondary mb-0">Fill in the details below to create a new catalog item.</p>
      </header>

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
       
          <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" novalidate>
            @csrf

         
            <div class="mb-4">
              <h2 class="h6 text-uppercase text-muted mb-3">Basic Information</h2>
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Product Name <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    name="product_name"
                    class="form-control @error('product_name') is-invalid @enderror"
                    placeholder="e.g., Wireless Mouse"
                    value="{{ old('product_name') }}"
                    required>
                  @error('product_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Price (₱) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input
                      type="number"
                      step="0.01"
                      min="0"
                      name="price"
                      class="form-control @error('price') is-invalid @enderror"
                      value="{{ old('price', '0.00') }}"
                      placeholder="0.00"
                      required>
                    @error('price')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Available Quantity <span class="text-danger">*</span></label>
                  <input
                    type="number"
                    min="0"
                    name="available_quantity"
                    class="form-control @error('available_quantity') is-invalid @enderror"
                    value="{{ old('available_quantity', 0) }}"
                    placeholder="0"
                    required>
                  @error('available_quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Category</label>
                  <select name="category" class="form-select @error('category') is-invalid @enderror">
                    <option value="" @selected(old('category')==='')>— Select —</option>

                 
                    <option value="Women" @selected(old('category')==='Women')>Women</option>
                    <option value="Men" @selected(old('category')==='Men')>Men</option>
                    <option value="Kids" @selected(old('category')==='Kids')>Kids</option>
                    <option value="Baby" @selected(old('category')==='Baby')>Baby</option>
                    <option value="Shoes" @selected(old('category')==='Shoes')>Shoes</option>
                    <option value="Bags" @selected(old('category')==='Bags')>Bags</option>
                    <option value="Accessories" @selected(old('category')==='Accessories')>Accessories</option>
                  </select>
                  @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <label class="form-label">Description</label>
                  <textarea
                    name="description"
                    rows="4"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Short details about this product...">{{ old('description') }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mb-4">
              <h2 class="h6 text-uppercase text-muted mb-3">Media</h2>
              <div class="row g-3 align-items-start">
                <div class="col-md-8">
                  <label class="form-label">Product Image</label>
                  <input
                    type="file"
                    name="image"
                    class="form-control @error('image') is-invalid @enderror"
                    accept="image/*">
                  <div class="form-text">Accepted formats: JPG, PNG, JPEG (max 2MB)</div>
                  @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-4">
                  <div class="thumb-preview border rounded d-flex align-items-center justify-content-center">
                    <img id="preview-image" alt="Preview" class="img-fluid d-none">
                    <span id="preview-placeholder" class="text-muted small">No preview</span>
                  </div>
                </div>
              </div>
            </div>

       
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
              <button type="submit" class="btn btn-primary px-4">Save Product</button>
            </div>
          </form>
        </div>
      </div>

      <p class="mt-3 text-center text-muted small">
        Fields marked with <span class="text-danger">*</span> are required.
      </p>

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

</body>
</html>
