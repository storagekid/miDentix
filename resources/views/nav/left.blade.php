<div class="col-sm-2 hidden-xs" id="left-sidebar">
    <div class="sidebar-nav">
        <div class="navbar navbar-default navbar-left-sidebar" role="navigation">
            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                @include('nav.profile')
                <main-menu :menu="{{auth()->user()->getMenu('gabinete', auth()->user()->group()->pluck('name')->toArray(),auth()->user()->role )}}" :user="{{auth()->user()}}"></main-menu>
{{--                 @if(auth()->user()->role === "admin")
                	@include('nav.left-nav-admin')
                @else
                	@include('nav.left-nav-user')
				@endif --}}
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
