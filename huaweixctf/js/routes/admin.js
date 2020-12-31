module.exports = (app, env) => {

    const {htmlencode, replaceAll, md5} = require("./util")
    const fs = require("fs")
    const path = require("path")

    app.get('/admin', (req, res) => {
        let user
        try {
            user = JSON.parse(`{"name" : "${req.session.name}", "time" : "${Math.ceil(new Date().getTime() / 1000)}", "ip" : "${req.ip}"}`)
        } catch (e) {
            res.end("error")
            return
        }
        let userinfo = {}
        Object.keys(user).forEach((key) => {
            if (key.trim() === "isAdmin")
                userinfo[key] = 0
            else userinfo[key] = user[key]
        })
        
        if (req.session.ip === '127.0.0.1')
            userinfo.isAdmin = 1;

        req.session.name = userinfo.name
        req.session.time = userinfo.time
        req.session.ip = userinfo.ip
        req.session.isAdmin = userinfo.isAdmin

        if (req.session.isAdmin !== 1) {
            res.end("forbidden")
            return;
        }

        res.render("admin", {"name":req.session.name})
    })

    app.post("/admin", async (req, res)=>{
        if (!req.session.isAdmin || !req.body.code) {
            res.status(403).end("forbidden")
            return
        }

        let html = "name : {{name}}, time : {{time}}, ip : {{ip}} \ntips: {{env.banner}}<br><a href='/admin'>返回</a><br><br>\n\n" + fs.readFileSync(path.resolve(__dirname, "../views/calc.html"))
        let list = ['secret', 'env', 'flag', 'if', 'unless', 'for', 'lookup', '[', ']', '@' ]
        let code = req.body.code + ""
        let padd = `<p class="t-big-margin no-margin-b flex-center">这里开发中...&nbsp; <a href="/admin" target="_blank">去开发</a></p>`

        await list.forEach((black) => {
            code = replaceAll(black, htmlencode(black), code)
        })

        html = html.replace(padd, code)
        let filename = md5(html) + ".html"
        let filepath = path.resolve(__dirname, "../views/users/"+filename)
        if (fs.existsSync(filepath))
            fs.unlinkSync(filepath)
        fs.writeFile(filepath, html, err => {
            if (err) {
                res.end("error")
            } else {
                res.render("users/"+filename, {
                    "name" : req.session.name,
                    "time" : Math.ceil(new Date().getTime() / 1000),
                    "ip" : req.ip,
                    "env" : env.parsed
                })
            }
        })

    })

}