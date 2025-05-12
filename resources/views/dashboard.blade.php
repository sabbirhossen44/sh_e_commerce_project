@extends('layouts.admin')
@section('content')
    <h4>Welcome To Dashboard, <span class="text-primary">{{Auth::user()->name}}</span></h4>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Last 30 days Order</h3>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Last 30 days Sales Amount</h3>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script>
        const ctx = document.getElementById('myChart');
        var total_order = {{ Js::from($total_order_info)}}
            var order_date = {{ Js::from($order_date_info)}}

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: order_date,
                    datasets: [{
                        label: 'Total Order',
                        data: total_order,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
    </script>

    <script>
        const sales = document.getElementById('myChart2');
        var total_sales = {{ Js::from($total_sales_info)}}
            var dales_date = {{ Js::from($sales_date_info)}}

            new Chart(sales, {
                type: 'pie',
                data: {
                    labels: dales_date,
                    datasets: [{
                        label: 'Total Order',
                        data: total_sales,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
    </script>
@endsection