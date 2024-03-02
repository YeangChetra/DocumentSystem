@extends('layouts.chat')
@section('content')
    <section class="mainApp">
        <div class="rightPanel">
            <div class="topBar">
                <div class="rightSide">
                    <button class="tbButton search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button class="tbButton otherOptions">
                        <i class="material-icons">more_vert</i>
                    </button>
                </div>

                <button class="go-back">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Go back</title>
                        <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" />
                    </svg>
                </button>

                <div class="leftSide">
                    <p class="chatName">{{$current_item->document_descriptions}}</span></p>
                    <p class="chatStatus">Online</p>
                </div>
            </div>
            <div class="convHistory userBg">
                @foreach($files as $k => $lst_files)
                    <div style="margin:50px 50px 0 0;display: contents;clear: both; background:#fff;">
                        <a href="{{asset('storage/'.$lst_files->filename)}}" target="_balnk" class="image">
                            <img style="float:left; clear:both"   width="100" hieght="150" src="{{asset('storage\logo\file_pdf_download_icon-icons.com_68954.png')}}" alt="" srcset="{{asset('storage\logo\file_pdf_download_icon-icons.com_68954.png')}}">
                            <p style="margin-top:50px;">{{$lst_files->displaytitle}}</p>
                        </a>
                    </div>
                @endforeach
                <div class="chat-box">
                </div>
            </div>
            <div class="replyBar">
                <form class="typing-area" id="typing-area" method="post">
                    @csrf
                    @method('POST')
                    <textarea class="replyMessage" id="replyMessage" name="replyMessage" placeholder="Type your message..." ></textarea>
                    <input type="text" class="incoming_id" name="incoming_id" value="{{$current_item->unique_id}}" hidden>

                    <div class="otherTools">
                        <button class="toolButtons">
                            <i class="material-icons">telegram</i>
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </section>
@stop
@section('script')
{{-- <script src="{{asset('app-assets/vendor/chat/js/chat.js')}}"></script> --}}
@stop