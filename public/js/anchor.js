const transport = new AnchorLinkBrowserTransport()
const link = new AnchorLink({
    transport,
    chains: [
        {
            chainId: '1064487b3cd1a897ce03ae5b6a865651747e2e152090f99c1d19d44e01aea5a4',
            nodeUrl: 'https://wax.greymass.com',
        }
    ],
})

async function anchorLogin(){
    const identity = await link.login('mydapp')
    const {session} = identity
    let login = `${session.auth}`;
    let publicKey = `${session.publicKey}`;
    login = login.split('@')[0];
    console.log(publicKey)
    sendLoginRequest(login);

}
