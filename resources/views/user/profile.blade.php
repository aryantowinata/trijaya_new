@extends('layouts.main')

@section('container')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Your Profile</h4>
                </div>
                <div class="card-body">
                    <!-- Form Update Profile -->
                    <form action="{{ route('user.updateProfileUser') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Photo Section -->
                        <div class="profile-photo-container text-center mb-4">
                            <label for="profile-photo-input" style="cursor: pointer;">
                                <img src="{{ $user->foto_profile ? asset('storage/' . $user->foto_profile) : asset('default-avatar.jpg') }}"
                                    alt="Profile Photo"
                                    class="profile-photo"
                                    id="profile-photo"
                                    style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover;">
                            </label>
                            <input type="file" id="profile-photo-input" name="file" accept="image/*" class="d-none">
                        </div>

                        <!-- Name and Address Section -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email (readonly)</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <!-- Address Section -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Address</label>
                            <textarea id="alamat" name="alamat" class="form-control" rows="3" required>{{ $user->alamat }}</textarea>
                        </div>

                        <!-- Submit Button for Profile -->
                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </form>
                    <hr>

                    <!-- Form Update Password -->
                    <form action="{{ route('user.updatePasswordUser') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter your current password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your new password" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re-enter your new password" required>
                            </div>
                        </div>

                        <!-- Submit Button for Password -->
                        <button type="submit" class="btn btn-primary w-100">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert Success Notification -->
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        confirmButtonText: 'OK',
    });
</script>
@endif

<!-- JavaScript for Image Preview -->
<script>
    document.getElementById('profile-photo-input').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profile-photo').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
@endsection