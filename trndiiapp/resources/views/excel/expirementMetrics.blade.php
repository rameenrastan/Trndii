<table>
    <thead>
    <tr>
        <th>Experiment Name</th>
        <th>Number of Front Page Hits</th>
        <th>Number of Purchases</th>
        <th>Population</th>
        <th>Population %</th>
        {{--<th>{{$total_pop}} </th>--}}
    </tr>
    </thead>
    <tbody>
    @foreach($data as $expirement)
        <tr>
            <td>{{ $expirement->name }}</td>
            <td>{{ $expirement->front_page_hits }}</td>
            <td>{{ $expirement->number_purchases }}</td>
            <td>{{ $expirement->population_size }}</td>
            <td>{{ ($expirement->population_size)/$total_pop }}</td>
        </tr>
    @endforeach
    </tbody>
</table>