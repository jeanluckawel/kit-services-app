@extends('layoutsddd.app')

@section('title', 'Dashboard - KIT SERVICES')

@section('content')
<style>
    /* Styles personnalisés pour moderniser sans changer les couleurs de base */
    .info-box {
        border-radius: 15px;
        border: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #ffffff;
    }
    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .info-box-icon {
        border-radius: 12px !important;
        width: 60px;
        height: 60px;
        margin: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.25rem;
    }
    .app-content-header { padding: 2rem 0; }
    .badge-modern {
        padding: 0.5em 1em;
        border-radius: 8px;
        font-weight: 500;
    }
</style>

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="mb-0 fw-bold text-dark">Tableau de Bord</h3>
                <p class="text-muted small">Bienvenue sur votre gestion KIT SERVICES</p>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon text-bg-warning">
                        <i class="bi bi-people-fill fs-4"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted fw-medium">Employés</span>
                        <h4 class="info-box-number mb-0 fw-bold">{{ number_format((int) ($employeeCount ?? 0)) }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon text-bg-primary">
                        <i class="bi bi-building fs-4"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted fw-medium">Départements</span>
                        <h4 class="info-box-number mb-0 fw-bold">{{ number_format((int) ($departmentCount ?? 0)) }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon text-bg-danger">
                        <i class="bi bi-file-earmark-text-fill fs-4"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted fw-medium">Contrats Actifs</span>
                        <h4 class="info-box-number mb-0 fw-bold">{{ number_format((int) ($activeContractsCount ?? 0)) }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon text-bg-success">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted fw-medium">Masses Salariales</span>
                        <h4 class="info-box-number mb-0 fw-bold">{{ number_format((int) ($payrollCount ?? 0)) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="d-grid gap-3">
                    <div class="info-box shadow-sm m-0">
                        <span class="info-box-icon text-bg-warning"><i class="bi bi-receipt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text small text-muted">Factures</span>
                            <span class="info-box-number h5">{{ number_format((int) ($invoiceCount ?? 0)) }}</span>
                        </div>
                    </div>

                    <div class="info-box shadow-sm m-0">
                        <span class="info-box-icon text-bg-primary"><i class="bi bi-gear-fill"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text small text-muted">Configurations</span>
                            <span class="info-box-number h5">{{ number_format((int) ($configurationCount ?? 0)) }}</span>
                        </div>
                    </div>

                    <div class="info-box shadow-sm m-0">
                        <span class="info-box-icon text-bg-danger"><i class="bi bi-person-badge"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text small text-muted">Utilisateurs</span>
                            <span class="info-box-number h5">{{ number_format((int) ($usersCount ?? 0)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card h-100 shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title fw-bold">Notifications Récentes</h3>
                        <div class="card-tools">
                             <button type="button" class="btn btn-light btn-sm rounded-pill" data-lte-toggle="card-collapse">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item list-group-item-action border-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light p-2 rounded-circle">
                                            <img src="./assets/img/default-150x150.png" class="rounded-circle" width="40" height="40" alt="user">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="text-decoration-none text-dark fw-bold">Nouvel Utilisateur Créé</a>
                                            <span class="badge text-bg-warning-soft badge-modern text-warning" style="background-color: #fff3cd;">$1800</span>
                                        </div>
                                        <p class="mb-0 text-muted small">Par Jean Luc Kawel • Il y a 5 min</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>

                    <div class="card-footer bg-transparent border-0 text-center py-3">
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-pill px-4">Voir toutes les activités</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection