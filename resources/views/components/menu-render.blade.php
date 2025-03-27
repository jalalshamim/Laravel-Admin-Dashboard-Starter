@if($menu)
    <ul class="{{ $class }}">
        @foreach($items as $item)
            <li class="{{ $item->children->isNotEmpty() ? 'has-children' : '' }} {{ request()->url() == $item->url ? 'active' : '' }}">
                <a href="{{ $item->url ?? '#' }}" target="{{ $item->target ?? '_self' }}">
                    @if($item->icon)
                        <i class="{{ $item->icon }}"></i>
                    @endif
                    <span>{{ $item->title }}</span>
                </a>
                
                @if($item->children->isNotEmpty())
                    <ul class="submenu">
                        @foreach($item->children as $child)
                            <li class="{{ $child->children->isNotEmpty() ? 'has-children' : '' }} {{ request()->url() == $child->url ? 'active' : '' }}">
                                <a href="{{ $child->url ?? '#' }}" target="{{ $child->target ?? '_self' }}">
                                    @if($child->icon)
                                        <i class="{{ $child->icon }}"></i>
                                    @endif
                                    <span>{{ $child->title }}</span>
                                </a>
                                
                                @if($child->children->isNotEmpty())
                                    <ul class="submenu">
                                        @foreach($child->children as $grandchild)
                                            <li class="{{ request()->url() == $grandchild->url ? 'active' : '' }}">
                                                <a href="{{ $grandchild->url ?? '#' }}" target="{{ $grandchild->target ?? '_self' }}">
                                                    @if($grandchild->icon)
                                                        <i class="{{ $grandchild->icon }}"></i>
                                                    @endif
                                                    <span>{{ $grandchild->title }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@endif