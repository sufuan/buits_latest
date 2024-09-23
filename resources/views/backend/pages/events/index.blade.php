@extends('backend.layouts.master')

@push('css')
<!-- <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'> -->
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    #calendar a {
        text-decoration: none;
        color: #000000;
    }
</style>
@endpush

@section('admin-content')

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

    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="eventForm">
                    <div class="modal-body">
                        <input type="hidden" id="eventId" name="eventId">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="is_all_day" class="form-check-label">All Day</label>
                            <input type="checkbox" id="is_all_day" name="is_all_day" value="true">
                        </div>
                        <div class="mb-3">
                            <label for="startDateTime" class="form-label">Start Date/Time</label>
                            <input type="text" class="form-control datetimepicker" id="startDateTime" name="startDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="endDateTime" class="form-label">End Date/Time</label>
                            <input type="text" class="form-control datetimepicker" id="endDateTime" name="endDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between w-100">
                            <!-- Left Section: "Details" Button -->
                            <button type="button" class="btn btn-secondary" id="detailsButton" style="display: none;">Details</button>

                            <!-- Right Section: Close, Save, Delete Buttons -->
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="saveEvent">Save</button>
                                <button type="button" class="btn btn-danger" id="deleteEvent" style="display: none;">Delete</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
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

            eventClick: function(info) {
                const event = info.event;
                document.getElementById('eventId').value = event.id;
                document.getElementById('title').value = event.title;
                document.getElementById('is_all_day').checked = event.allDay;

                // Format start date
                const startDate = new Date(event.start);
                const formattedStartDate = event.allDay ?
                    startDate.toISOString().slice(0, 10) :
                    startDate.toISOString().slice(0, 16).replace('T', ' ');
                document.getElementById('startDateTime').value = formattedStartDate;

                // Format end date
                const endDate = event.end ? new Date(event.end) : startDate;
                const formattedEndDate = event.allDay ?
                    endDate.toISOString().slice(0, 10) :
                    endDate.toISOString().slice(0, 16).replace('T', ' ');
                document.getElementById('endDateTime').value = formattedEndDate;

                document.getElementById('description').value = event.extendedProps.description;

                initializeStartDateEndDateformart(event.allDay);

                document.getElementById('deleteEvent').style.display = 'inline-block';
                document.getElementById('detailsButton').style.display = 'inline-block';

                eventModal = new bootstrap.Modal(document.getElementById('eventModal'), {
                    keyboard: false
                });
                eventModal.show();
            }
        });

        calendar.render();

        eventForm = document.getElementById('eventForm');
        eventForm.addEventListener('submit', function(event) {
            event.preventDefault();
            saveEvent();
        });

        document.getElementById('deleteEvent').addEventListener('click', function() {
            deleteEvent();
        });

        // Details button click listener
        document.getElementById('detailsButton').addEventListener('click', function() {
            const eventId = document.getElementById('eventId').value;
            if (eventId) {

                const url = `{{ url('admin/events/${eventId}/details') }}`;
                window.location.href = url;
            } else {
                alert('No event selected!');
            }
        });
    });

    function initializeStartDateEndDateformart(allday) {
        let format = allday ? 'Y-m-d' : 'Y-m-d H:i';
        let timepicker = !allday;
        $('#startDateTime').datetimepicker({
            format: format,
            timepicker: timepicker
        });
        $('#endDateTime').datetimepicker({
            format: format,
            timepicker: timepicker
        });
    }

    document.getElementById('is_all_day').addEventListener('change', function() {
        const allday = this.checked;
        $('.datetimepicker').datetimepicker('destroy');
        initializeStartDateEndDateformart(allday);
    });

    function clearModalInputs() {
        document.getElementById('eventId').value = '';
        document.getElementById('title').value = '';
        document.getElementById('is_all_day').checked = false;
        document.getElementById('startDateTime').value = '';
        document.getElementById('endDateTime').value = '';
        document.getElementById('description').value = '';

        document.getElementById('deleteEvent').style.display = 'none';
    }

    function saveEvent() {
        const eventId = document.getElementById('eventId').value;
        const url = eventId ? `{{ url('admin/events') }}/${eventId}` : '{{ route("events.store") }}';
        const method = eventId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                title: document.getElementById('title').value,
                is_all_day: document.getElementById('is_all_day').checked ? 1 : 0,
                startDate: document.getElementById('startDateTime').value,
                endDate: document.getElementById('endDateTime').value,
                description: document.getElementById('description').value,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.success);
                eventModal.hide(); // Close the modal
                calendar.refetchEvents(); // Reload the events
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMessage = '';
                    Object.values(errors).forEach((error) => {
                        errorMessage += `${error[0]}\n`;
                    });
                    alert(errorMessage);
                } else {
                    alert('An error occurred while saving the event.');
                }
            }
        });
    }

    function deleteEvent() {
        const eventId = document.getElementById('eventId').value;
        if (!eventId) {
            return;
        }

        if (confirm('Are you sure you want to delete this event?')) {
            $.ajax({
                url: `{{ url('admin/events') }}/${eventId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.success);
                    eventModal.hide(); // Close the modal
                    calendar.refetchEvents(); // Reload the events
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the event.');
                }
            });
        }
    }
</script>
@endpush