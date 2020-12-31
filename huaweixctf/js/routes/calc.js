module.exports = (app) => {

    const ip = require("ip");

    const {checkip, checkmask} = require("./util")

    app.post('/calc', (req, res) => {
        res.set({"Content-Type" : "application/json;charset=utf-8"})

        if (req.body.ip_1 === undefined
            || req.body.ip_2 === undefined
            || req.body.ip_3 === undefined
            || req.body.ip_4 === undefined
            ||  req.body.netmask === undefined ) {
            return res.json( {
                "code": -1
            })
        }

        let user_ip = `${req.body.ip_1}.${req.body.ip_2}.${req.body.ip_3}.${req.body.ip_4}`
        let netmask = req.body.netmask
        if (!checkip(user_ip) || !checkmask(netmask))
            return res.json( {
                "code": -1
            })

        //calculate
        let ipsubnet = ip.cidrSubnet(`${user_ip}/${netmask}`)
        let result = {
            "code" : 0,
            "numofaddr" : `${ipsubnet.numHosts}`,
            "snm" : ipsubnet.subnetMask,
            "nwadr" : ipsubnet.networkAddress,
            "firstadr" : ipsubnet.firstAddress,
            "lastadr" : ipsubnet.lastAddress,
            "bcast" : ipsubnet.networkAddress
        }

        return res.json(result)
    })

}