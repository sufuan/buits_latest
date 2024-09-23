@extends('layouts.app')
@section('head')
<title>{{__('Form Builder')}}</title>
@endsection

@section('content')<!-- <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'> -->
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    #calendar a {
        text-decoration: none;
        color: #000000;
    }
</style>


<main>
    <div class="container mt-3">
        <div class="row">
            <div class="">
                <div class="">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>


</main>
@endsection

@section('script')
<!-- <script src="{{ URL::asset('assets/js/jquery-3.7.1.min.js') }}"></script> -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var calendar = null;
    var eventModal = null;
    var eventForm = null;

    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'Asia/Dhaka',

            themeSystem: 'bootstrap5',
            initialView: 'dayGridMonth',
            initialDate: new Date(),

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',

            },


            events: "{{ route('events.refetch') }}", // Load events from the refetch route

            dateClick: function(info) {
                clearModalInputs();
                eventModal = new bootstrap.Modal(document.getElementById('eventModal'), {
                    keyboard: false
                });
                eventModal.show();
                document.getElementById('startDateTime').value = info.dateStr;
                initializeStartDateEndDateformart(document.getElementById('is_all_day').checked);
            },




        });
        calendar.render();


    });
</script>
@endsection