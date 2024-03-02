<x-app-layout>
    <main>
        <form class="formApply" id="formApply" method="post" action="{{ route('users.destroy', 100) }}">
        @csrf
        @method('delete')
        <div class="container-fluid">
            <h2 class="mt-30 page-title">User Account</h2>
            <ol class="breadcrumb mb-30">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">User Accounts</li>
            </ol>
            <div class="row justify-content-between">
                @can('User create')
                    <div class="col-lg-12" style="text-align:right;">
                        <a href="{{route('users.create')}}" class="btn btn-primary">Add New</a>
                    </div>
                @endcan
                <div class="col-lg-3 col-md-4">
                    <div class="bulk-section mt-30">
                        @can('User delete')
                            <div class="input-group">
                                <select id="actions" name="actions" class="form-control">
                                    <option selected value="">--Select Actions--</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="status-btn hover-btn" id="apply" type="button">Apply</button>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="bulk-section mt-30">
                        <div class="search-by-name-input">
                            <input type="text" class="form-control" id="text-search" placeholder="Search">
                        </div>
                        <div class="input-group">
                            <select id="user-action" name="user-action" class="form-control">
                                <option selected value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="input-group-append">
                                <button class="status-btn hover-btn" id="search" name="false" type="button">Search Account</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12" id="data-centent">
                    <div class="card card-static-2 mt-30 mb-30">
                        <div class="card-title-2" style="padding-top: 5px;padding-bottom: 5px;">
                            <h4>All UserAccounts</h4>
                            <div class="col-lg-3 col-md-4 col-sm-4">
                                <div class="input-group">
                                    <label style="margin-top:auto;margin-bottom: auto;padding-right: 5px;font-size: 14px;">Show</label>
                                    <select id="showing" name="showing" class="form-control">
                                        <option selected value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="all">all</option>
                                    </select>
                                    <label style="margin-top:auto;margin-bottom: auto;padding-left: 5px;font-size: 14px;">entries</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body-table">
                            <div class="table-responsive">
                                <table class="table ucp-table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:60px"><input type="checkbox" class="form-control check-all"></th>
                                            <th style="width:100px">Profile</th>
                                            <th>Full Name</th>
                                            <th>Position</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $list)
                                            @if(Auth::user()->id != $list->id)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-control check-item" id="ids" name="ids[]" value="{{$list->id}}">
                                                    </td>
                                                    <td>
                                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                            <img style="width: 35px;height: 35px;border-radius: 50%;border: 1px #45bbe0 solid;" src="{{ $list? asset($list->profile_photo_url) : '' }}" alt="{{ $list ? $list->name : '' }}">
                                                        @else
                                                            <i style="padding-left:2px;padding-right: 2px;color: #f55d2c;">{{ $list ? $list->name : ''}}</i>
                                                        @endif
                                                    </td>
                                                    <td>{{$list->name}}</td>
                                                    <td>{{$list->positions_en}}</td>
                                                    <td>{{$list->email}}</td>
                                                    <td>{{$list->phone}}</td>
                                                    <td>
                                                        @foreach($list->roles as $role)
                                                            <span class="badge-item badge-status" style="background-color: darkblue;">{{ $role->name }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($list->create_date)->format('d-M-y h:i A')}}</td>
                                                    @if($list->status)
                                                        <td><span class="badge-item badge-status">Active</span></td>
                                                    @else
                                                        <td><span class="badge-item badge-status">Inactive</span></td>
                                                    @endif
                                                    <td class="action-btns">
                                                        @can('User edit')
                                                            <a href="{{route('users.edit',Crypt::encrypt($list->id))}}" class="edit-btn" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                <div class="text-center" style="float: left;padding-top: 15px;padding-left: 5px;">
                                    <p style="font-size: 14px;">Showing {{$data->firstItem()}} to {{$data->lastItem()}} of {{$data->total()}} entries</p>
                                </div>
                                <div class="text-center" style="float: right;padding-top: 5px;padding-right: 5px;">
                                    <nav>
                                        @if ($data->lastPage() > 1)
                                            <ul class="pagination">
                                                <li class="page-item {{ ($data->currentPage() == 1) ? ' disabled' : '' }}" aria-disabled="true" aria-label="« Previous">
                                                    @if($data->currentPage() == 1)
                                                    <span class="page-link" aria-hidden="true">Previous</span>
                                                    @else
                                                    <a class="page-link" href="{{ $data->url(1) }}">Previous</a>
                                                    @endif
                                                </li>
                                                @for ($i = 1; $i <= $data->lastPage(); $i++)
                                                    <?php
                                                    $half_total_links = floor(7 / 2);
                                                    $from = $data->currentPage() - $half_total_links;
                                                    $to = $data->currentPage() + $half_total_links;
                                                    if ($data->currentPage() < $half_total_links) {
                                                    $to += $half_total_links - $data->currentPage();
                                                    }
                                                    if ($data->lastPage() - $data->currentPage() < $half_total_links) {
                                                        $from -= $half_total_links - ($data->lastPage() - $data->currentPage()) - 1;
                                                    }
                                                    ?>
                                                    @if ($from < $i && $i < $to)
                                                        <li class="page-item{{ ($data->currentPage() == $i) ? ' active' : '' }}" aria-current="page">
                                                            @if($data->currentPage() == $i)
                                                            <span class="page-link">{{ $i }}</span>
                                                            @else
                                                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endfor
                                                <li class="page-item{{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
                                                    <a class="page-link" href="{{ $data->url($data->lastPage()) }}" rel="next"  aria-label="Next »">Next</a>
                                                </li>
                                            </ul>
                                        @endif
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overlay loading-content" style="display:none;">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </form>
    </main>
    @if(\Session::has('success'))
        <script type="text/javascript">
            $(document).ready(function(){
                swal({
                title: '{!!\Session::get('success')!!}',
                text: "I will close in 2 seconds.",
           0     icon: 'success',
                timer: 2000,
                buttons: false
                });
            });
        </script>
    @endif
    @if(\Session::has('error'))
        <script type="text/javascript">
            $(document).ready(function(){
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

    @can('User delete')
        <script type="text/javascript">
            //delete
            $(document).on("click", "#apply", function() {
                var ids = $.map($('input[name="ids[]"]:checked'), function(c){return c.value; });
                var action = $('#actions').val();
                if(action =='' || ids == '')
                    return;
                    swal({
                        title: "Are you sure?",
                        text: 'You will '+action+' this items',
                        icon: 'warning',
                        dangerMode: true,
                        buttons: {
                            cancel: 'No, Please!',
                            delete: 'Yes, '+action+''
                        }
                    }).then(function (willDelete) {
                        if (willDelete) {
                            $('.loading-content').fadeIn();
                            setTimeout(function(){
                                $('.loading-content').fadeOut();
                            },200);
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
    @can('User access')
        <script type="text/javascript">
            //search
            $(document).on("click", "#search", function() {
                var status = $('#user-action').val();
                var text_search = $('#text-search').val();
                var url = "{{ route('users.search_admin', ":status") }}";
                url = url.replace(':status', status);
                $.ajax({
                    url:url,
                    method:'get',
                    data:{status:status,search:text_search},
                    dataType:'json',
                    success:function(data)
                    {
                        $('.loading-content').fadeIn();
                        setTimeout(function(){
                            $('.loading-content').fadeOut();
                        },100);
                        $('#data-centent').html(data);     
                        $('#search').attr('name','true');
                    }
                });
            });
            //pagination click
            $(document).on("click", ".page-click", function() {
                var id = $(this).attr('id');
                var status = $('#user-action').val();
                var text_search = $('#text-search').val();
                //
                var showing = $('#showing').val();
                var url = "{{ route('users.show', ":showing") }}";
                url = url.replace(':showing', showing);
                //
                var url1 = "{{ route('users.search_admin', ":status") }}";
                url1 = url1.replace(':status', status);
                //
                var action = $('#search').attr('name');
                if(action != 'false'){
                    $.ajax({
                        url:url1 + "?search=" + text_search + "&status=" + status + "&page=" + id,
                        method:'get',
                        dataType:'json',
                        success:function(data)
                        {
                            $('.loading-content').fadeIn();
                            setTimeout(function(){
                                $('.loading-content').fadeOut();
                            },100);
                            $('#data-centent').html(data);
                        }
                    });
                }else{
                    $.ajax({
                        //url:"../user-showing?showing="+showing+"&page="+id,
                        url:url + "?&page=" + id,
                        method:'get',
                        dataType:'json',
                        success:function(data)
                        {
                            $('.loading-content').fadeIn();
                            setTimeout(function(){
                                $('.loading-content').fadeOut();
                            },100);
                            $('#data-centent').html(data);
                        }
                    });
                }
            });
            //showing
            $(document).on("change", "#showing", function() {
                var showing = $(this).val();
                var url = "{{ route('users.show', ":showing") }}";
                url = url.replace(':showing', showing);

                $('#text-search').val('');
                $.ajax({
                    url:url,
                    dataType:'json',
                    success:function(data)
                    {
                        $('.loading-content').fadeIn();
                        setTimeout(function(){
                            $('.loading-content').fadeOut();
                        },100);
                        $('#data-centent').html(data);
                        $('#search').attr('name','false');
                    }
                });
            });

            $(document).ready(function(){
                $('#nav-account').addClass('active');
            });
            //check all
            $(document).on("click", ".check-all", function() {
                $(".check-item").prop('checked',$(this).prop('checked'));
            });
        </script>
    @endcan
</x-app-layout>