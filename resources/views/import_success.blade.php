@include('heading')
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">
    <div class="row" style="width: 50%">
        <a style="margin: auto" type="button" class="btn btn-outline-primary" href="{{ route('index') }}">Back</a>
        @if (count($calculations) > 0)
        <table style="margin-top: 20px" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Customer</th>
                <th scope="col">Total amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($calculations as $customer => $amount)
            <tr>
                <td>{{$customer}}</td>
                <td>{{$amount . " " . $currency}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <div class="row" style="width: 100%">
                <div style="width: 50%; margin: auto">No data</div>
            </div>
        @endif
    </div>
</div>
