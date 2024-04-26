const form = document.querySelector("form");
const amountDiv = document.querySelector('.amount');

if (form) {
    form.addEventListener("submit", handleFormSubmit);
}

async function calculate() {
    if (checkInputs()) {
        try {
            const response = await fetch("/api/order/calculate", {
                headers: {
                    "Accept": "application/json",
                },
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
            headers: {
                "Accept": "application/json",
            },
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
