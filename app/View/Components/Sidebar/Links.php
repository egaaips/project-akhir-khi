<?php

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Links extends Component
{
    public string $title, $url, $icon, $active;
    public function __construct($title, $url, $icon)
    {
        $this->title = $title;
        $this->url = $url;
        $this->icon = $icon;
        $basePath = $this->generatePath($url);
        $this->active = request()->routeIs($basePath) ? 'bg-blue-300 text-white' : '';
    }

    public function generatePath($url){
        if(str_contains($url, '.')) {
            $path = explode('.', $url);
            return $path[0] . '.*';
        } else {
            return $url;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar.links');
    }
}
