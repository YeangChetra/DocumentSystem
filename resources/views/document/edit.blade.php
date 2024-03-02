<x-app-layout>
  <main>
    <div class="container-fluid">
      <h2 class="mt-30 page-title">Edit Document</h2>
      <ol class="breadcrumb mb-30">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item">Document</li>
        <li class="breadcrumb-item active">Edit Document</li>
      </ol>
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>Attach file</h4>
            </div>
            <form class="formDocument" id="formDocument" method="post" enctype="multipart/form-data"
              action="{{ route('documents.store')}}">
              {{csrf_field()}}
              @method('post')
              <input type="hidden" name="id" value="{{Crypt::encrypt($data->id)}}">
              <input type="hidden" name="type" value="{{Crypt::encrypt($data->type)}}">

              <div class="card-body-table">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <ul class="list-group">                  
                    @foreach($files as $key => $items) 
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="badge badge-primary badge-pill">
                          @if($items->file_type == 'pdf')
                            <img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/pdf.svg" width="30" heigth="50" alt="icon">
                          @elseif($items->file_type == 'png')
                            <img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/png.svg" width="30" heigth="50" alt="icon">
                          @elseif($items->file_type == 'jpg')
                            <img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/jpg.svg" width="30" heigth="50" alt="icon">
                          @endif
                        </span>
                        {{$items->displaytitle}}
                        <span class="badge badge-warming badge-pill">
                          <a href="{{asset('storage/'.$items->filename)}}" class="show-btn text-primary" title="show" target="_blank"> <i class="fas fa-eye"></i> </a>
                          <a href="{{route('documents.delete_document',Crypt::encrypt($items->id))}}" class="show-btn text-danger" title="delete"> <i class="fas fa-trash"></i>  </a>
                        </span>
                      </li>
                    @endforeach
                  </ul>
                </div>  
                <div class="col-lg-12 col-md-12 col-sm-12">             
                  <div class="mb-3 mt-3">
                    <input id="input-ficons" class="mb-3" name="inputfile[]" multiple type="file">
                  </div>
                </div>              
              </div>
            </form>
          </div>
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>User has Permissions List</h4>
            </div>
            <form class="formDocument" id="formDocument" method="post" enctype="multipart/form-data"
              action="{{ route('documents.store')}}">
              {{csrf_field()}}
              @method('post')
              <input type="hidden" name="id" value="{{Crypt::encrypt($data->id)}}">
              <input type="hidden" name="type" value="{{Crypt::encrypt($data->type)}}">
              <div class="card-body-table">
                <div class="news-content-right pd-20">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                    </div>
                  </div>
                  <div class="col-lg-12" style="text-align:right">
                    <button class="save-btn hover-btn" type="button">Save Changes</button>
                  </div>
                </div>                
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>Document Information</h4>
            </div>
            <form class="formDocument" id="formDocument" method="post" enctype="multipart/form-data"
              action="{{ route('documents.store')}}">
              {{csrf_field()}}
              @method('post')
              <input type="hidden" name="id" value="{{Crypt::encrypt($data->id)}}">
              <input type="hidden" name="type" value="{{Crypt::encrypt($data->type)}}">
              <div class="card-body-table">
                <div class="news-content-right pd-20">
                  <div class="row">
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
                  </div>
                  <div class="col-lg-12" style="text-align:right">
                    <button class="save-btn hover-btn" type="button">Save Changes</button>
                  </div>
                </div>                
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
      $('#nav-document').addClass('active');
    });
    const myArray = {!!$files!!};

    // $(document).ready(function() {
    //   var $el1 = $("#input-ficons-5");
    //   $el1.fileinput({
    //     allowedFileExtensions: ['pdf','jpg', 'png', 'gif'],
    //     uploadUrl: "#",
    //     uploadAsync: false,
    //     deleteUrl: "/site/file-delete",
    //     showUpload: false, // hide upload button
    //     showDelete: !0,
    //     overwriteInitial: false, // append files to initial preview
    //     minFileCount: 1,
    //     maxFileCount: 5,
    //     browseOnZoneClick: true,
    //     initialPreviewAsData: true,
    //   }).on("filebatchselected", function(event, files) {
    //       // $el1.fileinput("upload");
    //   });
    // });
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
    $('select#department').change(function(){
      var me = $(this),
                id = me.val();
            var position_obj = $('#position_id');
            var position_id = $('#hidden_position_id').val();
            getPositionByDepartment(id, position_id, position_obj);
    }).trigger('change');

    function getPositionByDepartment(id, position_id, position_obj)
    {
        var url = "{{ route('structures.select_position', ':id') }}";
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
  </script>
</x-app-layout>