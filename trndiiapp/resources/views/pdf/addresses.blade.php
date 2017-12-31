

@foreach($data as $user)
    <p>{{ $user->name }} </p>
    <p>{{ $user->addressline1 }} </p>
    <p>{{ $user->postalcode }} </p>
    <p>{{ $user->country }} </p>
    <br/>
    <br/>
@endforeach


