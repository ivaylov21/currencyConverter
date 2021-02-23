@include('heading')
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">
    <form method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="import">Upload file</label>
                <input type="file" class="form-control" id="import" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="csv_file" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="filter">For specific customer (VAT number)</label>
                <input type="text" class="form-control" id="filter" name="filter">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="currency">Output currency</label>
                <select class="form-control" id="currency" name="currency" required>
                    @foreach (\Illuminate\Support\Facades\Config::get('constants.currencies') as $val)
                        <option value="{{$val}}">{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="header">With Header Row</label>
                <input type="checkbox" id="header" name="header">
            </div>
        </div>
        @isset($validationErr)
        <div class="form-row">
            <div class="alert alert-danger" role="alert">
                {{$validationErr}}
            </div>
        </div>
        @endisset
        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>
</div>
