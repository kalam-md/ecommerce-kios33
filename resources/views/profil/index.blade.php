@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="mb-6 card">
        <div class="pt-4 card-body">
          <form id="formAccountSettings" method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-12">
                  <img id="photo-preview" 
                      src="{{ $biodata->photo ? asset('uploads/profil/' . $biodata->photo) : asset('template/img/avatars/1.png') }}" 
                      alt="Preview Foto" 
                      style="width: 200px; height: 200px; display: block; margin: 10px 0; border-radius: 8px; object-fit: cover">
                </div>
                <div class="col-md-12">
                    <label for="photo" class="form-label">Photo Profil</label>
                    <input class="form-control" type="file" id="photo" name="photo" value="{{ $biodata->photo }}" accept="image/*" onchange="previewImage(this)"/>
                </div>
                <div class="col-md-12">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input class="form-control" type="text" id="nama_lengkap" name="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}"/>
                </div>
                <div class="col-md-6">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input class="form-control" type="number" name="nomor_telepon" id="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}" />
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ Auth::user()->email }}" />
                </div>
                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ $biodata->tanggal_lahir }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="select2 form-select">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-laki" {{ $biodata->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $biodata->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" cols="30" rows="5">{{ $biodata->alamat }}</textarea>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary me-3">Simpan perubahan</button>
                <a href="{{ route('beranda') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function previewImage(input) {
      const preview = document.getElementById('photo-preview');
      const file = input.files[0];
      const reader = new FileReader();
  
      reader.onloadend = function () {
          preview.src = reader.result;
      }
  
      if (file) {
          reader.readAsDataURL(file);
      } else {
          preview.src = "{{ $biodata->photo ? asset('uploads/profil/' . $biodata->photo) : asset('default-avatar.png') }}";
      }
  }
</script>
@endsection