<div class="dataProductos">
    <canvas id="myChart3"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    Chart.register(ChartDataLabels);

    const productosMasVendidos = @json($productosMasVendidos);
    if (productosMasVendidos && productosMasVendidos.length > 0) {
        const etiquetas = productosMasVendidos.map(producto => producto.nombre_producto);
        const datos = productosMasVendidos.map(producto => producto.total);

        const ctx = document.getElementById('myChart3');

        new Chart(ctx, {
            type: 'donnut',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: 'Cantidad de Productos Vendidos',
                    data: datos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Productos Más Vendidos',
                        font: {
                            size: 18,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: (value) => value,
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            }
        });
    } else {
        console.error("No se encontraron datos para la gráfica de productos.");
    }
</script>