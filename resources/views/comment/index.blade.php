@extends('layouts.chat')
@section('content')
<div class="rightPanel">
    <div class="topBar">
    </div>
    <div class="convHistory userBg">                            
                            
    </div>

    <div class="replyBar">
        <form action="#" class="typing-area">
            @csrf     
            <input type="text" class="replyMessage" placeholder="Type your message..." autocomplete="off"/>
            <input type="text" class="incoming_id" name="incoming_id" value="{{Crypt::encrypt(Auth::user()->unique_id)}}" hidden>

            <div class="otherTools">
                <button class="toolButtons audio">
                    <i class="material-icons">telegram</i>
                </button>
            </div>
            
        </form>
    </div>
</div>
@stop
@section('script')
@stop