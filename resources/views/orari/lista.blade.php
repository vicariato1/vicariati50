@extends('layout')

@section('contentHeader')
@include('layoutHeader')
@stop



@section('content')


<div class="col-md-12 label label-primary" style="margin-top:-37px;">
    <h3>{!! Form::label(null, 'Orari Messe') !!}</h3>
</div>

<div class="col-md-12">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="col-md-2">Parrocchia</th>
                <th class="col-md-4">Festivo</th>
                <th class="col-md-2">Prefestivo</th>
                <th class="col-md-2">Feriale</th>
                <th class="col-md-2">Modificato da</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orari as $orario)
            <tr>
                <td>{!! $orario->nome !!} </td>
                <td>{!! $orario->orario_festivo !!} </td>
                <td>{!! $orario->orario_prefestivo !!} </td>
                <td>{!! $orario->orario_feriale !!} </td>
                <td>{!! $orario->nome_user . ' (' . date("d/m/y",strtotime($orario->updated_at)) . ')' !!} </td>
                @if (Session::get('utenteAutenticato') and ($orario->utenteAppartenenteAParrocchia  or Session::get('user')->admin == 1))
                <td>
                    <a href="{!! URL::to('orari_dettaglio',$orario->id) !!}"
                       class="btn btn-info btn-xs">Modifica</a>
                </td>
                @endif
            </tr>
            @endforeach

        </tbody>
    </table>
</div>


@stop