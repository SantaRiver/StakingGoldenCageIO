function timer() {
    setInterval(function () {
        let now = new Date();
        let endHour = new Date();
        endHour.setHours(now.getHours() + 1, 0, 0, 0);
        let difference = new Date(endHour - now);
        let second = difference.getSeconds();
        let minutes = difference.getMinutes();
        if (difference.getSeconds() < 10){
            second = 0 + second.toString();
        }
        if (difference.getMinutes() < 10){
            minutes = 0 + minutes.toString();
        }
        let claimBtn = document.getElementById('claimBtn')
        let balance = document.getElementById('balance');
        let totalDrip = document.getElementById('totalDrip');
        if (minutes + ':' + second === '00:00'){
            if (claimBtn.innerText === 'Claim!'){
                claimBtn.disabled = false;
            }
            balance.innerText = (parseFloat(balance.innerText) + parseFloat(totalDrip.innerText)).toFixed(4).toString();
        }
        document.getElementById('timer').innerText = minutes + ':' + second;
    }, 990);
}

function claimTimer(last_day_tomorrow){
    setInterval(function () {
        let now = new Date();
        let endHour = new Date(last_day_tomorrow);
        let difference = new Date(endHour - now);
        let second = difference.getSeconds();
        let minutes = difference.getMinutes();
        if (difference.getSeconds() < 10){
            second = 0 + second.toString();
        }
        if (difference.getMinutes() < 10){
            minutes = 0 + minutes.toString();
        }
        let claimBtn = document.getElementById('claimBtn');
        claimBtn.disabled = true;
        claimBtn.innerText = difference.getHours() + ':' + minutes + ':' + second;
    }, 990);
}

function claim(){
    $.ajax({
        type: 'GET',
        url: '/staking/claim',
        success: function (response) {
            if (response['status'] === 'success'){
                let claimBtn = document.getElementById('claimBtn');
                let totalClaimable = document.getElementById('totalClaimable');
                let balance = document.getElementById('balance');
                totalClaimable.innerText = (parseFloat(totalClaimable.innerText) + parseFloat(balance.innerText)).toFixed(4).toString();
                balance.innerText = '0 WAX';
                claimBtn.disabled = true;
                const today = new Date()
                const tomorrow = new Date(today)
                tomorrow.setDate(tomorrow.getDate() + 1)
                claimTimer(tomorrow);
            }
        }
    });
}

function sendLoginRequest(userAccount, pubKeys = []) {
    $.ajax({
        type: 'POST',
        url: '/auth',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'wallet': userAccount,
            'pubKeys' : (pubKeys) ? JSON.stringify(pubKeys) : null
        },
        success: function (response) {
            location.reload();
        }
    });
}

function saveAllCards(){
    let cards = document.getElementsByClassName('cardGC')
    let data = [];
    cards.forEach(function (card){
        let cardData = {};
        card.elements.forEach(function (input){
            if (input.tagName === 'INPUT' && input.name && input.name !== '_token'){
                if (input.type === 'checkbox'){
                    cardData[input.name] = input.checked;
                } else {
                    cardData[input.name] = input.value;
                }
            }
        })
        data.push(cardData);
    })
    $.ajax({
        type: 'POST',
        url: '/dashboard/update/cards',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'cards': data,
        },
        success: function (response) {
            if (response['status'] === 'success'){
                alert('Cards update successfully');
            }
        }
    });
}

