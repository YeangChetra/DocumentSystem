<x-app-layout>
  <main>
    <div class="container-fluid">
      <h2 class="mt-30 page-title">Roles</h2>
      <ol class="breadcrumb mb-30">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        @canany('User access','User add','User edit','User delete')
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">User Accounts</a></li>
        @endcanany
        <li class="breadcrumb-item active h-title">Roles</li>
      </ol>
      <form class="formApply" id="formApply" method="post" action="{{ route('roles.destroy', 100) }}">
        {{csrf_field()}}
        @method('delete')
        <div class="row justify-content-between">
          @can('User create')
          <div class="col-lg-12" style="text-align:right;">
            <a href="{{route('roles.create')}}" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add
              New</a>
          </div>
          @endcan
          <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-30">
            <div class="bulk-section mb-30">
              @can('User delete')
              <div class="input-group">
                <select id="actions" name="actions" class="form-control">
                  <option selected value="">--Select Actions--</option>
                  <option value="delete">Delete</option>
                </select>
                <div class="input-group-append">
                  <button class="status-btn hover-btn" id="apply" type="button">Apply</button>
                </div>
              </div>
              @endcan
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-30">
            <div class="bulk-section text-left mb-30">
              <div class="search-by-name-input mr-0">
                <input type="text" id="text-search" class="form-control" placeholder="Search">
              </div>
              <button class="status-btn hover-btn" id="search" type="button">Search</button>
            </div>
          </div>
          <div class="col-lg-12 col-md-12" id="data-centent">
            <div class="card card-static-2 mb-30">
              <div class="card-title-2">
                <h4>All Roles</h4>
              </div>
              <div class="card-body-table">
                <div class="table-responsive">
                  <table class="table ucp-table table-hover">
                    <thead>
                      <tr>
                        <th style="width:60px"><input type="checkbox" class="form-control check-all"></th>
                        <th>Role_Name</th>
                        <th>Permisstions</th>
                        <th>Created</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($roles as $role)
                      <tr>
                        <td><input type="checkbox" class="form-control check-item" name="ids[]" value="{{$role->id}}">
                        </td>
                        <td>{{$role->name}}</td>
                        <td>
                          @foreach($role->permissions as $permission)
                          <span class="badge-item badge-status" style="margin-bottom: 5px;">{{ $permission->name
                            }}</span>
                          @endforeach
                        </td>
                        <td>{{ \Carbon\Carbon::parse($role->create_date)->format('d-M-y h:i A')}}</td>
                        <td class="action-btns">
                          @can('Role edit')
                          <a href="{{route('roles.edit',Crypt::encrypt($role->id))}}" class="edit-btn" title="Edit"
                            data-toggle="modal" data-target="#editModal"><i class="fas fa-edit edit"
                              id="{{Crypt::encrypt($role->id)}}">Edit</i></a>
                          @endcan
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="text-center" style="float: left;padding-top: 15px;padding-left: 5px;">
                  <p style="font-size: 14px;">Showing {{$roles->firstItem()}} to {{$roles->lastItem()}} of
                    {{$roles->total()}} entries</p>
                </div>
                <div class="text-center" style="float: right;padding-top: 5px;padding-right: 5px;">
                  <nav>
                    @if ($roles->lastPage() > 1)
                    <ul class="pagination">
                      <li class="page-item {{ ($roles->currentPage() == 1) ? ' disabled' : '' }}" aria-disabled="true"
                        aria-label="« Previous">
                        @if($roles->currentPage() == 1)
                        <span class="page-link" aria-hidden="true">Previous</span>
                        @else
                        <a class="page-link" href="{{ $roles->url(1) }}">Previous</a>
                        @endif
                      </li>
                      @for ($i = 1; $i <= $roles->lastPage(); $i++)
                        <?php
            $half_total_links = floor(7 / 2);
            $from = $roles->currentPage() - $half_total_links;
            $to = $roles->currentPage() + $half_total_links;
            if ($roles->currentPage() < $half_total_links) {
               $to += $half_total_links - $roles->currentPage();
            }
            if ($roles->lastPage() - $roles->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($roles->lastPage() - $roles->currentPage()) - 1;
            }
            ?>
                        @if ($from < $i && $i < $to) <li
                          class="page-item{{ ($roles->currentPage() == $i) ? ' active' : '' }}" aria-current="page">
                          @if($roles->currentPage() == $i)
                          <span class="page-link">{{ $i }}</span>
                          @else
                          <a class="page-link" href="{{ $roles->url($i) }}">{{ $i }}</a>
                          @endif
                          </li>
                          @endif
                          @endfor
                          <li class="page-item{{ ($roles->currentPage() == $roles->lastPage()) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $roles->url($roles->lastPage()) }}" rel="next"
                              aria-label="Next »">Next</a>
                          </li>
                    </ul>
                    @endif
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="overlay loading-content" style="display:none;">
        <i class="fa fa-spinner fa-spin"></i>
      </div>
    </div>

    <!--//modal add new-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Role</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="formRole" id="formRole" method="post" enctype="multipart/form-data"
            action="{{route('roles.store')}}">
            @csrf
            @method('post')
            <div class="modal-body">
              <div class="form-group">
                <label class="form-label">Role Name*</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                  class="form-control @error('name') is-invalid @enderror" placeholder="Enter Role Name"
                  data-error=".errorTxt1">
                <div class="errorTxt1 msg-error"></div>
                @if(!\Session::has('urlUpdateRole'))
                @error('name')
                <div class="msg-error">{{ $message }}</div>
                <script type="text/javascript">
                  $(document).ready(function () {
                    $('#addModal').modal('show');
                  });
                </script>
                @enderror
                @endif
              </div>

              <div class="form-group mb-3">
                <label class="form-label tl-color">Roles</label>
              </div>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" id="checkall" type="checkbox" />
                      <label class="custom-control-label" for="checkall">Full Control</label>
                    </div>
                  </div>
                </div>
                @foreach($permissions as $permission)
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                  <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                      <input class="cb-element custom-control-input" id="{{$permission->name}}" name="permissions[]"
                        type="checkbox" value="{{$permission->id}}" @if(old('permissions')) @foreach(old('permissions')
                        as $item) @if($item==$permission->id)
                      checked
                      @endif
                      @endforeach
                      @endif
                      />
                      <label class="custom-control-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-save">Save Change</button>
            </div>
          </form>
          <div class="overlay loading-content-save" style="display:none;">
            <i class="fa fa-spinner fa-spin"></i>
          </div>
        </div>
      </div>
    </div>

    <!--//modal edit-->
    <form class="formRoleUpdate" id="formRoleUpdate" method="post" enctype="multipart/form-data"
      action="{{ Session::has('urlUpdateRole') ? Session::get('urlUpdateRole') :'' }}">
      @csrf
      @method('put')
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Roles</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label class="form-label">Role Name*</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                  class="form-control @error('name') is-invalid @enderror" placeholder="Enter Role Name"
                  data-error=".errorTxt1">
                <div class="errorTxt1 msg-error"></div>
                @if(\Session::has('urlUpdateRole'))
                @error('name')
                <div class="msg-error">{{ $message }}</div>
                <script type="text/javascript">
                  $(document).ready(function () {
                    $('#editModal').modal('show');
                  });
                </script>
                @enderror
                @endif
              </div>

              <div class="form-group mb-3">
                <label class="form-label tl-color">Roles</label>
              </div>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" id="checkalls" type="checkbox" />
                      <label class="custom-control-label" for="checkalls">Full Control</label>
                    </div>
                  </div>
                </div>
                @foreach($permissions as $permission)
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                  <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                      <input class="cb-elements custom-control-input" id="{{$permission->id}}" name="permissions[]"
                        type="checkbox" value="{{$permission->id}}" @if(old('permissions')) @foreach(old('permissions')
                        as $item) @if($item==$permission->id)
                      checked
                      @endif
                      @endforeach
                      @endif
                      />
                      <label class="custom-control-label" for="{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-update">Update Change</button>
            </div>
            <div class="overlay loading-content-save" style="display:none;">
              <i class="fa fa-spinner fa-spin"></i>
            </div>
          </div>
        </div>
      </div>
    </form>
  </main>

  <!--//check checkbox checkall-->
  @if(old('permissions'))
  <script type="text/javascript">
    $(document).ready(function () {
      if ($('.cb-element:checked').length == $('.cb-element').length) {
        $('#checkall').prop('checked', true);
      }
    });
  </script>
  @endif
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

  @if(\Session::has('urlUpdateRole'))
  <script type="text/javascript">
    $(document).on("click", ".btn-update", function () {
      $(".loading-content-save").fadeIn();
      setTimeout(function () {
        $(".loading-content-save").fadeOut();
      }, 500);
      $("form#formRoleUpdate").submit();
    });
  </script>
  @endif

  @can('Role delete')
  <script type="text/javascript">
    //delete
    $(document).on("click", "#apply", function () {
      var ids = $.map($('input[name="ids[]"]:checked'), function (c) { return c.value; });
      var action = $('#actions').val();
      if (action == '' || ids == '')
        return;
      swal({
        title: "Are you sure?",
        text: 'You will ' + action + ' this items',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: 'No, Please!',
          delete: 'Yes, ' + action + ''
        }
      }).then(function (willDelete) {
        if (willDelete) {
          $('.loading-content').fadeIn();
          setTimeout(function () {
            $('.loading-content').fadeOut();
          }, 200);
          $('form#formApply').submit();
        } else {
          swal("Your items is safe", {
            title: 'Cancelled',
            icon: "error",
            timer: 2000,
            buttons: false
          });
        }
      });
    });
  </script>
  @endcan

  @can('Role access')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#nav-account').addClass('active');

      //check all permisstion modal add
      $('#checkall').change(function () {
        $('.cb-element').prop('checked', this.checked);
      });

      $('.cb-element').change(function () {
        if ($('.cb-element:checked').length == $('.cb-element').length) {
          $('#checkall').prop('checked', true);
        }
        else {
          $('#checkall').prop('checked', false);
        }
      });

    });

    //search
    $(document).on("click", "#search", function () {
      var text_search = $('#text-search').val();
      var url = "{{ route('roles.show', ':search') }}";
      url = url.replace(':search', text_search);
      $.ajax({
        url: url,
        method: 'get',
        data: {},
        dataType: 'json',
        success: function (data) {
          $('.loading-content').fadeIn();
          setTimeout(function () {
            $('.loading-content').fadeOut();
          }, 100);
          $('#data-centent').html(data);

          $('#search').attr('name', 'true');
          //alert(data);
        }
      });
    });

    //pagination click
    $(document).on("click", ".page-click", function () {
      var id = $(this).attr('id');
      var text_search = $('#text-search').val();
      var url = "{{ route('roles.show', ':search') }}";
      url = url.replace(':search', text_search);
      $.ajax({
        url: url + "?page=" + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
          $('.loading-content').fadeIn();
          setTimeout(function () {
            $('.loading-content').fadeOut();
          }, 500);
          $('#data-centent').html(data);
        }
      });
    });
  </script>
  @endcan

  @can('Role edit')
  <script type="text/javascript">
    $(document).on("click", ".edit-btn i.edit", function () {
      var id = $(this).attr('id');
      var url = "{{ route('roles.edit', ':id') }}";
      url = url.replace(':id', id);
      $.ajax({
        url: url,
        method: 'get',
        dataType: 'json',
        success: function (data) {
          $('#editModal').html(data);
        }
      });
    });
  </script>
  @endcan

  @can('Role create')
  <script type="text/javascript">
    //
    $(document).on("click", ".btn-save", function () {
      $('.loading-content-save').fadeIn();
      setTimeout(RemoveClass, 500);
      $('form#formRole').submit();
    });
    //
    function RemoveClass() {
      $('.loading-content-save').fadeOut();
    }
  </script>
  @endcan
</x-app-layout>