<div class="mb-3">
<label>Nama</label>
<input type="text" name="name" class="form-control" value="{{ old('name',$professional->name ?? '') }}" required>
</div>
<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" value="{{ old('email',$professional->email ?? '') }}" required>
</div>
<div class="mb-3">
<label>Password {{ isset($professional) ? '(kosongi jika tidak diubah)' : '' }}</label>
<input type="password" name="password" class="form-control" {{ isset($professional) ? '' : 'required' }}>
</div>
    