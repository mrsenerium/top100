@extends('emails.master')

@section('body')
    <p>{{$candidate->fullname}}</p>
    @if(isset($body))
        {!! $body !!}
    @endif

    Your submission:
    <p>
        <strong>Additional Majors:</strong> {{$response->additional_majors or 'N / A'}}
        <br/>
        <strong>Academic Honors:</strong> {{$response->academic_honors or 'N / A'}}
    </p>
    <strong>{{AppSettings::getReflectionQuestion()}}</strong><br/>
    {!! $response->reflection !!}
    <p><strong>Organizations:</strong></p>
    <table>
        <caption>Activities &amp; Leadership</caption>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Position Held</th>
            <th>Length of Involvement</th>
        </tr>
        @forelse($activities as $org)
            <tr>
                <td>{{$org['name']}}</td>
                <td>{{$org['description']}}</td>
                <td>{{$org['position_held']}}</td>
                <td>{{$org['involvement_length']}} {{$org['involvement_duration']}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">No activities entered.</td>
            </tr>
        @endforelse
    </table>
    <table>
        <caption>Services</caption>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Position Held</th>
            <th>Length of Involvement</th>
        </tr>
        @forelse($services as $org)
            <tr>
                <td>{{$org['name']}}</td>
                <td>{{$org['description']}}</td>
                <td>{{$org['position_held']}}</td>
                <td>{{$org['involvement_length']}} {{$org['involvement_duration']}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">No services entered.</td>
            </tr>
        @endforelse
    </table>

@endsection
