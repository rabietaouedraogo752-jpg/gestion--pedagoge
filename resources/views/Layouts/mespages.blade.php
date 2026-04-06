<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon application de gestion d'école</title>
    
<!--le lien boostrap pour la mise en forme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>

<body>
    
    <nav class="navbar navbar-expand-lg  bg-primary ">
        <div class="container mt-4">
            
           
            <a class="nav-link d-inline mx-2 text-white" href="/matieres">Matières</a>
            <a class="nav-link d-inline mx-2 text-white" href="/notes">Notes</a>
            <a class="nav-link d-inline mx-2 text-white" href="/etudiants">Etudiant</a>
            <a class="nav-link d-inline mx-2 text-white" href="/enseignants">Enseignant</a>
            <a class="nav-link d-inline mx-2 text-white" href="/cours">Cours</a>

        </div>
    </nav>
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success  alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="container mt-4">
        @yield('content')
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>