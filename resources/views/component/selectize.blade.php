@push('footer')
<script src="{{ url('assets/js/selectize.min.js') }}"></script>
<script>
  $("select").selectize({
      plugins: ["remove_button"],
  });
</script>
@endpush