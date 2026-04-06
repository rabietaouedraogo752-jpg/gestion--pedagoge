@extends('davy.gestion.Layouts.app')
@section('title', 'Tableau de bord')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h3 class="fw-bold text-primary">
                      <i class="bi bi-grid me-2"></i>Tableau de bord
                  </h3>
                
                </div>
    
                <div>
                
                <!-- Ton bouton d'action vers les modules -->
                    <a href="{{ url('/etudiants') }}" class="btn btn-primary shadow-sm">
                       <i class="bi bi-box-arrow-in-right me-1"></i> Accéder aux modules
                    </a>
                </div>
               
            </div>
             <p class="text-muted">Bienvenue, <strong>{{ Auth::user()->nom_complet }}</strong> !</p>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left:4px solid #0d6efd !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-people-fill text-primary" style="font-size:1.8rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total utilisateurs</div>
                        <div class="fw-bold fs-3">{{ $totalUtilisateurs }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left:4px solid #198754 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="bi bi-mortarboard-fill text-success" style="font-size:1.8rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Étudiants</div>
                        <div class="fw-bold fs-3">{{ $totalEtudiants }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left:4px solid #ffc107 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-person-workspace text-warning" style="font-size:1.8rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Enseignants</div>
                        <div class="fw-bold fs-3">{{ $totalEnseignants }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left:4px solid #dc3545 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="bi bi-shield-fill text-danger" style="font-size:1.8rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Administrateurs</div>
                        <div class="fw-bold fs-3">{{ $totalAdmins }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold">
                        <i class="bi bi-bar-chart-fill text-primary me-2"></i>Inscriptions par mois
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartInscriptions" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold">
                        <i class="bi bi-pie-chart-fill text-success me-2"></i>Répartition par rôle
                    </h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="chartRoles" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold">
                        <i class="bi bi-clock-history text-warning me-2"></i>Derniers inscrits
                    </h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($derniersInscrits ?? [] as $index => $u)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $u->nom_complet }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if($u->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($u->role == 'enseignant')
                                        <span class="badge bg-warning text-dark">Enseignant</span>
                                    @else
                                        <span class="badge bg-success">Étudiant</span>
                                    @endif
                                </td>
                                <td>{{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : 'Date inconnue' }}</td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Aucun utilisateur
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(Auth::user()->isAdmin())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('chartInscriptions').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($moisLabels ?? []),
            datasets: [{
                label: 'Inscriptions',
                data: @json($moisData ?? []),
                backgroundColor: 'rgba(13,110,253,0.7)',
                borderColor: 'rgba(13,110,253,1)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartRoles').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: [
                'Étudiants ({{ $rolesPourcentages[0] ?? 0 }}%)',
                'Enseignants ({{ $rolesPourcentages[1] ?? 0 }}%)',
                'Admins ({{ $rolesPourcentages[2] ?? 0 }}%)'
            ],
            datasets: [{
                data: @json($rolesData ?? []),
                backgroundColor: [
                    'rgba(25,135,84,0.8)',
                    'rgba(255,193,7,0.8)',
                    'rgba(220,53,69,0.8)',
                ],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endif
@endpush