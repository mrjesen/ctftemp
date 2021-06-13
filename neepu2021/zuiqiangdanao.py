import requests
import re

s =requests.Session()
url = "http://www.neepusec.club:18514/"
def getmidstring(html, start_str, end):
    start = html.find(start_str)
    if start >= 0:
        start += len(start_str)
        end = html.find(end, start)
        if end >= 0:
            return html[start:end].strip()
for i in range(120):
    if(i == 0):
        r =s.post(url)
    searchObj = getmidstring(r.text,"<p>","&nbsp=&nbsp").replace("&nbsp", "")
    res = int(eval(searchObj))
    print(res)
    data = {
        "answer":res,
        "submit":"d"
    }
    r = s.post(url,data=data)
    
    if i >= 97 and "success" in r.text:
        print(r.text)