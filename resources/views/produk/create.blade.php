@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-12">
      <div class="mb-6 card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Data Produk</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-md-12">
                <div id="image-preview-container" class="flex-wrap gap-3 d-flex justify-content-center">
                  
                </div>
              </div>
              <div class="col-6">
                <label class="form-label" for="gambar">Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar[]" accept="image/*" multiple onchange="previewImages(this)"/>
              </div>
              <div class="col-6">
                <label class="form-label" for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk"/>
              </div>
              <div class="col-6">
                <label class="form-label" for="kategori_id">Kategori</label>
                <select class="form-select" id="kategori_id" name="kategori_id">
                  <option>Pilih kategori</option>
                  @foreach ($kategoris as $kategori)
                  <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6">
                <label class="form-label" for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok"/>
              </div>
              <div class="col-6">
                <label class="form-label" for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga"/>
              </div>
              <div class="col-6">
                <label class="form-label" for="satuan">Satuan</label>
                <select class="form-select" id="satuan" name="satuan">
                  <option>Pilih satuan</option>
                  <option value="pcs">Pcs</option>
                  <option value="kg">Kg</option>
                  <option value="lusin">Lusin</option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label" for="berat">Berat</label>
                <input type="number" class="form-control" id="berat" name="berat"/>
                <div class="form-text">*Berat boleh dikosongkan</div>
              </div>
              <div class="col-6">
                <label class="form-label" for="dimensi">Dimensi</label>
                <input type="text" class="form-control" id="dimensi" name="dimensi"/>
                <div class="form-text">*Dimensi boleh dikosongkan</div>
              </div>
              <div class="col-12">
                <label class="form-label" for="spesifikasi">Spesifikasi</label>
                <textarea name="spesifikasi" class="form-control" id="" cols="30" rows="5"></textarea>
              </div>
              <div class="mb-6 col-12">
                <label class="form-label" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="" cols="30" rows="5"></textarea>
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-3">Simpan</button>
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function previewImages(input) {
      const container = document.getElementById('image-preview-container');
      container.innerHTML = ''; // Clear existing previews
      
      if (input.files) {
          [...input.files].forEach(file => {
              const reader = new FileReader();
              
              reader.onload = function(e) {
                  const previewWrapper = document.createElement('div');
                  previewWrapper.className = 'position-relative';
                  previewWrapper.style.width = '200px';
                  
                  const img = document.createElement('img');
                  img.src = e.target.result;
                  img.className = 'img-fluid';
                  img.style.width = '200px';
                  img.style.height = '200px';
                  img.style.objectFit = 'cover';
                  img.style.borderRadius = '8px';
                  
                  const deleteBtn = document.createElement('button');
                  deleteBtn.innerHTML = '&times;';
                  deleteBtn.className = 'btn btn-danger btn-sm position-absolute';
                  deleteBtn.style.top = '5px';
                  deleteBtn.style.right = '5px';
                  deleteBtn.style.borderRadius = '100%';
                  deleteBtn.style.padding = '2px 8px';
                  deleteBtn.onclick = function(e) {
                      e.preventDefault();
                      previewWrapper.remove();
                      // Create a new FileList without this image
                      const dt = new DataTransfer();
                      const files = input.files;
                      for (let i = 0; i < files.length; i++) {
                          if (files[i] !== file) dt.items.add(files[i]);
                      }
                      input.files = dt.files;
                  };
                  
                  previewWrapper.appendChild(img);
                  previewWrapper.appendChild(deleteBtn);
                  container.appendChild(previewWrapper);
              }
              
              reader.readAsDataURL(file);
          });
      }
  }
</script>
@endsection