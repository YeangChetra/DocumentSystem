<?php
use App\Models\Document;
    $obj_d = new Document();

    $doc_comment = $obj_d->getDocumentList(1);
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title> @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" class="csrf-token" content="{{ csrf_token() }}">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{asset('app-assets/vendor/telegram/style.css')}}" rel="stylesheet">
        <!-- Favicon -->    
        <link rel="stylesheet" href="{{asset('app-assets/vendor/richtexteditor/rte_theme_default.css')}}" />
        <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}">
        
    </head>
    <body>
        <div class="app">
            <div class="layout">
                <section class="mainApp">
                    <div class="leftPanel">
                        <header>
                            <button class="trigger">
                                <svg viewBox="0 0 24 24">
                                    <path d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
                                </svg>
                            </button>
                            <input class="searchChats" type="search" placeholder="Search..." />
                        </header>
                        <div class="chats">
                            @foreach($doc_comment as $k => $list)
                                <a class="chatButton {{$current_data == $list->id ? 'active':''}}" href="">
                                    <div class="chatInfo">
                                        <div class="not_yet">
                                        </div>
                                        <div class="info">
                                            <p class="name">
                                                {{$list->document_descriptions}}
                                            </p>
                                            <p class="message">Actually, more than 10K people did... Congrats!Actually, more than 10K people did... Congrats!</p>
                                            <p class="from"> {{$list->document_of}}</p>
                                        </div>
                                    </div>
                                    <div class="status">
                                        <p class="date">{{Helper::getTimesStatus($list->created_at)}}</p>
                                        <p class="count">10</p>
                                        <i class="material-icons read text-danger">flag</i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @yield('content')                    
                </section>

                <section class="menuWrap">
                    <div class="menu">
                        <div class="me Bg">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="image" src="{{ Auth::user()?Auth::user()->profile_photo_url : '' }}" alt="{{ Auth::user() ? Auth::user()->name : '' }}">
                            @else
                                <i style="padding-left:2px;padding-right: 2px;color: #f55d2c;">{{ Auth::user() ? Auth::user()->name : ''}}</i>
                            @endif
                            <div class="myinfo">
                                <p class="">{{Auth::user()->name}}</p>
                                <p class="phone">{{Auth::user()->phone}}</p>
                            </div>

                            <button class="cloud">
                                <i class="material-icons">bookmark</i>
                            </button>

                            <button class="settings">
                                <i class="material-icons">settings</i>
                            </button>
                        </div>
                        <nav>
                            <button class="ng">
                                <i class="material-icons">&#xE8D3;</i>

                                <span>New Group</span>
                            </button>

                            <button class="nc">
                                <i class="material-icons">&#xE0B6;</i>

                                <span>New Channel</span>
                            </button>

                            <button class="cn">
                                <i class="material-icons">&#xE851;</i>

                                <span>Contacts</span>
                            </button>

                            <button class="cl">
                                <i class="material-icons">&#xE0B0;</i>
                                <span>Calls History</span>
                            </button>

                            <a href="https://telegram.org/faq" target="_blank">
                                <button class="faq">
                                    <i class="material-icons">&#xE000;</i>

                                    <span>FAQ and Support</span>
                                </button>
                            </a>

                            <button class="lo">
                                <i class="material-icons">&#xE879;</i>

                                <span>Logout</span>
                            </button>
                        </nav>

                        <div class="info">
                            <p>Admin System</p>
                            <p>Ver 0.0.1 - <a href="">About</a></p>
                            <p>Develop by: <a href="https://t.me/chetrayeang">Mr.Chetra Yeang</a></p>
                        </div>
                    </div>
                </section>

                <!-- CONVERSATION OPTIONS MENU -->
                <div class="moreMenu">
                    <button class="option about">See Info</button>
                    <button class="option notify">Disable Notifications</button>
                    <button class="option block">Block User</button>
                </div>

                <!-- MOBILE OVERLAY -->
                <section class="switchMobile">
                    <p class="title">Mobile Device Detected</p>

                    <p class="desc">Switch to the mobile app for a better performance.</p>

                    <a href="https://play.google.com/store/apps/details?id=org.telegram.messenger&hl=pt_BR&gl=US">
                        <button class="okay">OK</button>
                    </a>
                </section>

                <!-- PROFILE OPTIONS OVERLAY -->
                <section class="config">
                    <section class="configSect">
                        <div class="profile">
                            <p class="confTitle">Settings</p>

                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="image" src="{{ Auth::user()?Auth::user()->profile_photo_url : '' }}" alt="{{ Auth::user() ? Auth::user()->name : '' }}">
                            @else
                                <i style="padding-left:2px;padding-right: 2px;color: #f55d2c;">{{ Auth::user() ? Auth::user()->name : ''}}</i>
                            @endif
                            <div class="side">
                            <p class="">{{Auth::user()->name}}</p>
                                <p class="pStatus">Online</p>
                            </div>

                            <button class="changePic">Change Profile Picture</button>
                            <button class="edit">Edit Profile Info</button>
                        </div>
                    </section>

                    <section class="configSect second">

                        <!-- PROFILE INFO SECTION -->
                        <p class="confTitle">Your Info</p>

                        <div class="information">
                            <ul>
                                <li>Phone Number: <span class="blue phone">{{Auth::user()->phone}}</span></li>
                                <li>Username: <span class="blue username">{{Auth::user()->email}}</span></li>
                                <li>Profile: <span class="blue">https://t.me/USERNAME</span></li>
                            </ul>
                        </div>

                        <!-- NOTIFICATIONS SECTION -->
                        <p class="confTitle">Notifications</p>

                        <div class="optionWrapper deskNotif">
                            <input type="checkbox" id="deskNotif" class="toggleTracer" checked>

                            <label class="check deskNotif" for="deskNotif">
                                <div class="tracer"></div>
                            </label>
                            <p>Enable Desktop Notifications</p>
                        </div>

                        <div class="optionWrapper showSName">
                            <input type="checkbox" id="showSName" class="toggleTracer">

                            <label class="check" for="showSName">
                                <div class="tracer"></div>
                            </label>
                            <p>Show Sender Name</p>
                        </div>

                        <div class="optionWrapper showPreview">
                            <input type="checkbox" id="showPreview" class="toggleTracer">

                            <label class="check" for="showPreview">
                                <div class="tracer"></div>
                            </label>
                            <p>Show Message Preview</p>
                        </div>

                        <div class="optionWrapper playSounds">
                            <input type="checkbox" id="playSounds" class="toggleTracer">

                            <label class="check" for="playSounds">
                                <div class="tracer"></div>
                            </label>
                            <p>Play Sounds</p>
                        </div>


                        <p class="confTitle">Other Settings</p>

                        <div class="optionWrapper">
                            <input type="checkbox" id="checkNight" class="toggleTracer">

                            <label class="check DarkThemeTrigger" for="checkNight">
                                <div class="tracer"></div>
                            </label>
                            <p>Dark Theme</p>
                        </div>

                    </section>
                </section>

                <!-- DARK FRAME OVERLAY -->
                <section class="overlay"></section>

                <!-- -------------------------------- -->
                <!-- SPECIFIC FOR CONNECTION WARNINGS -->
                <!-- -------------------------------- -->
                <div class="alerts">
                    Trying to reconnect...
                </div>
            </div>
        </div>
        <div class="foorder-bar">
            
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/richtexteditor/rte.js')}}"></script>
        <script type="text/javascript" src="{{asset('app-assets/vendor/richtexteditor/plugins/all_plugins.js')}}"></script>
        <script>
            // var editor1 = new RichTextEditor(document.getElementById("replyMessage"));
            // editor1.attachEvent("change", function () {
            //     document.getElementById("inp_htmlcode").value = editor1.getHTMLCode();
            // });
            
            // var editor1cfg = {
            //     allowScriptCode: false,
            //     showPlusButton:false,
            // }
            // editor1cfg.toolbar = "basic";
            // var editor1 = new RichTextEditor("#replyMessage", editor1cfg);
        </script>
        <script>
            $(document).ready(function(){
                    /* make side menu show up */
                $(".trigger").click(function(){
                    $(".overlay, .menuWrap").fadeIn(180);
                            $(".menu").animate({opacity: '1', left: '0px'}, 180);
                });
                    
                    /* make config menu show up */
                    $(".settings").click(function(){
                            $(".config").animate({opacity: '1', right: '0px'}, 180);
                        /* hide others */
                            $(".menuWrap").fadeOut(180);
                            $(".menu").animate({opacity: '0', left: '-320px'}, 180);
                });
                
                    // Show/Hide the other notification options
                    $(".deskNotif").click(function(){
                    $(".showSName, .showPreview, .playSounds").toggle();
                });
                
                    /* close all overlay elements */
                    $(".overlay").click(function () {
                            $(".overlay, .menuWrap").fadeOut(180);
                    $(".menu").animate({opacity: '0', left: '-320px'}, 180);
                            $(".config").animate({opacity: '0', right: '-200vw'}, 180);
                });
                    
                    //This also hide everything, but when people press ESC
                    $(document).keydown(function(e) {
                        if (e.keyCode == 27) {
                            $(".overlay, .menuWrap").fadeOut(180);
                    $(".menu").animate({opacity: '0', left: '-320px'}, 180);
                            $(".config").animate({opacity: '0', right: '-200vw'}, 180);
                        }
                });
                
                //Enable/Disable night mode
                $(".DarkThemeTrigger").click(function(){
                    $("body").toggleClass("DarkTheme")
                }); 	

                /* small conversation menu */
                $(".otherOptions").click(function(){
                    $(".moreMenu").slideToggle("fast");
                });
                
                /* clicking the search button from the conversation focus the search bar outside it, as on desktop */
                $( ".search" ).click(function() {
                    $( ".searchChats" ).focus();
                });

                /* Show or Hide Emoji Panel */
                $(".emoji").click(function(){
                    $(".emojiBar").fadeToggle(120);
                });
                    
                /* if the user click the conversation or the type panel will also hide the emoji panel */
                $(".convHistory, .replyMessage").click(function(){
                    $(".emojiBar").fadeOut(120);
                });
            });
        </script>
        @yield('script')
    </body>
</html>