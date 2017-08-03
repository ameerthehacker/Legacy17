@if(Session('info'))
    <ul class="collection">
        <li class="collection-item">
            <p class="flow-text center-align green-text">
                {{ Session('info') }}                
            </p>
        </li>
    </ul>
@endif
@if(Session('success'))
    <script>
        Materialize.toast("{{ Session('success') }}", 8000);
    </script>
@endif