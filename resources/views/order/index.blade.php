<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <script defer src="/order/script.js"></script>
</head>
<body>
<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form>
        @csrf
        <label> выберите компанию
            <select class="req-input"
                    name="company_id"
                    oninput="calculate()"
                    required>
                <option value=''></option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">
                        {{$company->name .' стоимость за перевозку 1кг на 1км - '.$company->cost.' руб'}}
                    </option>
                @endforeach
            </select>
        </label>
        <br>
        <label> введите вес груза от 30 до 100000 кг
            <input class="req-input"
                   oninput="calculate()"
                   type="number"
                   placeholder="вес груза"
                   name="weight"
                   min="{{$minWeight}}"
                   max="{{$maxWeight}}"
                   required>
        </label>
        <br>
        <label> введите дальность
            <input class="req-input"
                   oninput="calculate()"
                   type="number"
                   placeholder="дальность перевозки"
                   name="distance"
                   required>
        </label>
        <br>
        <div class="amount">стоимость перевозки:</div>
        <button type="submit">Сохранить расчет</button>
    </form>
</div>
</body>
</html>
