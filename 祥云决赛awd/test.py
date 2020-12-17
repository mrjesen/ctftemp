import paramiko,requests,re
teamtoken = '07132d78f26e4280ac8b5ffdc0383922'
for i in range(99999):
    try:
        payload = {'flag':'flag{78704230902fda4e853443144303b44dcd5cd548}'}
        head = {
            'Authorization':teamtoken,
            'Content-Type':'application/json'
        }
        res_flag = requests.post("http://183.220.1.118:8888/api/flag",json=payload,headers=head,timeout=1)
        print res_flag.text
    except:
        print ''