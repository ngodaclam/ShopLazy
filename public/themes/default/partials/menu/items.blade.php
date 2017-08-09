@foreach($items as $item)
    <li class="{!! $item->attributes['class'] !!} {!! $item->hasChildren() ? 'nav-parent' : '' !!}">
        @if($item->hasChildren())
            <a href="#">
                <i class="{!! $item->icon !!}"></i>
                <span data-translate="{!! $item->name !!}">{!! $item->title !!}</span>
                <span class="fa arrow"></span>
            </a>
        @else
            <a href="{!! $item->link ? $item->url() : '#' !!}">
                <i class="fa {!! $item->icon !!}"></i>
                <span data-translate="{!! $item->name !!}">{!! $item->title !!}</span>
            </a>
        @endif
        @if($item->hasChildren())
            <ul class="children collapse">
                {!! theme()->partial('menu.items', ['items' => $item->children()]) !!}
                {{--@foreach($item->children() as $child)--}}
                    {{--<li><a href="{!! $child->url() !!}">{!! $child->title !!}</a></li>--}}
                {{--@endforeach--}}
            </ul>
        @endif
    </li>
    @if($item->divider)
        <li {!! HTML::attributes($item->divider) !!} class="{!! $item->attributes['class'] !!}"></li>
    @endif
@endforeach