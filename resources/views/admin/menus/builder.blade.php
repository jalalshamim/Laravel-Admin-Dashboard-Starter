@extends('admin.layouts.app')

@section('title', 'Menu Builder')

@push('styles')
<style>
    .menu-builder {
        min-height: 200px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 4px;
    }
    .menu-item {
        background: white;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        padding: 10px;
        border-radius: 4px;
        cursor: move;
    }
    .menu-item.dragging {
        opacity: 0.5;
    }
    .menu-item-placeholder {
        border: 2px dashed #ccc;
        margin-bottom: 5px;
        height: 40px;
        border-radius: 4px;
    }
    .nested-menu {
        margin-left: 30px;
        padding-left: 10px;
        border-left: 2px solid #eee;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Menu Item</h3>
                </div>
                <div class="card-body">
                    <form id="menuItemForm">
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="text" name="url" id="url" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="icon">Icon Class</label>
                            <input type="text" name="icon" id="icon" class="form-control" placeholder="fas fa-home">
                        </div>

                        <div class="form-group">
                            <label for="target">Target</label>
                            <select name="target" id="target" class="form-control">
                                <option value="_self">Same Window</option>
                                <option value="_blank">New Window</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Menu Structure: {{ $menu->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Menus
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div id="menuBuilder" class="menu-builder">
                        @include('admin.menus.partials.menu-items', ['items' => $menuItems])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Menu Item Modal -->
<div class="modal fade" id="editMenuItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu Item</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editMenuItemForm">
                    <input type="hidden" name="item_id" id="edit_item_id">
                    
                    <div class="form-group">
                        <label for="edit_title">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_url">URL</label>
                        <input type="text" name="url" id="edit_url" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edit_icon">Icon Class</label>
                        <input type="text" name="icon" id="edit_icon" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edit_target">Target</label>
                        <select name="target" id="edit_target" class="form-control">
                            <option value="_self">Same Window</option>
                            <option value="_blank">New Window</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="edit_status" name="status" value="1">
                            <label class="custom-control-label" for="edit_status">Active</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateMenuItem">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Sortable for menu items
    const menuBuilder = document.getElementById('menuBuilder');
    const sortable = new Sortable(menuBuilder, {
        group: 'nested',
        animation: 150,
        fallbackOnBody: true,
        swapThreshold: 0.65,
        ghostClass: 'menu-item-placeholder',
        dragClass: 'dragging',
        onEnd: function() {
            updateMenuOrder();
        }
    });

    // Add menu item
    const menuItemForm = document.getElementById('menuItemForm');
    menuItemForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Create an object from form data
        const formData = new FormData(menuItemForm);
        const formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });
        
        // Send the request
        fetch('{{ route("admin.menu-items.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formObject)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                const errorMessages = data.errors ? Object.values(data.errors).join('\n') : 'Something went wrong';
                alert('Error: ' + errorMessages);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the menu item. Please try again.');
        });
    });

    // Edit menu item
    const editModal = document.getElementById('editMenuItemModal');
    const editForm = document.getElementById('editMenuItemForm');
    
    document.querySelectorAll('.edit-menu-item').forEach(button => {
        button.addEventListener('click', function() {
            const item = this.closest('.menu-item');
            const itemId = item.dataset.id;
            
            document.getElementById('edit_item_id').value = itemId;
            document.getElementById('edit_title').value = item.dataset.title;
            document.getElementById('edit_url').value = item.dataset.url;
            document.getElementById('edit_icon').value = item.dataset.icon;
            document.getElementById('edit_target').value = item.dataset.target;
            document.getElementById('edit_status').checked = item.dataset.status === '1';
            
            $(editModal).modal('show');
        });
    });

    // Update menu item
    document.getElementById('updateMenuItem').addEventListener('click', function() {
        const itemId = document.getElementById('edit_item_id').value;
        const formData = new FormData(editForm);
        
        // Create an object from form data
        const formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });
        
        // Add status checkbox value - since unchecked checkbox is not included in formData
        if (!formObject.hasOwnProperty('status')) {
            formObject.status = 0;
        }
        
        // Add _method field for Laravel method spoofing
        formObject._method = 'PUT';
        
        fetch(`{{ url('admin/menu-items') }}/${itemId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formObject)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                const errorMessages = data.errors ? Object.values(data.errors).join('\n') : 'Something went wrong';
                alert('Error: ' + errorMessages);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the menu item. Please try again.');
        });
    });

    // Delete menu item
    document.querySelectorAll('.delete-menu-item').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this menu item?')) {
                const itemId = this.closest('.menu-item').dataset.id;
                
                fetch(`{{ url('admin/menu-items') }}/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting menu item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the menu item. Please try again.');
                });
            }
        });
    });

    // Update menu order
    function updateMenuOrder() {
        const items = [];
        let order = 0;
        
        function processItem(element, parentId = null) {
            const item = {
                id: parseInt(element.dataset.id),
                parent_id: parentId,
                order: order++
            };
            items.push(item);
            
            const nestedList = element.querySelector('.nested-menu');
            if (nestedList) {
                nestedList.querySelectorAll(':scope > .menu-item').forEach(child => {
                    processItem(child, item.id);
                });
            }
        }
        
        menuBuilder.querySelectorAll(':scope > .menu-item').forEach(item => {
            processItem(item);
        });
        
        fetch('{{ route("admin.menu-items.reorder") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ items })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error updating menu order');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating menu order. Please try again.');
        });
    }
});
</script>
@endpush 