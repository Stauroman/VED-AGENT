<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
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
            <select class="req-input" name="company_id" oninput="calculate()" required>
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
                   min="30.00"
                   max="100000.00"
                   step="0.01"
                   required>
        </label>
        <br>
        <label> введите дальность
            <input class="req-input" oninput="calculate()" type="number" placeholder="дальность перевозки"
                   name="distance" required>
        </label>
        <br>
        <div class="amount">стоимость перевозки:</div>
        <button type="submit">Сохранить расчет</button>
    </form>
</div>
</body>
</html>
<script>
    const form = document.querySelector("form");
    const amountDiv = document.querySelector('.amount');

    if (form) {
        form.addEventListener("submit", handleFormSubmit);
    }

    async function calculate() {
        if (checkInputs()) {
            try {
                const response = await fetch("/api/calculate", {
                    method: "POST",
                    body: new FormData(form)
                })
                const result = await response.json();
                const amount = result.amount;
                if (amount) {
                    setAmountText(amount);
                } else if (result.message) {
                    alert(result.message);
                }
            } catch (e) {
                alert(e);
            }
        }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();
        try {
            const response = await fetch("/api/order", {
                method: "POST",
                body: new FormData(form)
            })
            const result = await response.json();
            clearInputs();
            setAmountText('');
            alert(result.message);
        } catch (e) {
            alert(e);
        }
    }

    function setAmountText(amount) {
        amountDiv.innerHTML = 'стоимость перевозки: ' + amount + (amount ? ' руб': '');
    }

    function checkInputs() {
        let res = true;
        document.querySelectorAll('.req-input').forEach(function (input) {
            if (input.value === '') {
                res = false;
            }
        })
        return res;
    }

    function clearInputs() {
        document.querySelectorAll('.req-input').forEach(function (input) {
            input.value = '';
        })
    }

</script>
