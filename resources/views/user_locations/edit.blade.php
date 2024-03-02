<x-app-layout>
  <main>
    <div class="container-fluid">
      <h2 class="mt-30 page-title">Edit User Account</h2>
      <ol class="breadcrumb mb-30">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">User Accounts</a></li>
        <li class="breadcrumb-item active">Edit User Account</li>
      </ol>
      <div class="row">
        <div class="col-lg-4 col-md-5">
          <div class="card card-static-2 mb-30">
            <div class="card-body-table">
              <div class="shopowner-content-left text-center pd-20">
                <div class="customer_img">
                  @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                  <img style="" src="{{ $admin?$admin->profile_photo_url : '' }}"
                    alt="{{ $admin ? $admin->name : '' }}">
                  @else
                  <i style="color: #f55d2c;">{{ $admin ? $admin->name : ''}}</i>
                  @endif
                </div>
                <div class="shopowner-dt-left mt-4">
                  <h4>{{$admin->name}}</h4>
                  <span>{{$admin->roles->pluck('name')->first()}}</span>
                </div>
                <div class="shopowner-dts">
                  <div class="shopowner-dt-list">
                    <span class="left-dt">Username</span>
                    <span class="right-dt">{{$admin->name}} </span>
                  </div>
                  <div class="shopowner-dt-list">
                    <span class="left-dt">Location</span>
                    <span class="right-dt">{{$admin->name}}, {{$admin->name}} </span>
                  </div>
                  <div class="shopowner-dt-list">
                    <span class="left-dt">Phone</span>
                    <span class="right-dt">{{$admin->phone}}</span>
                  </div>
                  <div class="shopowner-dt-list">
                    <span class="left-dt">Created</span>
                    <span class="right-dt">{{ \Carbon\Carbon::parse($admin->create_date)->format('d-M-y h:i A')}}</span>
                  </div>
                  @if($admin->status)
                  <div class="shopowner-dt-list">
                    <span class="left-dt">Status</span>
                    <span class="right-dt badge-item badge-status"
                      style="text-align: center;color: white;">Active</span>
                  </div>
                  @else
                  <div class="shopowner-dt-list">
                    <span class="left-dt">Status</span>
                    <span class="right-dt badge-item badge-status"
                      style="text-align: center;color: white;">Inactive</span>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-md-7">
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>Edit Profile</h4>
            </div>
            <form class="formAccountEdit" id="formAccountEdit" method="post" enctype="multipart/form-data"
              action="{{ route('users.update',Crypt::encrypt($admin->id))}}">
              @csrf
              @method('put')
              <div class="card-body-table">
                <input type="text" name="id" id="id" hidden="true" value="$admin->id}}">
                <div class="news-content-right pd-20">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Personal Information</label>
                      </div>      
                      <!-- <div class="form-group mb-3">
                        <label class="form-label">Profile Image(Optional)</label>
                        <input type="file" name="photo" class="dropify" data-height="230" accept="image/*"
                          data-type='image' data-error=".errorTxt6" />
                        <div class="errorTxt6 msg-error"></div>
                      </div> -->
                      <div class="form-group mb-3">
                        <label class="form-label">Full Name*</label>
                        <input type="text" id="name" name="name" value="{{ old('name') ? old('name') : $admin->name }}"
                          class="form-control @error('name') is-invalid @enderror" placeholder="Enter Full Name"
                          data-error=".errorTxt1">
                        <div class="errorTxt1 msg-error"></div>
                        @error('name')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Phone*</label>
                        <input type="number" id="phone" name="phone"
                          value="{{ old('phone') ? old('phone') : $admin->phone }}"
                          class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Phone Number"
                          data-error=".errorTxt2">
                        <div class="errorTxt2 msg-error"></div>
                        @error('phone')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">User Account</label>
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Email*</label>
                        <input type="text" id="email" name="email"
                          value="{{ old('email') ? old('email') : $admin->email }}"
                          class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email"
                          data-error=".errorTxt3">
                        <div class="errorTxt3 msg-error"></div>
                        @error('email')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3 padding-right-input-password">
                        <label class="form-label">New Password(Optional)</label>
                        <input type="password" id="password" name="password"
                          class="form-control @error('password') is-invalid @enderror" placeholder="Enter New Password"
                          data-error=".errorTxt4">
                        <i id="0" class="fa fa-eye new_password" aria-hidden="true"></i>
                        <div class="errorTxt4 msg-error"></div>
                        @error('password')
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
                                value="{{$role->id}}" @if(count($admin->roles->where('id',$role->id)))
                              checked
                              @endif
                              />
                              <label class="custom-control-label" for="{{$role->name}}">{{ $role->name }}</label>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </div>
                      @if(\Session::get('role') == "Administrator")
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Permission</label>
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Role*</label>
                        <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                          <option value="admin">Admin</option>
                          <option selected value="writer">Writer</option>
                        </select>
                        @if(old('role'))
                        <script type="text/javascript">
                          $(document).ready(function () {
                            $('#role').val("{{old('role')}}");
                          });
                        </script>
                        @else
                        <script type="text/javascript">
                          $(document).ready(function () {
                            $('#role').val("{{$admin->roles}}");
                          });
                        </script>
                        @endif
                        @error('role')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Locations*</label>
                        <select id="location" name="location"
                          class="form-control @error('location') is-invalid @enderror">
                          @foreach($data['area'] as $list)
                          <option value="{{$list->areaid}}">{{$list->area}}, {{$list->location}}</option>
                          @endforeach
                        </select>
                        @if(old('location'))
                        <script type="text/javascript">
                          $(document).ready(function () {
                            $('#location').val("{{old('location')}}");
                          });
                        </script>
                        @else
                        <script type="text/javascript">
                          $(document).ready(function () {
                            $('#location').val("{{$data['account']->areaid}}");
                          });
                        </script>
                        @endif
                        @error('role')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      @endif
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
        <div class="overlay loading-content" style="display:none;">
          <i class="fa fa-spinner fa-spin"></i>
        </div>
      </div>
  </main>
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
    //
    $(document).on("click", ".save-btn", function () {
      $('.loading-content-save').fadeIn();
      setTimeout(RemoveClass, 500);
      $('form#formAccountEdit').submit();
    });
    function RemoveClass() {
      $('.loading-content-save').fadeOut();
    }
  </script>
</x-app-layout>