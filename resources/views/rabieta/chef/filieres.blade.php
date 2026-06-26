@extends('Layouts.mespages')
@section('content')
<div class="container py-4">
    <h3 class="text-primary fw-bold mb-4"><i class="bi bi-diagram-3 me-2"></i>Filières du Département</h3>
    <div class="row g-3">
        @foreach($filieres as $f)
            <div class="col-md-4">
                <div class="card p-3 shadow-sm border-0 bg-white">
                    <div class="fw-bold text-dark"><i class="bi bi-folder text-warning me-2"></i>{{ $f }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
