const htmlencode = function (s) {
    let resu = ''
    for (let i in s ) {
        resu += `&#${int2hex(s[i].charCodeAt())};`
    }
    return resu
}

const int2hex = function (num) {
    let hex = "0123456789abcdef";
    let s = "";
    while (num) {
        s = hex.charAt(num % 16) + s;
        num = Math.floor(num / 16);
    }
    return "x" + s
}

const replaceAll = function (find, replace, str) {
    var find = find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    return str.replace(new RegExp(find, 'g'), replace);
}

const md5 = function (s)
{
    return require("crypto").createHash('md5').update(s).digest('hex')
}

const checkip = function (ipaddr) {
    let re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/;
    if (re.test(ipaddr))
    {
        let parts = ipaddr.split(".");
        if (parseInt(parseFloat(parts[0])) == 0)
            return false;
        if (parseInt(parseFloat(parts[3])) == 0)
            return false;
        for (var i=0; i<parts.length; i++) {
            if (parseInt(parseFloat(parts[i])) > 254)
                return false;
        }
        return true;
    } else return false;
}

const checkmask = function (mask) {
    if (parseInt(mask) >=0 && parseInt(mask)<=32)
        return true
    return false
}

exports.htmlencode = htmlencode
exports.replaceAll = replaceAll
exports.md5 = md5
exports.checkmask = checkmask
exports.checkip = checkip