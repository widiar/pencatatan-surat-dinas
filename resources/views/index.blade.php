@extends('template.master')

@section('title', 'Dashboard')
    

@section('main-content')
<div class="row">
    <div class="col-md-6 mt-5 mb-3">
        <div class="card">
            <div class="seo-fact sbg1">
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <div class="seofct-icon"><i class="ti-thumb-up"></i> Likes</div>
                    <h2>2,315</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mt-md-5 mb-3">
        <div class="card">
            <div class="seo-fact sbg2">
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <div class="seofct-icon"><i class="ti-share"></i> Share</div>
                    <h2>3,984</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <!-- start amcharts -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <!-- all line chart activation -->
    <script src="{{ asset('js/line-chart.js') }}"></script>
    <!-- all pie chart -->
    <script src="{{ asset('js/pie-chart.js') }}"></script>
    <!-- all bar chart -->
    <script src="{{ asset('js/bar-chart.js') }}"></script>
    <!-- all map chart -->
    <script src="{{ asset('js/maps.js') }}"></script>
    <!-- others plugins -->
@endsection