const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const hbs = require('hbs');
const session = require('express-session');
const FileStore = require('session-file-store')(session);
const env = require('dotenv').config()
const app = express();

app.use(express.static(path.join(__dirname, 'public')));
app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json());
app.use(session({
    name: "session",
    secret: env.parsed.secret,
    resave: false,
    saveUninitialized: true,
    store: new FileStore({path: __dirname+'/sessions/'})
}));
app.use((req,res,next) => {
    if (!req.session.isLogin) {
        req.session.isLogin = 0;
    }
    next()
})

app.set('views', path.join(__dirname, "views/"))
app.engine('html', hbs.__express);
app.set('view engine', 'html');
app.set('views', __dirname + '/views');

require("./routes/calc.js")(app)
require("./routes/login.js")(app)
require("./routes/admin.js")(app, env)

app.listen(80, "0.0.0.0", () => {
    console.log("0.0.0.0:80")
});