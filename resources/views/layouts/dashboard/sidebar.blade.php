<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
       <a href="dashboard">
       <img src="images/home.png" class="img-fluid" alt="">
       <span>IoT House</span>
       </a>
       <div class="iq-menu-bt align-self-center">
          <div class="wrapper-menu">
             <div class="line-menu half start"></div>
             <div class="line-menu"></div>
             <div class="line-menu half end"></div>
          </div>
       </div>
    </div>
    <div id="sidebar-scrollbar">
       <nav class="iq-sidebar-menu">
          <ul id="iq-sidebar-toggle" class="iq-menu">
             <li class="iq-menu-title"><i class="ri-separator"></i><span>Main</span></li>
             <li class="
             {{-- dashboard1 itu diganti sama led yang dashboard --}}
             @if (request()->url() == route('dashboard'))
                 active
            @endif
             ">
                <a href="{{route('dashboard')}}" class="iq-waves-effect"><i class="ri-home-4-line"></i><span>Dashboard</span></a></li>
                {{-- <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                   <li class="active"><a href="dashboard">Dashboard 1</a></li>
                   <li><a href="dashboard1.html">Dashboard 2</a></li>
                </ul> --}}
             </li>
             <li class="
             @if (request()->url() == route('sensor'))
                 active
            @endif
             ">
                <a href="sensor" class="iq-waves-effect"><i class="ri-mail-line"></i><span>Sensor</span></a></li>
                {{-- <ul id="mailbox" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                   <li><a href="sensor">sensor</a></li>
                   {{-- <li><a href="app/email-compose.html">Email Compose</a></li> --}}
                {{-- </ul> --}}
             {{-- </li> --}}
             {{-- <li><a href="todo.html" class="iq-waves-effect"><i class="ri-chat-check-line"></i><span>Todo</span></a></li> --}}
             <li class="
             @if (request()->url() == route('leds.led'))
                 active
            @endif
             ">
                <a href="{{route('leds.led')}}" class="iq-waves-effect"><i class="ri-user-line"></i><span>LED Control</span></a><li>
                {{-- <ul id="user-info" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                   {{-- <li><a href="led">User Profile</a></li> --}}
                   {{-- <li><a href="profile-edit.html">User Edit</a></li>
                   <li><a href="add-user.html">User Add</a></li>
                   <li><a href="user-list.html">User List</a></li> --}}
                {{-- </ul> --}}
             {{-- </li> --}}
             <li class="
             @if (request()->url() == route('users.index'))
                 active
            @endif
             ">
             <a href="{{route('users.index')}}" class="iq-waves-effect"><i class="ri-message-line"></i><span>Pengguna</span></a></li>

             <li class="
             @if (request()->url() == route('logout'))
                 active
            @endif
             ">
                <a href="{{route('logout')}}" class="iq-waves-effect"><i class="far fa-rotate-left"></i><span>Back to Home</span></a></li>
             </li>


       </nav>
       <div class="p-3"></div>
    </div>
 </div>
