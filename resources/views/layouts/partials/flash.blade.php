@if(Session('success'))
    <script>
        Materialize.toast("{{ Session('success') }}", 3000);
    </script>
@endif