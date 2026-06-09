@extends('layouts.dashboard')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="max-w-2xl space-y-6">

  @if(session('status') === 'profile-updated')
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
      Profile updated successfully!
    </div>
  @endif
  @if(session('status') === 'password-updated')
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
      Password updated successfully!
    </div>
  @endif

  {{-- Profile Information --}}
  <div class="bg-white rounded-2xl p-6 shadow-md">
    <h2 class="text-xl font-semibold text-dark mb-1">Profile Information</h2>
    <p class="text-sm text-gray-500 mb-6">Update your name and email address.</p>
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
      @csrf
      @method('PATCH')
      <div class="form-control">
        <label class="label" for="name">
          <span class="label-text text-dark font-medium">Full Name</span>
        </label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
               required autocomplete="name"
               class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full {{ $errors->has('name') ? 'border-red-400' : '' }}" />
        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="form-control">
        <label class="label" for="email">
          <span class="label-text text-dark font-medium">Email Address</span>
        </label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
               required autocomplete="username"
               class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full {{ $errors->has('email') ? 'border-red-400' : '' }}" />
        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
      </div>
      <button type="submit" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl px-8">
        Save Changes
      </button>
    </form>
  </div>

  {{-- Update Password --}}
  <div class="bg-white rounded-2xl p-6 shadow-md">
    <h2 class="text-xl font-semibold text-dark mb-1">Update Password</h2>
    <p class="text-sm text-gray-500 mb-6">Use a long, random password to keep your account secure.</p>
    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
      @csrf
      @method('PUT')
      <div class="form-control">
        <label class="label" for="current_password">
          <span class="label-text text-dark font-medium">Current Password</span>
        </label>
        <input id="current_password" type="password" name="current_password" autocomplete="current-password"
               class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full {{ $errors->updatePassword->has('current_password') ? 'border-red-400' : '' }}" />
        @if($errors->updatePassword->has('current_password'))
          <p class="text-red-500 text-sm mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
        @endif
      </div>
      <div class="form-control">
        <label class="label" for="new_password">
          <span class="label-text text-dark font-medium">New Password</span>
        </label>
        <input id="new_password" type="password" name="password" autocomplete="new-password"
               class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full {{ $errors->updatePassword->has('password') ? 'border-red-400' : '' }}" />
        @if($errors->updatePassword->has('password'))
          <p class="text-red-500 text-sm mt-1">{{ $errors->updatePassword->first('password') }}</p>
        @endif
      </div>
      <div class="form-control">
        <label class="label" for="password_confirmation">
          <span class="label-text text-dark font-medium">Confirm New Password</span>
        </label>
        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
               class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
      </div>
      <button type="submit" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl px-8">
        Update Password
      </button>
    </form>
  </div>

  {{-- Danger Zone --}}
  <div class="bg-white rounded-2xl p-6 shadow-md border border-red-100">
    <h2 class="text-xl font-semibold text-red-600 mb-1">Danger Zone</h2>
    <p class="text-sm text-gray-500 mb-6">Once deleted, your account and all data are permanently removed.</p>
    <button onclick="document.getElementById('delete-modal').showModal()"
            class="btn bg-red-500 hover:bg-red-600 text-white border-none rounded-xl">
      Delete Account
    </button>
    <dialog id="delete-modal" class="modal">
      <div class="modal-box rounded-2xl">
        <h3 class="font-bold text-lg text-dark mb-2">Are you sure?</h3>
        <p class="text-gray-500 text-sm mb-6">Enter your password to permanently delete your account.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
          @csrf
          @method('DELETE')
          <div class="form-control">
            <label class="label"><span class="label-text text-dark font-medium">Your Password</span></label>
            <input type="password" name="password" placeholder="Enter your password"
                   class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full {{ $errors->userDeletion->has('password') ? 'border-red-400' : '' }}" />
            @if($errors->userDeletion->has('password'))
              <p class="text-red-500 text-sm mt-1">{{ $errors->userDeletion->first('password') }}</p>
            @endif
          </div>
          <div class="flex gap-3 justify-end">
            <button type="button" onclick="document.getElementById('delete-modal').close()"
                    class="btn btn-ghost rounded-xl">Cancel</button>
            <button type="submit" class="btn bg-red-500 hover:bg-red-600 text-white border-none rounded-xl">
              Yes, Delete My Account
            </button>
          </div>
        </form>
      </div>
      <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
  </div>

</div>
@endsection