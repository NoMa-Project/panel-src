@extends('layouts.app')

@section('title', "Manage node")

@section('content')
<a href="{{ route("node.edit", $node) }}" class="btn btn-warning"><i class="far fa-edit"></i> Edit Node</a>
<canvas id="metricsChart"></canvas>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>    
@endpush

@push('footer-scripts')
@endpush

@push('styles')
<script>
    // Récupérer les données depuis l'API
    const apiUrl = '{{ route("api-node-data", $node) }}'; // Mettez votre URL d'API correcte ici
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Créer des tableaux pour chaque métrique et les dates formatées
            const cpuUsage = [];
            const maxCpu = [];
            const ramUsage = [];
            const maxRam = [];
            const createdDates = [];

            // Parcourir chaque jeu de données
            data.forEach(metric => {
                cpuUsage.push(metric.cpuUsage);
                maxCpu.push(metric.maxCpu);
                ramUsage.push(metric.ramUsage);
                maxRam.push(metric.maxRam);

                // Convertir le format de la date
                const createdAt = new Date(metric.created_at);
                const formattedDate = `${createdAt.getDate()}/${createdAt.getMonth() + 1}/${createdAt.getFullYear()} ${createdAt.getHours()}:${createdAt.getMinutes()}:${createdAt.getSeconds()}`;
                createdDates.push(formattedDate);
            });

            // Configurer le graphique
            const ctx = document.getElementById('metricsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                options: {
                    responsive: true,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: '{{ $node->name }} statistics'
                        }
                    }
                },
                data: {
                    labels: createdDates,
                    datasets: [
                        {
                            label: 'CPU Usage (%)',
                            data: cpuUsage,
                            borderColor: 'red',
                            backgroundColor: 'red',
                        },
                        {
                            label: 'Max CPU',
                            data: maxCpu,
                            borderColor: 'blue',
                            backgroundColor: 'blue',
                        },
                        {
                            label: 'RAM Usage (%)',
                            data: ramUsage,
                            borderColor: 'green',
                            backgroundColor: 'green',
                        },
                        {
                            label: 'Max RAM (mb)',
                            data: maxRam,
                            borderColor: 'orange',
                            backgroundColor: 'orange',
                        },
                    ],
                },
            });
        });
</script>
@endpush