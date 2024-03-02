@php
    use App\Models\User;
    use App\Models\Structure;
    use App\Models\Levelprefix;
    use App\Models\Level;
    
@endphp
<x-app-layout>
    <style>
        .col-md-6{
            flex: 0 0 50% !important;
        }
        .card-group > .col-md-12{
            flex: 0 0 100% !important;
            border: 1px solid #eee !important;
        }
        .card-header{
            background-color: rgba(0,0,0,.0) !important;
        }
        .card-text{
            margin-bottom: 0 !important;
        }
        .font-kbach{
          font-family: "Khmer OS Muol Light";
        }
        .font-tacteing{
          font-family: TACTENG;
        }
        .card-box {
            padding: 20px;
            border-radius: 3px;
            margin-bottom: 30px;
            background-color: #fff;
        }

        .file-man-box {
            padding: 20px;
            border: 1px solid #e3eaef;
            border-radius: 5px;
            position: relative;
            margin-bottom: 20px
        }
/* 
        .file-man-box .file-close {
            color: #f1556c;
            position: absolute;
            line-height: 24px;
            font-size: 24px;
            right: 10px;
            top: 10px;
            visibility: hidden
        } */

        .file-man-box .file-img-box {
            line-height: 120px;
            text-align: center
        }

        .file-man-box .file-img-box img {
            height: 64px
        }

        /* .file-man-box .file-download {
            font-size: 32px;
            color: #98a6ad;
            position: absolute;
            right: 10px
        } */

        /* .file-man-box .file-download:hover {
            color: #313a46
        } */

        .file-man-box .file-man-title {
            padding-right: 25px
        }

        .file-man-box:hover {
            -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
            box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02)
        }

        .file-man-box:hover .file-close {
            visibility: visible
        }
        .text-overflow {
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
            width: 100%;
            overflow: hidden;
        }
        h5 {
            font-size: 15px;
        }
        .status{
          width:8px;
          height:8px;
          border-radius:50%;
          display:inline-block;
          margin-right:7px;
        }
        .green{
          background-color:#58b666;
        }
        .orange{
          background-color:#ff725d;
        }
        .blue{
          background-color:#6fbced;
          margin-right:0;
          margin-left:7px;
        }

        #chat{
          padding-left:0;
          margin:0;
          list-style-type:none;
          overflow-y:scroll;
          height:755px;;
          border-top:2px solid #fff;
          border-bottom:2px solid #fff;
        }
        #chat li{
          padding:10px 30px;
        }
        #chat h2,#chat h3{
          /* display:inline-block; */
          font-size:13px;
          font-weight:normal;
        }
        #chat h3{
          color:#bbb;
        }
        #chat .entete{
          margin-bottom:5px;
        }
        #chat .message{
          padding:20px;
          color:#fff;
          line-height:25px;
          max-width:90%;
          display:inline-block;
          text-align:left;
          border-radius:5px;
        }
        #chat .me{
          text-align:right;
        }
        #chat .you .message{
          background-color:#58b666;
        }
        #chat .me .message{
          background-color:#6fbced;
        }
        #chat .triangle{
          width: 0;
          height: 0;
          border-style: solid;
          border-width: 0 10px 10px 10px;
        }
        #chat .you .triangle{
            border-color: transparent transparent #58b666 transparent;
            margin-left:15px;
        }
        #chat .me .triangle{
            border-color: transparent transparent #6fbced transparent;
            margin-left:375px;
        }

    </style>
  <main>
    <div class="container-fluid">
      <h2 class="mt-30 page-title">User Comments</h2>
      <ol class="breadcrumb mb-30">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">User Comment</li>
      </ol>
      <div class="row">
        <div class="col-lg-7 col-md-7">
          <div class="card card-static-2 mb-30">
            <div class="card-body-table" style="font-size:12px">
              <div class="shopowner-content-left text-center pd-20">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 text-center mt-10">
                                Genearal Directorate of Agriculture
                            </div>
                            <div class="col-md-12 text-center font-tacteing">
                                3
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                kingdom of Cambodia
                            </div>
                            <div class="col-md-12 text-center">
                                Nation Religion King
                            </div>
                            <div class="col-md-12 text-center font-tacteing">
                                3
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">                        
                        <div class="shopowner-dt-left mt-4 text-right">
                            <h4  style="font-size:12px; margin-right: 24px;">Comment / Feedback</h4>
                            <span style="margin-right: 66px;" class="font-tacteing">3</span>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 text-right">
                        <div class="border p-2"  style="font-size:12px">
                            # IN : <b>0{{$data->code}}</b>
                        </div> 
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">                        
                        <div class="shopowner-dt-left text-left">
                            <span style="font-size:12px"># Document: <b>{{$data->document_no}}</b></span>
                        </div>
                    </div>
                    <div class="col-md-3">                        
                        <div class="shopowner-dt-left text-left">
                            <span style="font-size:12px">Date: <b>{{$data->document_date}}</b></span>
                        </div>
                    </div>
                    <div class="col-md-5">                        
                        <div class="shopowner-dt-left text-left">
                            <span style="font-size:12px">From: <b>{{$data->document_of}}</b></span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">                        
                        <div class="shopowner-dt-left text-left">
                            <span style="font-size:12px">Descriotion : <b>{{$data->document_descriptions}}</b></span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">                        
                        <div class="shopowner-dt-left text-right">
                            <span style="font-size:12px">Release Date : <b>{{ $data->created_at}}</b></span>
                        </div>
                    </div>
                </div>
                <div class="shopowner-dts mt-4">
                    <div class="row">
                        <div class="card-group">
                            @foreach($comment as $k => $item)
                                @php
                                    $get_user = User::Find($item->user_id);
                                    $get_position = Structure::Find($get_user->position_id);
                                    $get_levelpreflex = Levelprefix::Find($get_user->levelprefixid);
                                    $get_level = Level::Find($get_user->levelid);
                                @endphp
                                @if($k <= 1)
                                    <div class="card col-md-6">
                                        <div class="card-header shopowner-dt-left text-left"><span style="font-size:12px">Comment form :  {{$get_position->name." (".$get_level->short_name.")"}}</span></div>
                                        <div class="card-body">
                                            <p class="card-text shopowner-dt-left text-left">
                                                <span style="font-size:12px">
                                                    {{$item->commands}}
                                                </span>
                                            </p>
                                            <br>
                                            <p class="card-text text-right"><small class="text-muted">Last updated 
                                                {{Helper::getTimesStatus($data->created_at, $item->update_date)}} ago</small></p>
                                            <p class="card-text text-right"><small class="text-muted">{{ $get_user->name}}</small></p>
                                        </div>
                                    </div>
                                @elseif($k >= 2)
                                    <div class="card col-md-12">
                                        <div class="card-header shopowner-dt-left text-left"><span style="font-size:12px">Comment form : {{$get_position->name.', ('.$get_level->short_name.")"}}</span></div>
                                        <div class="card-body">
                                            <p class="card-text shopowner-dt-left text-left">
                                                <span style="font-size:12px">
                                                    {{$item->commands}}
                                                </span>
                                            </p>
                                            <br>
                                            <p class="card-text text-right"><small class="text-muted">Last updated {{Helper::getTimesStatus($data->created_at,  $item->update_date)}} ago</small></p>
                                            <p class="card-text text-right"><small class="text-muted">{{ $get_user->name}}</small></p>
                                        </div>
                                    </div>
                                @else
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-md-5">
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>Comment List</h4>
            </div>            
            <main>
              <ul id="chat">
              @php
                $bg = ['me','you'];
              @endphp
              @foreach($comment as $k => $item)
                @php
                  $get_user = User::Find($item->user_id);
                  $get_position = Structure::Find($get_user->position_id);
                  $get_levelpreflex = Levelprefix::Find($get_user->levelprefixid);
                  $get_level = Level::Find($get_user->levelid);
                @endphp
                <li class="you">
                  <div class="entete">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <img style="width: 35px; height:35px; border-radius: 50%;border: 1px #45bbe0 solid;	float: left;margin-right: 5px;margin-bottom: 5px;" src="{{ $get_user?$get_user->profile_photo_url : '' }}" alt="{{ $get_user ? $get_user->name : '' }}">
                    <h2>{{ $get_user ? $get_user->name : ''}}</h2>
                    <h3>Last updated {{Helper::getTimesStatus($data->created_at,  $item->update_date)}} ago</h3>
                    @else
                    <i style="padding-left:2px;padding-right: 2px;color: #f55d2c;">{{ $get_user ? $get_user->name : ''}}</i>
                    <h2>{{ $get_user ? $get_user->name : ''}}</h2>
                    <h3>Last updated {{Helper::getTimesStatus($data->created_at,  $item->update_date)}} ago</h3>
                    @endif
                  </div>
                  <div class="triangle"></div>
                  <div class="message">
                    {{$item->commands}}
                  </div>
                </li>
              @endforeach
              </ul>
            </main>
          </div>
        </div>        
        <div class="col-lg-7 col-md-7">
          <div class="card card-static-2 mb-30">
            <div class="card-title-2">
              <h4>Attach Files</h4>
            </div>
              <div class="card-body-table">                
                <div class="card-box">
                  <div class="row">
                    @foreach($files as $key => $items) 
                      <a href="{{asset('storage/'.$items->filename)}}" target="_blank" class="col-lg-3 col-xl-2">
                        <div class="">
                            <div class="file-man-box">
                              <div class="file-img-box">
                                @if($items->file_type == 'pdf')
                                  <img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/pdf.svg" width="100%" heigth="250" alt="icon">
                                @elseif($items->file_type == 'png')
                                  <img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/png.svg" width="100%" heigth="250" alt="icon">
                                @elseif($items->file_type == 'jpg')
                                  <img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/jpg.svg" width="100%" heigth="250" alt="icon">
                                @endif
                              </div>
                              <div class="file-man-title">
                                  <h5 class="mb-0 text-overflow">{{$items->displaytitle}}</h5>
                              </div>
                            </div>
                        </div>
                      </a>
                    @endforeach
                  </div>
                </div>
              </div>
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