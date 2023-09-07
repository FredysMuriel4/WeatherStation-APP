@extends('base')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                            <b> Consultation History </b>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    name="from"
                                    id="from"
                                    value="{{request('from')}}"
                                >
                            </div>
                            <div class="col-md-3">
                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    name="to"
                                    id="to"
                                    value="{{request('to')}}"
                                >
                            </div>
                            <div class="col-md-3 d-flex justify-content-start align-items-center">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary"
                                >
                                    <i class="fad fa-search"></i>
                                </button>
                                &nbsp;
                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger"
                                    id="reset"
                                >
                                    <i class="fad fa-trash-restore"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-sm-xl-lx-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col"> Date </th>
                                        <th scope="col"> City </th>
                                        <th scope="col"> Humidity </th>
                                        <th scope="col"> Temperature </th>
                                        <th scope="col"> General </th>
                                        <th scope="col"> Description </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $item)
                                    <tr class="text-center">
                                        <td> {{ date('d-M-Y', strtotime($item->created_at)) }} </td>
                                        <td> {{ $item->consult['name'] }} </td>
                                        <td> {{ $item->consult['main']['humidity'].'%' }} </td>
                                        <td>
                                            {{  '+'.$item->celcius_temp.'°C' }}
                                            &nbsp;
                                            {{  '+'.$item->fahrenheit_temp.'°F' }}
                                        </td>
                                        <td> {{ $item->consult['weather'][0]['main'] }} </td>
                                        <td> {{ $item->consult['weather'][0]['description'] }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-2">
                        {{ $history->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

    <script>
        let reset = document.getElementById('reset');
        if(reset) {
            reset.addEventListener('click', () => {
                location.href="/weather/history";
            })
        }
    </script>

@endpush
