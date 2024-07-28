@extends('layouts.main')
@section('content')
    
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
      <div class="col-md-12">

        <!-- Account -->
        @include('profile.partials.update-profile-information-form')
        <!-- /Account -->

        <!-- Change Password -->
        @include('profile.partials.update-password-form')
        <!--/ Change Password -->
        
        <!-- Delete Account -->
        {{-- @include('profile.partials.delete-user-form') --}}
        <!--/ Delete Account -->
        
      </div>
    </div>
</div>

@endsection