<x-app-layout>
  <main>
    <div class="container-fluid">
      <h2 class="mt-30 page-title">Positions</h2>
      <ol class="breadcrumb mb-30">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item">Setting</li>
        <li class="breadcrumb-item active h-title">Positions</li>
      </ol>
      <form class="formApply" id="formApply" method="post" action="{{ route('structures.destroy', 100) }}">
        {{csrf_field()}}
        @method('delete')
        <div class="row justify-content-between">
          @can('Structure create')
          <div class="col-lg-12" style="text-align:right;">
            <a href="{{route('structures.create')}}" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add New</a>
          </div>
          @endcan
          <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-30">
            <div class="bulk-section mb-30">
              @can('Structure delete')
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
                <h4>All Positions</h4>
              </div>
              <div class="card-body-table">
                <div class="table-responsive">
                  <table class="table ucp-table table-hover">
                    <thead>
                      <tr>
                        <th rowspan="2" style="width:60px">
                          <input type="checkbox" class="form-control check-all">
                        </th>
                        <th>Level</th>
                        <th>Position</th>
                        <th>Created</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($structures as $structure)
                      <tr>
                        <td><input type="checkbox" class="form-control check-item" name="ids[]" value="{{$structure->id}}">
                        </td>
                        <td>{{$structure->description}}</td>
                        <td>{{$structure->name}}</td>
                        <td>{{ \Carbon\Carbon::parse($structure->created_at)->format('d-M-y')}}</td>
                        <td class="action-btns">
                          @can('Structure edit')
                            <a href="{{route('structures.edit',Crypt::encrypt($structure->id))}}" class="edit-btn" title="Edit" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit edit"
                                id="{{Crypt::encrypt($structure->id)}}">Edit</i></a>
                          @endcan
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="text-center" style="float: left;padding-top: 15px;padding-left: 5px;">
                  <p style="font-size: 14px;">Showing {{$structures->firstItem()}} to {{$structures->lastItem()}} of
                    {{$structures->total()}} entries</p>
                </div>
                <div class="text-center" style="float: right;padding-top: 5px;padding-right: 5px;">
                  <nav>
                    @if ($structures->lastPage() > 1)
                    <ul class="pagination">
                      <li class="page-item {{ ($structures->currentPage() == 1) ? ' disabled' : '' }}" aria-disabled="true"
                        aria-label="« Previous">
                        @if($structures->currentPage() == 1)
                        <span class="page-link" aria-hidden="true">Previous</span>
                        @else
                        <a class="page-link" href="{{ $structures->url(1) }}">Previous</a>
                        @endif
                      </li>
                      @for ($i = 1; $i <= $structures->lastPage(); $i++)
                        <?php
                          $half_total_links = floor(7 / 2);
                          $from = $structures->currentPage() - $half_total_links;
                          $to = $structures->currentPage() + $half_total_links;
                          if ($structures->currentPage() < $half_total_links) {
                            $to += $half_total_links - $structures->currentPage();
                          }
                          if ($structures->lastPage() - $structures->currentPage() < $half_total_links) {
                              $from -= $half_total_links - ($structures->lastPage() - $structures->currentPage()) - 1;
                          }
                        ?>
                        @if ($from < $i && $i < $to) <li
                          class="page-item{{ ($structures->currentPage() == $i) ? ' active' : '' }}" aria-current="page">
                          @if($structures->currentPage() == $i)
                          <span class="page-link">{{ $i }}</span>
                          @else
                          <a class="page-link" href="{{ $structures->url($i) }}">{{ $i }}</a>
                          @endif
                          </li>
                          @endif
                          @endfor
                          <li class="page-item{{ ($structures->currentPage() == $structures->lastPage()) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $structures->url($structures->lastPage()) }}" rel="next"
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
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Positions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="formStructure" id="formStructure" method="post" action="{{route('structures.store')}}">
            @csrf
            @method('post')
            <div class="modal-body">
              <div class="form-group">
                <label class="form-label">Position in English *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Position in English"
                  data-error=".errorTxt1">
                <div class="errorTxt1 msg-error"></div>
                @if(!\Session::has('urlUpdateStructure'))
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
              <div class="form-group">
                <label class="form-label">Position in Khmer *</label>
                <input type="text" id="secondary_name" name="secondary_name" value="{{ old('secondary_name') }}" class="form-control @error('secondary_name') is-invalid @enderror" placeholder="Enter Position in English"
                  data-error=".errorTxt1">
                <div class="errorTxt1 msg-error"></div>
                @if(!\Session::has('urlUpdateStructure'))
                  @error('secondary_name')
                    <div class="msg-error">{{ $message }}</div>
                    <script type="text/javascript">
                      $(document).ready(function () {
                        $('#addModal').modal('show');
                      });
                    </script>
                  @enderror
                @endif
              </div>
                <div class="form-group">
                <label class="form-label">Level *</label>
                  <select class="form-control" id="level_id" class="form-control" data-error=".errorTxt1"  name="department_id">
                    @foreach($levelprefix as $item)
                      <option value="{{Crypt::encrypt($item->id)}}">{{$item->description}}</option>';
                    @endforeach
                  </select>
                  @error('level_add')
                    <div class="msg-error">{{ $message }}</div>
                    <script type="text/javascript">
                      $(document).ready(function () {
                        $('#addModal').modal('show');
                      });
                    </script>
                  @enderror
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
    <form class="formPositionsUpdate" id="formPositionsUpdate" method="post" action="{{ Session::has('urlUpdateStructure') ? Session::get('urlUpdateStructure') :'' }}">
      @csrf
      @method('put')
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Position</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>            
            <div class="modal-body">
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


  <script type="text/javascript">
    $(document).ready(function () {
      if ($('.cb-element:checked').length == $('.cb-element').length) {
        $('#checkall').prop('checked', true);
      }
    });
   </script>
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

  @if(\Session::has('urlUpdateStructure'))
    <script type="text/javascript">
      $(document).on("click", ".btn-update", function () {
        $(".loading-content-save").fadeIn();
        setTimeout(function () {
          $(".loading-content-save").fadeOut();
        }, 500);
        $("form#formPositionsUpdate").submit();
      });
    </script>
  @endif

  @can('Structure delete')
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

  @can('Structure access')
    <script type="text/javascript">
      $(document).ready(function () {
        $('#nav-setting').addClass('active');

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

      });;

      //search
      $(document).on("click", "#search", function () {
        var text_search = $('#text-search').val();
        var url = "{{ route('permissions.search_permission', ':search') }}";
        url = url.replace(':search', text_search);
        alert(url);
        $.ajax({
          url: url,
          method: 'get',
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
        var url = "{{ route('permissions.search_permission', ':search') }}";
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

  @can('Structure edit')
    <script type="text/javascript">
      $(document).on("click", ".edit-btn i.edit", function () {
        var id = $(this).attr('id');
        var url = "{{ route('structures.edit', ':id') }}";
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

  @can('Structure create')
    <script type="text/javascript">
      //
      $(document).on("click", ".btn-save", function () {
        $('.loading-content-save').fadeIn();
        setTimeout(RemoveClass, 500);
        $('form#formStructure').submit();
      });
      //
      function RemoveClass() {
        $('.loading-content-save').fadeOut();
      }
    </script>
  @endcan
</x-app-layout>