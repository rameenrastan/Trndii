<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Postal Code</th>
        <th>Country</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->addressline1 }}</td>
            <td>{{ $user->postalcode }}</td>
            <td>{{ $user->country }}</td>

        </tr>
    @endforeach
    </tbody>
</table>