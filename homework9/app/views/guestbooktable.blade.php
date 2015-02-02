@foreach ($guests as $guest)
<tr>
<td><input type='checkbox' value='{{ $guest->id  }}' name='ids' data-validatefunc='dummy'></td>
<td>{{ $guest->name }}</td>
<td>{{ $guest->age }}</td>
<td>{{ $guest->gender }}</td>
<td>{{ $guest->email }}</td>
</tr>
@endforeach