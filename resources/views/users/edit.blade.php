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
              action="{{ route('users.update', Crypt::encrypt($admin->id)) }}">
              @csrf
              @method('put')
              <div class="card-body-table">
                <input type="text" name="id" id="id" hidden="true" value="{{$admin->id}}">
                <div class="news-content-right pd-20">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Personal Information</label>
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">English Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') ? old('name') : $admin->name }}"
                          class="form-control @error('name') is-invalid @enderror" placeholder="Enter English Name"
                          data-error=".errorTxt1">
                        <div class="errorTxt1 msg-error"></div>
                        @error('name')
                        <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Khmer Name *</label>
                        <input type="text" id="secondary_name" name="secondary_name" value="{{ old('secondary_name') ? old('secondary_name') : $admin->secondary_name }}"
                          class="form-control @error('secondary_name') is-invalid @enderror" placeholder="Enter Khmer Name"
                          data-error=".errorTxt1">
                        <div class="errorTxt1 msg-error"></div>
                        @error('secondary_name')
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
                    <div class="col-lg-6 col-md-6 col-sm-12">
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
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Roles</label>
                      </div>
                      <div class="row">
                        @foreach($roles as $role)
                        <div class="col-lg-3 col-md-3 col-sm-12 col-3">
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
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                      <label class="form-label tl-color">User Level</label>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <div class="form-group mb-3">
                        <label class="form-label">Level *</label>
                        <select class="form-control" id="levelprefixid"  value="{{ old('levelprefixid') }}"
                          class="form-control @error('levelprefixid') is-invalid @enderror" name="levelprefixid"
                          data-error=".errorTxt1">
                          @foreach($levelprefix as $levelprefixs)
                            <option value="{{Crypt::encrypt($levelprefixs->id)}}" @if($levelprefixs->id == $admin->levelprefixid) selected="selected" @endif>{{$levelprefixs->description}}</option>
                          @endforeach                        
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('levelprefixid')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <div class="form-group mb-3">
                        <label class="form-label">Department *</label>
                        <select class="form-control" id="levelid"  value="{{$admin->levelid}}"
                          class="form-control @error('levelid') is-invalid @enderror" name="levelid" data-error=".errorTxt1">
                          <input type="hidden" id="hidden_levelid" value="{{$admin->levelid}}">
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('levelid')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                      <div class="form-group mb-3">
                        <label class="form-label">Positions *</label>
                        <select class="form-control" id="position_id"  value="{{ old('position_id') }}" name="position_id"
                          class="form-control @error('position_id') is-invalid @enderror" data-error=".errorTxt1">
                          <option value="">Select Option</option>            
                          <input type="hidden" id="hidden_position_id" value="{{$admin->position_id}}">                
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('position_id')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="overlay loading-content" style="display:none;">
                      <i class="fa fa-spinner fa-spin"></i>
                    </div>
                  </div>
                  <div class="col-lg-12" style="text-align:right">
                    <button class="save-btn hover-btn" type="button">Save Changes</button>
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
    $('select#levelprefixid').change(function(){
      var me = $(this),
                id = me.val();
            var department_obj = $('#levelid');
            var department_id = $('#hidden_levelid').val();
            getdepartmentByLevel(id, department_id, department_obj);
            
        var position_obj = $('#position_id');
        var position_id = $('#hidden_position_id').val();
        getpositionByDepartment(id, position_id, position_obj);
    }).trigger('change');

    function getdepartmentByLevel(id, department_id, department_obj)
    {
        var url = "{{ route('structures.select_level', ':id') }}";
            url = url.replace(':id', id);
        $.ajax({
            url:url,
            type: 'GET',
            dataType : 'JSON',
            beforeSend: function() {
                department_obj.html(("<option value='' selected='selected'>loading ...</option>"));
            },
            success:function(data){
                var label = "Select Option";
                department_obj.html('');
                department_obj.append('<option value="">'+label+'</option>');
                $.each(data, function(index,value){
                    $selected = '';
                    if(index == department_id)
                    {
                      $selected = ' selected = "selected"';
                    }
                    department_obj.append('<option '+$selected+' data-code="' + index + '" value="' + index + '">' + value + '</option>');
                });
            }
            
        });
    }

    
    function getpositionByDepartment(id, position_id, position_obj)
    {
        var url = '{{ route("structures.select_position", ":id") }}';
            url = url.replace(':id', id);
        $.ajax({
          url:url,
          type: 'GET',
          dataType : 'JSON',
          beforeSend: function() {
              position_obj.html("<option value='' selected='selected'>loading ...</option>");
          },
          success:function(data){
            var label = "Select Option";
            position_obj.html('');
            position_obj.append('<option value="">'+label+'</option>');
            $.each(data, function(index,value){
                $selected = '';
                if(index == position_id)
                {
                  $selected = ' selected = "selected"';
                }
                position_obj.append('<option '+$selected+' data-code="' + index + '" value="' + index + '">' + value + '</option>');
            });
          }            
        });
    }
  </script>
</x-app-layout>
<!-- 
Rice Crop
Horticulture and Subsidiary Crop
Industrial Crop
Plant Protection, sanitary and Phytosanitary  
Agricultural land Resources management
Agricultural Engineering
Agricultural Cooperative
Crop Seed

•	General Directorate
Director General
Deputy Director
•	Department
Director
Deputy Director
•	Office | Agricultural Stations/Farm ស្ថានិយ/កសិដ្ឋាន
Chief
Vice-chief

-->