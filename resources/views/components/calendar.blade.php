<div id="{{ $id }}" class="calendar-component"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.initCalendar === 'function') {
        window.initCalendar('{{ $id }}', @json($disabledDates), @json($defaultDate));
    }
});
</script>
