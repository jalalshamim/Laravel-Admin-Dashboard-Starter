@foreach($items as $item)
    <div class="menu-item" 
        data-id="{{ $item->id }}"
        data-title="{{ $item->title }}"
        data-url="{{ $item->url }}"
        data-icon="{{ $item->icon }}"
        data-target="{{ $item->target }}"
        data-status="{{ $item->status }}">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                @if($item->icon)
                    <i class="{{ $item->icon }}"></i>
                @endif
                <span class="ml-2">{{ $item->title }}</span>
                @if(!$item->status)
                    <span class="badge badge-warning ml-2">Inactive</span>
                @endif
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary edit-menu-item">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger delete-menu-item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        
        @if($item->children->isNotEmpty())
            <div class="nested-menu">
                @include('admin.menus.partials.menu-items', ['items' => $item->children])
            </div>
        @endif
    </div>
@endforeach 