module.exports = (app) => {

    const path = require("path")
    app.get('/', (req, res) => {
        if (!req.query.f) {
            if (req.session.isLogin === 1)
                return res.redirect("/?f=calc.html");
            else
                return res.redirect("/?f=login.html");
        }
        let f = req.query.f
        res.sendFile(path.join(__dirname + "/../views", f))
    })

    app.post('/', (req, res) => {
        if (!req.body.username || typeof req.body.username !== 'string') {
            req.status(403).end( "forbidden" )
            return
        }
        req.session.name = req.body.username;
        req.session.isLogin = 1;
        res.redirect("/?f=calc.html")
    })

}