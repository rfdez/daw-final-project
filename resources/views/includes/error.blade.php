@if ($errors->any())

@foreach ($errors->all() as $error)

@push('scripts')
<script>
    $.notify({
        icon: "now-ui-icons ui-1_bell-53",
        message: @json($error)
        },{
            type: 'danger',
            timer: 8000,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
</script>
@endpush

@endforeach

@endif