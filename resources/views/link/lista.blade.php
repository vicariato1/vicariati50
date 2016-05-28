@extends('layout')

@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-4">
</div>

<div class="col-md-4">
    <table class="table table-striped  table-condensed">
        <tbody>
            @foreach($links as $link)
            <tr>
                <td></td>
                <td class="text-left">{!! HTML::link($link->link, $link->titolo_link) !!}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-4">
</div>


@stop


