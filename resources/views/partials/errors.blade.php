@if($errors->any())
    <div class="collection with-header">
        <ul>
            <li class="collection-header">
                <h5 class="red-text">Fix the following errors to proceed</h5>
            </li>
            @foreach($errors->all() as $error)
                <li class="collection-item">
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif