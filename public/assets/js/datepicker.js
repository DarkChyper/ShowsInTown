$('.js-datepicker').datepicker({
    format: "{{  'datepicker.locale.date' | trans }}",
    weekStart: 1,
    startView: 0,
    maxViewMode: 2,
    autoclose: true,
    todayBtn: "linked",
    language: "{{ app.request.locale }}",
    orientation: "bottom auto",
    daysOfWeekHighlighted: "0",
    calendarWeeks: true,
    todayHighlight: true
});