<nav-left :menu="{{auth()->user()->getMenu('gabinete', auth()->user()->group()->pluck('name')->toArray(),auth()->user()->role )}}"></nav-left>
