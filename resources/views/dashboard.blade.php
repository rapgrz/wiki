@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/comments.css') }}" />
@endpush
@section('content')
    @if(Auth::user()->access_level == 10)
        <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
            <h2>
                Dashboard
            </h2>
            <hr>
                    <div>
            </div>
            <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body alert-warning">
                        <input type="hidden" id="data_uri" value="{{ route('postsInThisMonth', ['range' => $range]) }}">
                        <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total posts &nbsp;&nbsp;<strong><div class="counter d-inline float-right" data-count="{{$posts->count()}}">0</div></strong>
                        </div>
                    </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body alert-warning">
                        <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total comments &nbsp;&nbsp;<strong><div class="counter d-inline float-right" data-count="{{$comments->count()}}">0</div></strong>
                        </div>
                    </div>
            </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body alert-warning">
                            <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total categories &nbsp;&nbsp;<strong><div class="counter d-inline float-right" data-count="{{$categories->count()}}">0</div></strong>
                        </div>
                    </div>
                </div>
             <div class="col">
                 <div class="card">
                     <div class="card-body alert-warning">
                         <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total users &nbsp;&nbsp; <strong><div class="counter d-inline float-right" data-count="{{$users->count()}}">0</div></strong>
                         </div>
                     </div>
             </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="card">
                            <div class="card-body alert-warning">
                                <img src="{{URL::asset('images/title_logo.png')}}"  height="40" width="40"/>&nbsp;
                                Latest post &nbsp;<br> <strong>{!! str_limit(html_entity_decode($latestPost->title), 40) !!}</strong><br>
                                Comments &nbsp; <strong>{{$latestPost->comment->count()}}</strong><br>
                                By &nbsp; <strong>{{$latestPost->user->name}}</strong><br>
                                <div class="float-right"><i>{{$latestPost->created_at->diffForHumans()}}</i></div>
                                </div>
                            </div>
                        </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body alert-warning">
                                <img src="{{URL::asset('images/comment_logo.png')}}"  height="23" width="23"/>&nbsp;
                                Latest comment <br><strong>{!! str_limit(html_entity_decode($latestComment->content), 105) !!}</strong><br>
                                On <strong>{!! str_limit(html_entity_decode($latestComment->post->title), 40) !!}</strong><br>
                                Commented by <strong>{{$latestComment->user->name}}</strong>
                                <div class="float-right"><i>{{$latestComment->created_at->diffForHumans()}}</i></div>
                                </div>
                            </div><br><br><br><br>
                    </div>
        </div>
                </div>
            </div>
            <div class="row">
                <div class="float-right">
                    Days shown:&nbsp;
                    <form action="{{route('dashboard')}}" id="range" method="POST" class="d-inline">
                        {{ csrf_field() }}
                    <select id="range" name="range" onchange="this.form.submit()">
                        <option value="-29" @if($range === '-29') selected @endif>30</option>
                        <option value="-59" @if($range === '-59') selected @endif>60</option>
                        <option value="-89" @if($range === '-89') selected @endif>90</option>
                    </select>
                        </form>
                </div>
            </div>
            <div class="row">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <br><br>
            </div>
        @else
        You have no permission to see this.
    @endif

@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://localhost/wiki/node_modules/chart.js/dist/Chart.js"></script>
<script type='text/javascript'>
    $(document).ready(function(){
        /*var daysInMonth = function daysInThisMonth() {
            var now = new Date();
            return new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
        };
        var days = daysInMonth();
        var allDays = [];
        for(var i = 1; i <= days; i++){
            allDays.push(i);
        }*/
        var range = -29;
        var uri = $("#data_uri").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var req = $.ajax({
                    method: "POST",
                    url: uri,

                    success: function(data){
                        var labels = [];
                        var dt = [];

                        $.each( data.dates, function( key, value ) {
                           labels.push(key);
                           dt.push(value);
                        });
                       // console.log(dt);
                        //console.log(data);
                        var ctx = document.getElementById("myChart").getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Posts by day',
                                    data: dt,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor:  'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }],
                                fill: false
                            },

                            options: {
                                scales: {
                                    xAxes: [{
                                        display: true,
                                        scaleLabel:{
                                            display: true,
                                            labelString: 'Day'
                                        },
                                        ticks: {
                                            autoSkip:false
                                        }
                                    }],
                                    yAxes: [{
                                        display: true,
                                        scaleLabel:{
                                            display: true,
                                            labelString: 'Posts'
                                        },
                                        ticks: {
                                            beginAtZero:true
                                        }
                                    }]
                                }
                            }
                        });
                    }
        })
    });

</script>
<script>
    $('.counter').each(function() {
        var $this = $(this),
                countTo = $this.attr('data-count');

        $({ countNum: $this.text()}).animate({
                    countNum: countTo
                },

                {

                    duration: 1000,
                    easing:'linear',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }

                });
    });
    </script>
@endpush