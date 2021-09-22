@if (session('status'))

@push('scripts')
<script>
    $.notify({
    icon: "now-ui-icons ui-1_bell-53",
    message: @json(session('status'))
  },{
      type: 'success',
      timer: 8000,
      placement: {
          from: 'top',
          align: 'right'
      }
  });
</script>
@endpush

@endif