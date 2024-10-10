@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-title mt-3" >
                    <center><h5>Grafik Persentase KPI Karyawan </h5></center>
                </div>
                <div class="card-body">
                    <canvas id="kpiChart"></canvas>
                </div>
            </div>    
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-title mt-3" >
                    <center><h5>Grafik Persentase Tasklist Ontime/Late</h5></center>
                </div>
                <div class="card-body">
                    <canvas id="tasklistChart"></canvas>
                </div>
            </div>    
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-title mt-3" >
                    <center><h5>Grafik Detail Sales</h5></center>
                </div>
                <div class="card-body">
                    <canvas id="detailSalesChart"></canvas>
                </div>
            </div>   
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-title mt-3" >
                    <center><h5>Grafik Detail Report</h5></center>
                </div>
                <div class="card-body">
                    <canvas id="detailReportChart"></canvas>
                </div>
            </div>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-title mt-3" >
                    <center><h5>Grafik Tasklist Ontime/Late</h5></center>
                </div>
                <div class="card-body">
                    <canvas id="taskChart"></canvas>
                </div>
            </div>   
        </div>
    </div>
</div>
    <script>
        var ctx = document.getElementById('detailSalesChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [@foreach ($kpiData as $data) '{{ $data->Nama }}', @endforeach],
                datasets: [
                   
                    {
                        label: 'Target Sales',
                        data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->TargetSales) }}, @endforeach],
                        backgroundColor: 'rgba(255, 206, 86, 0.2)', 
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Actual Sales',
                        data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->ActualSales) }}, @endforeach],
                        backgroundColor: 'rgba(153, 102, 255, 0.2)', 
                        borderColor: 'rgba(153, 102, 255, 1)', 
                        borderWidth: 1
                    },
                     {
                        label: 'Late Sales',
                        data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->LateSales) }}, @endforeach],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Persentase'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Karyawan'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false 
            }
        });
    </script>

<script>
    var ctx = document.getElementById('detailReportChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [@foreach ($kpiData as $data) '{{ $data->Nama }}', @endforeach],
            datasets: [
               
                {
                    label: 'Target Report',
                    data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->TargetReport) }}, @endforeach],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)', 
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Actual Report',
                    data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->ActualReport) }}, @endforeach],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)', 
                    borderColor: 'rgba(153, 102, 255, 1)', 
                    borderWidth: 1
                },
                 {
                    label: 'Late Report',
                    data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->LateReport) }}, @endforeach],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Persentase'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Karyawan'
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false 
        }
    });
</script>

<script>
    var ctx = document.getElementById('kpiChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [@foreach ($kpiData as $data) '{{ $data->Nama }}', @endforeach],
            datasets: [
               
                {
                    label: 'Total Bobot Sales',
                    data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->TotalBobotSales) }}, @endforeach],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)', 
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Bobot Report',
                    data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->TotalBobotReport) }}, @endforeach],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)', 
                    borderColor: 'rgba(153, 102, 255, 1)', 
                    borderWidth: 1
                },
                 {
                    label: 'Pencapaian KPI',
                    data: [@foreach ($kpiData as $data) {{ str_replace('%', '', $data->kpi) }}, @endforeach],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Persentase'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Karyawan'
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false 
        }
    });
</script>
    
   <script>
    var ctx = document.getElementById('tasklistChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [@foreach ($tasklist as $data) '{{ $data->namakaryawan }}', @endforeach],
            datasets: [
                
                {
                    label: 'Ontime Percentage',
                    data: [@foreach ($tasklist as $data) {{ str_replace('%', '', $data->ontimepercentage) }}, @endforeach],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Late Percentage',
                    data: [@foreach ($tasklist as $data) {{ str_replace('%', '', $data->latepercentage) }}, @endforeach],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Percentage'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Karyawan'
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false 
        }
    });
</script>

<script>
    var ctx = document.getElementById('taskChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [@foreach ($tasklist as $data) '{{ $data->namakaryawan }}', @endforeach],
            datasets: [
                
            {
                    label: 'Total Task',
                    data: [@foreach ($tasklist as $data) {{ str_replace('%', '', $data->total_task) }}, @endforeach],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)', 
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Ontime',
                    data: [@foreach ($tasklist as $data) {{ str_replace('%', '', $data->ontime) }}, @endforeach],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)', 
                    borderColor: 'rgba(153, 102, 255, 1)', 
                    borderWidth: 1
                },
                
                {
                    label: 'Late',
                    data: [@foreach ($tasklist as $data) {{ str_replace('%', '', $data->late) }}, @endforeach],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Percentage'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Karyawan'
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false 
        }
    });
    
</script>

@endsection