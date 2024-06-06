
@extends('pdf.test.layout')
@section('content')
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th style="
                width: 200px;
            ">Course</th>
            <th>Cycle</th>
            <th> Credits</th>
            <th>Hours</th>
            <th>Teacher</th>
        </tr>
    </thead>
    <tbody>
 
        @foreach(range(1, 20) as $index)
            @foreach($courses as $course)
            <tr>
                <td>{{ $course['id'] }}</td>
                <td>{{ $course['course'] }}</td>
                <td>{{ $course['cycle'] }}</td>
                <td>{{ $course['credits'] }}</td>
                <td>{{ $course['hours'] }}</td>
                <td>{{ $course['teacher'] }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

@endsection