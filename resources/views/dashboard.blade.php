@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a href="{{route('dashboard')}}">Dashboard</a></li>
        </ol>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="container">
                <main class="mx-auto m-4">
                    <div class="row">
                        <div class="cardBox">
                            <div class="card">
                                <div>
                                    <div class="numbers">{{$customerCount == null ? 0 : $customerCount}}</div>
                                    <div class="cardName">Customers</div>
                                </div>
                                <div class="iconBox">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="card">
                                <div>
                                    <div class="numbers">{{$reservationCount  == null ? 0 : $reservationCount}}</div>
                                    <div class="cardName">Room Reservations</div>
                                </div>
                                <div class="iconBox">
                                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="card">
                                <div>
                                    <div class="numbers">1000</div>
                                    {{-- <div class="numbers">{{$contactCount}}</div> --}}
                                    <div class="cardName">Enquires</div>
                                </div>
                                <div class="iconBox">
                                    <i class="fa fa-comment" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="card">
                                <div>
                                    <div class="numbers">10000</div>
                                    {{-- <div class="numbers">Rs.{{$total}}</div> --}}
                                    <div class="cardName">Earnings</div>
                                </div>
                                <div class="iconBox">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 bg-white bg-shadow">
                            <div class="row  bg-white ">
                                <h5>Room Reservations</h5>
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row  bg-white ">
                                <h5>Liquor Sales</h5>
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(function() {
//Bar Chart------------------------------------------------------------
    let datas = {!! json_encode($barDatas) !!}
    let labelValues = Object.keys(datas).map((key) => [key]);
    let dataValues = Object.keys(datas).map((key) => datas[key]);
    let barCanvas = $('#barChart');
    let barChart = new Chart(barCanvas,{
        type:'bar',
        data:{
            labels:labelValues,
            datasets:[
                {
                   label:'Collections per Category',
                   data: dataValues
                }
            ]
        },
        options:{
            scales:{
                yAxes:[{
                    ticks:{
                        beginAtZero: true
                    }
                }]
            }
        }
    });

//Pie Chart ---------------------------------------------------------------------------------
    let pieDatas = {!! json_encode($pieDatas) !!};
    let pielabelValues = Object.keys(pieDatas).map((key) => [key]);
    let piedataValues = Object.keys(pieDatas).map((key) => pieDatas[key]);

    let pieCanvas = $('#pieChart');
    let pieLabels = pielabelValues;
    let colors = [];
    for(let i=0;i<pieLabels.length;i++){
      colors.push('#'+Math.floor(Math.random()*16777215).toString(16));
    }
    let pieDatasets = [{
        label: 'Room Reservations',
        data: piedataValues,
        backgroundColor: colors,
        hoverOffset: 4
    }]
    let PieChart = new Chart(pieCanvas,{
        type: 'doughnut',
        data:{
            labels:pieLabels,
            datasets: pieDatasets
        },
    });
})
</script>
@endpush
