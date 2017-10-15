@if(session('success'))
    <div class="alert alert-success" role="alert">
        <strong>Success:</strong>{{session('success')}}
    </div>

    @endif

@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">

        <strong>Errors</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
        </ul>
    </div>

@endif
