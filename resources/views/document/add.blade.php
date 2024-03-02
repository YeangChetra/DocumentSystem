<x-app-layout>
  <!-- <link rel="stylesheet" href="{{asset('app-assets/vendor/fileinput/fileinput.min.css')}}"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
  <main>
    <div class="container-fluid">
      <h2 class="mt-30 page-title">Add Document</h2>
      <ol class="breadcrumb mb-30">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item">Document</li>
        <li class="breadcrumb-item active">Add Document</li>
      </ol>
      <div class="row">
        <div class="col-lg-12 col-md-12" style="margin:auto;">
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>Add Document</h4>
            </div>
            <form class="formDocument" id="formDocument" method="post" enctype="multipart/form-data"
              action="{{ route('documents.store')}}">
              {{csrf_field()}}
              <!-- @method('post') -->
              <input type="hidden" name="type" value="{{Crypt::encrypt($type)}}">
              <div class="card-body-table">
                <div class="news-content-right pd-20">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Document Information</label>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                          <div class="form-group mb-3">
                            <label class="form-label">Document No *</label>
                            <input type="text" id="document_no" name="document_no" value="{{ old('document_no') }}"
                              class="form-control @error('document_no') is-invalid @enderror" placeholder="12023/610 កសក.នផ"
                              data-error=".errorTxt2">
                            <div class="errorTxt2 msg-error"></div>
                            @error('document_no')
                            <div class="msg-error">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                          <div class="form-group mb-3">
                            <label class="form-label">Document Date*</label>
                            <input type="text" id="document_date" name="document_date" value="{{ old('document_date') }}"
                              class="form-control @error('document_date') is-invalid @enderror" placeholder="12-12-2023"
                              data-error=".errorTxt3">
                            <div class="errorTxt3 msg-error"></div>
                            @error('document_date')
                              <div class="msg-error">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                          <div class="form-group mb-3">
                            <label class="form-label">Document From *</label>
                            <input type="text" id="document_of" name="document_of" value="{{ old('document_of') }}"
                              class="form-control @error('document_of') is-invalid @enderror"  placeholder="MAFF - ក្រសួងកសិកម្ម រុក្ខាប្រមាញ់ និងនេសាទ"
                              data-error=".errorTxt3">
                            <div class="errorTxt3 msg-error"></div>
                            @error('document_of')
                              <div class="msg-error">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="form-group mb-3">
                            <label class="form-label">Description *</label>
                            <textarea id="document_descriptions" name="document_descriptions" class="form-control @error('document_descriptions') is-invalid @enderror" data-error=".errorTxt3" placeholder="Describe here..."></textarea>
                            <div class="errorTxt3 msg-error"></div>
                            @error('document_descriptions')
                              <div class="msg-error">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">    
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">Attach file</label>
                      </div>                  
                      <div class="file-loading mb-3" >
                        <input id="input-ficons-5" class="mb-3" name="inputfile[]" multiple type="file">
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group mb-3 mt-3">
                        <label class="form-label tl-color">User Permissions</label>
                      </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group mb-3">
                        <label class="form-label">Level *</label>
                        <select class="form-control" id="levelprefixs"  value="{{ Crypt::encrypt(old('levelprefixs')) }}"
                          class="form-control @error('levelprefixs') is-invalid @enderror" name="levelprefixid"
                          data-error=".errorTxt1">
                          @foreach($levelPrefix as $levelprefixs)
                            <option value="{{Crypt::encrypt($levelprefixs->id)}}">{{$levelprefixs->description}}</option>
                          @endforeach                        
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('levelprefixs')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group mb-3">
                        <label class="form-label">Department *</label>
                        <select class="form-control" id="department"  value="{{ Crypt::encrypt(old('department')) }}"
                          class="form-control @error('department') is-invalid @enderror" name="levelid"
                          data-error=".errorTxt1">
                          <option value="">Select Option</option>                          
                          <input type="hidden" id="hidden_department" value="{{Crypt::encrypt(old('levelid'))}}">                       
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('name')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                      <div class="form-group mb-3">
                        <label class="form-label">Positions *</label>
                        <select class="form-control" id="position_id"  value="{{ old('position_id') }}" name="position_id"
                          class="form-control @error('position_id') is-invalid @enderror"
                          data-error=".errorTxt1">
                          <option value="">Select Option</option>                          
                          <input type="hidden" id="hidden_position_id" value="{{old('position_id')}}">                
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('position_id')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2">
                      <div class="form-group mb-3">
                        <label class="form-label">User *</label>
                        <select class="form-control" id="user_id"  value="{{ old('user_id') }}"
                          class="form-control @error('user_id') is-invalid @enderror" name="user_id"
                          data-error=".errorTxt1">
                          <option value="">Select Option</option>                          
                          <input type="hidden" id="hidden_user_id" value="{{old('user_id')}}">                      
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('user_id')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2">
                      <div class="form-group mb-3">
                        <label class="form-label">Permission *</label>
                        <select class="form-control" id="permission_type"  value="{{ old('permission_type') }}"
                          class="form-control @error('permission_type') is-invalid @enderror" name="permission_type"
                          data-error=".errorTxt1">
                          <option value="">Select Option</option>     
                          <option value="1">Command</option>     
                          <option value="2">Approval</option>                       
                          <input type="hidden" id="hidden_permission_type" value="{{old('permission_type')}}">    
                        </select>
                        <div class="errorTxt1 msg-error"></div>
                        @error('permission_type')
                          <div class="msg-error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">      
                        <button 
                            type="button" 
                            id="add-location" 
                            class="btn btn-info pull-right" 
                            name="village">
                                Add User
                        </button>
                    </div>                    
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group mb-3">
                        <label class="form-label tl-color">User has Permissions List</label>
                      </div>
                      <div class="card-body-table">
                        <div class="table-responsive">
                          <table class="table ucp-table table-hover table-location">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Department</th>
                                    <th>Positions</th>
                                    <th>User Name</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
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
      </div>
  </main>
  <!-- <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>
  <script src="{{asset('app-assets/vendor/fileinput/piexif.min.js')}}"></script>
  <script src="{{asset('app-assets/vendor/fileinput/sortable.min.js')}}"></script>
  <script src="{{asset('app-assets/vendor/fileinput/purify.min.js')}}"></script>
  <script src="{{asset('app-assets/vendor/fileinput/fileinput.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/LANG.js"></script> -->

