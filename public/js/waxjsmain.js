const userAccount = getMeta('userAccount');
const pubKeys = JSON.parse(getMeta('pubKeys'));
const wax = new waxjs.WaxJS('https://wax.greymass.com', userAccount, pubKeys, false);

function getMeta(metaName) {
    const metas = document.getElementsByTagName('meta');

    for (let i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute('name') === metaName) {
            if (metas[i].getAttribute('content') === ""){
                return null
            }
            return metas[i].getAttribute('content');
        }
    }

    return null;
}

function queryGenerator(params) {
    let query = "";
    for (const [key, value] of Object.entries(params)) {
        query += `${key}=${value}&`;
    }
    return query;
}

//automatically check for credentials
autoLogin();

//checks if autologin is available
async function autoLogin() {
    let isAutoLoginAvailable = await wax.isAutoLoginAvailable();
    if (isAutoLoginAvailable) {
        let userAccount = wax.userAccount;
        let pubKeys = wax.pubKeys;
    } else {
        console.log('error')
    }
}

//normal login. Triggers a popup for non-whitelisted dapps
async function login() {
    try {
        //if autologged in, this simply returns the userAccount w/no popup
        let userAccount = await wax.login();
        let pubKeys = wax.pubKeys;
        console.log(wax);
        document.getElementById('loginBtn').innerText = userAccount;
        sendLoginRequest(userAccount, pubKeys);
        $('#loginModal').modal('hide')
    } catch (e) {
        console.log(e.message);
    }
}

async function get_transaction(transaction_id){
    let transaction_result = await wax.rpc.history_get_transaction(transaction_id);
    console.log(transaction_result);
}





