@extends('master')
@section('title', 'Overview')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                <strong><i class="fa fa-info-circle fa-fw"></i> Important!</strong> This system will be reset on the next code commit. Avoid saving important information here.
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-car"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Registered Cars</span>
                    <span class="info-box-number">1,410</span>
                    <!-- /.info-box-content -->
                    <span class="progress-description">
                        <a href="{{ URL('/cars') }}">View All &raquo;</a>
                    </span>
                </div>

            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Issued Invoices</span>
                    <span class="info-box-number">13,648</span>
                  <span class="progress-description">
                    <a href="{{ URL('/invoices') }}">View All &raquo;</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Sales - {{ date("F") }}</span>
                    <span class="info-box-number">41,410</span>

                  <span class="progress-description">
                    <a href="{{ URL('/sales') }}">View All &raquo;</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-minus-square"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Purchases - {{ date("F") }}</span>
                    <span class="info-box-number">41,410</span>

                  <span class="progress-description">
                    <a href="{{ URL('/purchases') }}">View All &raquo;</a>
                  </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-sticky-note fa-fw"></i> Personal Notes</h3>
                </div>
                <div class="box-body">
                    @include('partials.alerts')
                    <form action="/notes" method="post">
                        {!! csrf_field() !!}
                        <textarea name="notes" id="ck" class="form-control" rows="7">{{ $user->notes }}</textarea>
                        <div class="text-center top-padded">
                            <input type="submit" value="Save Notes" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link href="{{ asset("/bower_components/fullcalendar/dist/fullcalendar.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script src="{{ asset("/bower_components/ckeditor/ckeditor.js") }}" type="text/javascript"></script>
<script>
    CKEDITOR.replace('ck', {
        height: '400px',
    });
</script>
<script src="{{ asset("/bower_components/moment/min/moment.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("/bower_components/fullcalendar/dist/fullcalendar.min.js") }}" type="text/javascript"></script>
<script>
    $(function() {
        // Navigation
        $('li.overview').addClass('active');

        $('#calendar').fullCalendar({
            height: "auto",
        });
    })
</script>
@endsection