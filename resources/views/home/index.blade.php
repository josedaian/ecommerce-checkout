@extends('layouts.layout')

@section('title', 'Mundo Libros | Tienda Online de Libros')

@section('content')
    <div class="jumbotron">
        <h3 class="display-5">Complete su donación</h3>
        <p class="lead">A continuación, ingrese la cantidad que le gustaria donar</p>
        <hr class="my-4">

        @if (isset($donation))
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if( !empty(Request::get('pay-debt')))
                                <div class="alert alert-success" role="alert">
                                    <i class="fa fa-info" aria-hidden="true"></i> El pago para la referencia {{ Request::get('doc_id') }} ha sido registrado
                                </div>
                            @endif
                            @if (isset($donation->message))
                                <div class="alert alert-primary" role="alert">
                                    <i class="fa fa-info" aria-hidden="true"></i> {{ $donation->message }}
                                </div>
                            @endif  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="col-12">
                                <label> Nro. Cédula de Identidad: <span class="text-muted">{{ $donation->data->debt->docId }}</span></label>
                            </div>
                            <div class="col-12">
                                <label> Concepto: <span class="text-muted">{{ $donation->data->debt->label }}</span></label>
                            </div>
                            <div class="col-12">
                                <label> Importe: <span class="text-muted">{{ number_format($donation->data->debt->amount->value, 2, ',', '.') }} {{ $donation->data->debt->amount->currency }}</span></label>
                            </div>
                            <div class="col-12">
                                <label> Pagado: <span class="text-muted">{{ number_format($donation->data->debt->amount->paid, 2, ',', '.') }} {{ $donation->data->debt->amount->currency }}</span></label>
                            </div>
                            <div class="col-12">
                                <img src="{{ $donation->data->debt->payUrl }}/qr" class="img-fluid" width="40%" alt="{{ $donation->data->debt->docId }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="col-12">
                                <label> Estado: <span class="badge bg-primary text-light">{{ (isset($donation->local->transaction)) ? $donation->local->transaction->status : $donation->data->debt->payStatus->status }}</span></label>
                            </div>
                            <div class="col-12">
                                <label> Válido Desde: <span class="text-muted">@customDateFormat($donation->data->debt->validPeriod->start)</span></label>
                            </div>
                            <div class="col-12">
                                <label> Válido Hasta: <span class="text-muted">@customDateFormat($donation->data->debt->validPeriod->end)</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <a target="_blank" href="{{ $donation->data->debt->payUrl }}" class="btn btn-success"><i class="fas fa-external-link-alt"></i> Pagar ahora</a>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {!! Form::open(['route' => 'donations.store' , 'method' => 'POST', 'role' => 'form', 'id' => 'donation-form']) !!}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if(!empty($transaction))
                                @switch($transaction->status)
                                    @case('pending')
                                        <div class="alert alert-warning" role="alert">
                                            <i class="fa fa-info" aria-hidden="true"></i> Atención! El pago para la referencia {{ $request['doc_id'] }} sigue pendiente
                                        </div>
                                        
                                        @break
                                    @case('paid')
                                        <div class="alert alert-success" role="alert">
                                            <i class="fa fa-info" aria-hidden="true"></i> El pago para la referencia {{ $request['doc_id'] }} ha sido registrado
                                        </div>
                                        
                                        @break
                                    @default
                                        
                                @endswitch
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            {!! Form::label('document', 'Nro. de Cédula de Identidad') !!}
                            {!! Form::text('document', null, ['class' => 'form-control', 'id' => 'document', 'placeholder' =>  'Ingrese el nro de cédula de identidad']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('amount', 'Cantidad a donar') !!}
                            {!! Form::text('amount', null, ['class' => 'form-control', 'id' => 'amount', 'placeholder' =>  'Ingrese el importe a donar']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('concept', 'Concepto') !!}
                            {!! Form::text('concept', 'Donación', ['class' => 'form-control', 'id' => 'concept', 'placeholder' =>  'Ingrese el concepto del pago']) !!}
                        </div>
                    </div>
                    <div class="row">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-md" type="submit">Continuar</button>
                </div>
            </div>
            {!! Form::close() !!}
            
        @endif
    </div>
@endsection

@section('js')
    <script>
        $(function(){
            // validación del formulario
            $('#donation-form').validate({
                rules: {
                    'amount': {
                        required: true
                    },
                    'document': {
                        required: true
                    },
                    'concept': {
                        required: true
                    },
                },
                messages: {
                    'amount': {
                        required: "Debe ingresar un importe para poder realizar una donacion"
                    },
                    'document': {
                        required: "El Nro. Cédula de Identidad es requerido"
                    },
                    'concept': {
                        required: "El concepto es requerido"
                    },
                },
                errorPlacement: function(error, element){
                    error.appendTo(element.parent());
                },
                /* submitHandler: function(form){
                    $('#detalle tbody tr.fila').each(function(index, valor){
                        var secuencia = $(this).attr('secuencia');
                        var tarifaTotalElement = AutoNumeric.getAutoNumericElement('#total_producto'+secuencia);
                        var tarifaElement = AutoNumeric.getAutoNumericElement('#tarifa'+secuencia);
                        var cantidadElement = AutoNumeric.getAutoNumericElement('#cantidad'+secuencia);
                        var montoDescuentoElement = AutoNumeric.getAutoNumericElement('#monto_descuento'+secuencia);

                        $('#total_producto'+secuencia).val(tarifaTotalElement.getNumber());
                        $('#tarifa'+secuencia).val(tarifaElement.getNumber());
                        $('#cantidad'+secuencia).val(cantidadElement.getNumber());
                        $('#monto_descuento'+secuencia).val(montoDescuentoElement.getNumber());
                    });

                    form.submit();
                } */
            });
        })
    </script>
@endsection