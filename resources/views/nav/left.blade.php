<nav-left :menu="{{auth()->user()->getMenu('gabinete', [session('user.group.0.name')], session('user.role') )}}"></nav-left>
