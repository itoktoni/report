<link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">
<script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>
<script>
$('.date').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  minYear: 1901,
  maxYear: 2030,
  locale: {
        format: 'YYYY-MM-DD'
    },
});
</script>