<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/LANG.js"></script>
  
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
        var level = 'All',
            department = 'All',
            position = 'All',
            user = 'All',
            permission_type = 'All',
            level_id = 0,
            department_id = 0,
            position_id = 0,
            user_id = 0,
            permission_type_id = 0;
    $(document).ready(function() {
      var $el1 = $("#input-ficons-5");
      $el1.fileinput({
        allowedFileExtensions: ['pdf','jpg', 'png', 'gif'],
        uploadUrl: "#",
        uploadAsync: false,
        deleteUrl: "/site/file-delete",
        showUpload: false, // hide upload button
        showDelete: !0,
        overwriteInitial: false, // append files to initial preview
        minFileCount: 1,
        maxFileCount: 5,
        browseOnZoneClick: true,
        initialPreviewAsData: true,
      }).on("filebatchselected", function(event, files) {
          // $el1.fileinput("upload");
      });
    });
    $(document).ready(function () {
      $('#nav-document').addClass('active');

      
      // $("#input-ficons-5").fileinput({
      //   uploadUrl: "/file-upload-batch/2",
      //   uploadAsync: true,
      //   showUpload: false, // hide upload button
      //   deleteUrl: "/site/file-delete",
      //   overwriteInitial: false, // append files to initial preview
      //   minFileCount: 1,
      //   maxFileCount: 5,
      //   browseOnZoneClick: true,
      //   initialPreviewAsData: true,
      // });
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
      $('form#formDocument').submit();
    });

    function RemoveClass() {
      $('.loading-content-save').fadeOut();
    }

            // add locations
    $("#add-location").on("click", function () {
      var error = [];
      
      level_id = $('#levelprefixs option:selected').val();
      level= $('#levelprefixs option:selected').text();

      department_id = $('#department option:selected').val();
      department= $('#department option:selected').text();
      
      position = $('#position_id option:selected').text();
      position_id = $('#position_id option:selected').val();
      
      user = $('#user_id option:selected').text();
      user_id = $('#user_id option:selected').val();
      
      permission_type = $('#permission_type option:selected').text();
      permission_type_id = $('#permission_type option:selected').val();

      if(department_id == 0){
        swal({
          title: 'Please Select the Level options',
          text: "I will close in 2 seconds.",
          icon: 'error',
          timer: 2000,
          buttons: false
        });
        return false;
      }
      if(position_id == 0){
        swal({
          title: 'Please Select the Position options',
          text: "I will close in 2 seconds.",
          icon: 'error',
          timer: 2000,
          buttons: false
        });
        return false;
      }
      if(user_id == 0){
        swal({
          title: 'Please Select the User',
          text: "I will close in 2 seconds.",
          icon: 'error',
          timer: 2000,
          buttons: false
        });
        return false;
      }
      if(permission_type == 0){
        swal({
          title: 'Please Select the Permission type',
          text: "I will close in 2 seconds.",
          icon: 'error',
          timer: 2000,
          buttons: false
        });
        return false;
      }

      counter = $('.table-location tbody tr').length - 2;
      id = $('.table-location tbody tr').length + 1;
      var newRow = $(".table-location");
      var cols = "";
      cols += '<tr><td><input type="hidden"'+ "value="+'"'+level_id+'"'+">" + level + '</td>';
      cols += '<td><input type="hidden"'+ "value="+'"'+department_id+'"'+">" + department + '</td>';
      cols += '<td><input type="hidden"'+ "value="+'"'+position_id+'"'+">"+ position + '</td>';
      cols += '<td><input type="hidden" name="document_has_commands['+id+'][user_id]"'+ "value="+'"'+user_id+'"'+">" + user + '</td>';
      cols += '<td><input type="hidden" name="document_has_commands['+id+'][permission_type]"'+ "value="+'"'+permission_type_id+'"'+">" + permission_type + '</td>';
      cols += '<td><button class="delete-btn btn"><i class="fa fa-trash"></i></button></td></tr>';
      newRow.append(cols);
    });
    // btn delete
    $(document).on('click', 'button.delete-btn', function () {
        $(this).closest('tr').remove();
        return false;
    });

    $('select#levelprefixs').change(function(){
      var me = $(this),
                id = me.val();
            var department_obj = $('#department');
            var department_id = $('#hidden_department').val();
            getdepartmentByLevel(id, department_id, department_obj);
            
            var position_obj = $('#position_id');
            var position_id_id = $('#hidden_position_id').val();
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
                position_obj.html(("<option value='' selected='selected'>loading ...</option>"));
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

    $('select#position_id').change(function(){
      var me = $(this),
                id = me.val();
                if(id==""){id = 'nullable';}
                
            var position_obj = $('#user_id');
            var user_id = $('#hidden_user_id').val();
            getUserByPosition(id, user_id, position_obj);
    }).trigger('change');

    function getUserByPosition(id, user_id, position_obj)
    {
        var url = "{{ route('users.get_user', ':id') }}";
            url = url.replace(':id', id);
        $.ajax({
            url:url,
            type: 'GET',
            dataType : 'JSON',
            beforeSend: function() {
                position_obj.html(("<option value='' selected='selected'>loading ...</option>"));
            },
            success:function(data){
                var label = "Select Option";
                position_obj.html('');
                position_obj.append('<option value="">'+label+'</option>');
                $.each(data, function(index,value){
                    $selected = '';
                    if(index == user_id)
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