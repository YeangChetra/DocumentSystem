<x-app-layout>
  <main>
    <div class="container-fluid">
      <h2 class="mt-30 page-title">Add User Account</h2>
      <ol class="breadcrumb mb-30">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">User Accounts</a></li>
        <li class="breadcrumb-item active">Add User Account</li>
      </ol>
      <div class="row">
        <div class="col-lg-12 col-md-12" style="margin:auto;">
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>Add User Account</h4>
            </div>
            <form class="formAccount" id="formAccount" method="post" enctype="multipart/form-data"
              action="{{ route('users.store')}}">
              {{csrf_field()}}
              @method('post')
              <div class="card-body-table">
                <div class="news-content-right pd-20">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Personal Information</label>
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Full Name*</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                          class="form-control @error('name') is-invalid @enderror" placeholder="Enter Full Name"
                          data-error=".errorTxt1">
                        <div class="errorTxt1 msg-error"></div>
                        @error('name')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Phone*</label>
                        <input type="number" id="phone" name="phone" value="{{ old('phone') }}"
                          class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Phone Number"
                          data-error=".errorTxt2">
                        <div class="errorTxt2 msg-error"></div>
                        @error('phone')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Roles</label>
                      </div>
                      <div class="row">
                        @foreach($roles as $role)
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                          <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" id="{{$role->name}}" name="roles[]" type="checkbox"
                                value="{{$role->id}}" @if(old('roles')) @foreach(old('roles') as $item)
                                @if($item==$role->id)
                              checked
                              @endif
                              @endforeach
                              @endif />
                              <label class="custom-control-label" for="{{$role->name}}">{{ $role->name }}</label>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">User Account</label>
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Email*</label>
                        <input type="text" id="email" name="email" value="{{ old('email') }}"
                          class="form-control @error('email') is-invalid @enderror" placeholder="Enter Username"
                          data-error=".errorTxt3">
                        <div class="errorTxt3 msg-error"></div>
                        @error('email')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3 padding-right-input-password">
                        <label class="form-label">New Password*</label>
                        <input type="password" id="password" name="password"
                          class="form-control @error('password') is-invalid @enderror" placeholder="Enter New Password"
                          data-error=".errorTxt4">
                        <i id="0" class="fa fa-eye new_password" aria-hidden="true"></i>
                        <div class="errorTxt4 msg-error"></div>
                        @error('password')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3 padding-right-input-password">
                        <label class="form-label">Confirm Password*</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                          class="form-control @error('password_confirmation') is-invalid @enderror"
                          placeholder="Enter Confirm Password" data-error=".errorTxt5">
                        <i id="0" class="fa fa-eye con_password" aria-hidden="true"></i>
                        <div class="errorTxt5 msg-error"></div>
                        @error('password_confirmation')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="col-lg-12" style="text-align:right">
                        <button class="save-btn hover-btn" type="button">Save Changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="overlay loading-content-save" style="display:none;">
                <i class="fa fa-spinner fa-spin"></i>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="overlay loading-content" style="display:none;">
        <i class="fa fa-spinner fa-spin"></i>
      </div>
    </div>
  </main>
  @if(\Session::has('success'))
  <script type="text/javascript">
    $(document).ready(function () {
      swal({
        title: '{!!\Session::get('success')!!}',
        text: "I will close in 2 seconds.",
        icon: 'success',
        timer: 2000,
        buttons: false
      });
    });
  </script>
  @endif
  @if(\Session::has('error'))
  <script type="text/javascript">
    $(document).ready(function () {
      swal({
        title: '{!!\Session::get('error')!!}',
        text: "I will close in 2 seconds.",
        icon: 'error',
        timer: 2000,
        buttons: false
      });
    });
  </script>
  @endif
  <script type="text/javascript">
    $(document).ready(function () {
      $('#nav-account').addClass('active');
    });
    //show/hide new password
    $(document).on("click", ".padding-right-input-password .new_password", function () {
      var show = $(this).attr('id');
      if (show == 0) {
        $(this).attr('id', 1);
        $(this).removeClass("fa fa-eye");
        $(this).addClass("fa fa-eye-slash");
        $('.padding-right-input-password #password').attr("type", "text");
      } else {
        $(this).attr('id', 0);
        $(this).removeClass("fa fa-eye-slash");
        $(this).addClass("fa fa-eye");
        $('.padding-right-input-password #password').attr("type", "password");
      }
    });
    //show/hide con password
    $(document).on("click", ".padding-right-input-password .con_password", function () {
      var show = $(this).attr('id');
      if (show == 0) {
        $(this).attr('id', 1);
        $(this).removeClass("fa fa-eye");
        $(this).addClass("fa fa-eye-slash");
        $('.padding-right-input-password #password_confirmation').attr("type", "text");
      } else {
        $(this).attr('id', 0);
        $(this).removeClass("fa fa-eye-slash");
        $(this).addClass("fa fa-eye");
        $('.padding-right-input-password #password_confirmation').attr("type", "password");
      }
    });
    $(document).on("click", ".save-btn", function () {
      $('.loading-content-save').fadeIn();
      setTimeout(RemoveClass, 500);
      $('form#formAccount').submit();
    });
    function RemoveClass() {
      $('.loading-content-save').fadeOut();
    }
  </script>
</x-app-layout>