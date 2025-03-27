{{-- Example of how to use the menu component in your layouts --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Component Usage Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Basic menu styling */
        .main-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        
        .main-menu > li {
            position: relative;
            margin-right: 20px;
        }
        
        .main-menu a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            padding: 10px;
        }
        
        .main-menu a:hover {
            color: #007bff;
        }
        
        .submenu {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            list-style: none;
            padding: 0;
            min-width: 200px;
            z-index: 100;
        }
        
        .has-children:hover > .submenu {
            display: block;
        }
        
        .submenu .submenu {
            left: 100%;
            top: 0;
        }
        
        .active > a {
            font-weight: bold;
            color: #007bff;
        }
        
        footer .menu {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        
        footer .menu li {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <header class="bg-light py-3">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="/">Your Site</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    {{-- Using menu component with location --}}
                    <x-menu-render location="header" class="main-menu" />
                </div>
            </nav>
        </div>
    </header>

    <main class="container py-4">
        <h1>Welcome to the site</h1>
        <p>This is an example of how to use the menu component.</p>
    </main>

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    {{-- Using menu component with name --}}
                    <x-menu-render name="Footer Menu" class="menu" />
                    <p class="mt-3">© {{ date('Y') }} {{ \App\Models\Setting::get('app_name', 'Your Company') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 